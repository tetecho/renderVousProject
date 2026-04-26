<?php

use App\Http\Controllers\RendezVousController;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API REST — Lister les rendez-vous au format JSON
Route::get('/rendezvous', function () {
    return response()->json(
        RendezVous::with(['patient', 'medecin', 'service'])
            ->orderBy('date_heure', 'desc')
            ->get()
    );
});

// API REST — Créer un rendez-vous via requête externe
Route::post('/rendezvous', function (Request $request) {
    $validated = $request->validate([
        'patient_id'  => [
            'required',
            Rule::exists('users', 'id')->where(fn ($query) => $query->where('role', 'patient')),
        ],
        'medecin_id'  => [
            'required',
            Rule::exists('users', 'id')->where(fn ($query) => $query->where('role', 'medecin')),
        ],
        'service_id'  => 'required|exists:services,id',
        'date_heure'  => 'required|date|after:now',
    ]);

    // 1-hour slot conflict checks
    $requestedTime = \Carbon\Carbon::parse($validated['date_heure']);
    $doctorBusy = RendezVous::where('medecin_id', $validated['medecin_id'])
        ->where('statut', '!=', 'annule')
        ->where('date_heure', '>', $requestedTime->copy()->subHour())
        ->where('date_heure', '<', $requestedTime->copy()->addHour())
        ->exists();

    if ($doctorBusy) {
        return response()->json([
            'error' => 'Ce médecin a déjà un rendez-vous dans ce créneau d\'une heure.'
        ], 422);
    }

    $patientBusy = RendezVous::where('patient_id', $validated['patient_id'])
        ->where('statut', '!=', 'annule')
        ->where('date_heure', '>', $requestedTime->copy()->subHour())
        ->where('date_heure', '<', $requestedTime->copy()->addHour())
        ->exists();

    if ($patientBusy) {
        return response()->json([
            'error' => 'Ce patient a déjà un rendez-vous dans ce créneau d\'une heure.'
        ], 422);
    }

    $validated['statut'] = 'en_attente';
    $rdv = RendezVous::create($validated);

    return response()->json(
        $rdv->load(['patient', 'medecin', 'service']),
        201
    );
});
