<?php

namespace App\Http\Controllers;

use App\Mail\RendezVousConfirmedMail;
use Illuminate\Database\Eloquent\Builder;
use App\Models\RendezVous;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Throwable;

class RendezVousController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = $this->currentUser();

        $rendezVous = $this->applyRoleScope(
            RendezVous::with(['patient', 'medecin', 'service']),
            $user
        )
            ->orderBy('date_heure', 'desc')
            ->paginate(5);

        $patients = $user->isAdmin()
            ? User::where('role', 'patient')->paginate(5)
            : User::whereKey($user->id)->paginate(5);
        $medecins = User::where('role', 'medecin')->get();
        $services = Service::all();

        return view('rendezVous.index', compact('rendezVous', 'patients', 'medecins', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->ensureCanCreate();

        $user = $this->currentUser();
        $patients = $user->isAdmin()
            ? User::where('role', 'patient')->get()
            : User::whereKey($user->id)->get();
        $medecins = User::where('role', 'medecin')->get();
        $services = Service::all();

        return view('rendezVous.create', compact('patients', 'medecins', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $this->currentUser();
        $this->ensureCanCreate();

        $baseRules = [
            'medecin_id' => [
                'required',
                Rule::exists('users', 'id')->where(fn ($query) => $query->where('role', 'medecin')),
            ],
            'service_id' => 'required|exists:services,id',
            'date_heure' => 'required|date|after:now',
        ];

        if ($user->isAdmin()) {
            $validated = $request->validate(array_merge($baseRules, [
                'patient_id' => [
                    'required',
                    Rule::exists('users', 'id')->where(fn ($query) => $query->where('role', 'patient')),
                ],
            ]));
        } else {
            $validated = $request->validate($baseRules);
            $validated['patient_id'] = $user->id;
        }

        $requestedTime = \Carbon\Carbon::parse($validated['date_heure']);

        if ($this->hasOneHourConflict('medecin_id', (int) $validated['medecin_id'], $requestedTime)) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('Ce médecin a déjà un rendez-vous dans ce créneau d\'une heure. Veuillez choisir une autre heure.'));
        }

        if ($this->hasOneHourConflict('patient_id', (int) $validated['patient_id'], $requestedTime)) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('Ce patient a déjà un rendez-vous dans ce créneau d\'une heure. Veuillez choisir une autre heure.'));
        }

        $validated['statut'] = 'en_attente';

        RendezVous::create($validated);

        return redirect()->route('rendezvous.index')
            ->with('success', __('Rendez-vous créé avec succès.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rendezVous = RendezVous::with(['patient', 'medecin', 'service'])->findOrFail($id);

        abort_unless(
            $this->canViewRendezVous($rendezVous),
            403,
            __('Action non autorisée.')
        );

        return view('rendezVous.show', compact('rendezVous'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->ensureAdmin();

        $rendezVous = RendezVous::with(['patient', 'medecin', 'service'])->findOrFail($id);
        $patients = User::where('role', 'patient')->get();
        $medecins = User::where('role', 'medecin')->get();
        $services = Service::all();

        return view('rendezVous.modify', compact('rendezVous', 'patients', 'medecins', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->ensureAdmin();

        $rendezVous = RendezVous::findOrFail($id);
        $previousStatut = $rendezVous->statut;

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
            'date_heure'  => 'required|date',
            'statut'      => 'required|in:en_attente,confirme,annule',
        ]);

        $requestedTime = \Carbon\Carbon::parse($validated['date_heure']);

        if ($this->hasOneHourConflict('medecin_id', (int) $validated['medecin_id'], $requestedTime, (int) $id)) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('Ce médecin a déjà un rendez-vous dans ce créneau d\'une heure. Veuillez choisir une autre heure.'));
        }

        if ($this->hasOneHourConflict('patient_id', (int) $validated['patient_id'], $requestedTime, (int) $id)) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('Ce patient a déjà un rendez-vous dans ce créneau d\'une heure. Veuillez choisir une autre heure.'));
        }

        $rendezVous->update($validated);

        if ($previousStatut !== 'confirme' && $rendezVous->statut === 'confirme') {
            $this->sendConfirmationEmailToPatient($rendezVous);
        }

        return redirect()->route('rendezvous.index')
            ->with('success', __('Rendez-vous mis à jour avec succès.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->ensureAdmin();

        RendezVous::findOrFail($id)->delete();
        return redirect()->route('rendezvous.index')
            ->with('success', __('Rendez-vous supprimé avec succès.'));
    }

    /**
     * Cancel a rendez-vous (patient/medecin owner or admin).
     */
    public function cancel(string $id)
    {
        $rendezVous = RendezVous::findOrFail($id);

        abort_unless(
            $this->canCancelRendezVous($rendezVous),
            403,
            __('Action non autorisée.')
        );

        if ($rendezVous->statut !== 'annule') {
            $rendezVous->update(['statut' => 'annule']);
        }

        return redirect()->back()
            ->with('success', __('Rendez-vous mis à jour avec succès.'));
    }

    /**
     * Confirm a rendez-vous directly (admin only).
     */
    public function confirm(string $id)
    {
        $this->ensureAdmin();

        $rendezVous = RendezVous::findOrFail($id);

        if ($rendezVous->statut !== 'confirme') {
            $rendezVous->update(['statut' => 'confirme']);
            $this->sendConfirmationEmailToPatient($rendezVous);
        }

        return redirect()->back()
            ->with('success', __('Rendez-vous confirmé avec succès.'));
    }

    /**
     * Get available doctors for a given date/time (Axios endpoint).
     */
    public function availableDoctors(Request $request)
    {
        $this->ensureCanCreate();

        $request->validate([
            'date_heure' => 'required|date',
        ]);

        $requestedTime = \Carbon\Carbon::parse($request->date_heure);

        // Find medecins that are busy in the requested 1-hour slot
        $busyMedecinIds = RendezVous::where('statut', '!=', 'annule')
            ->where('date_heure', '>', $requestedTime->copy()->subHour())
            ->where('date_heure', '<', $requestedTime->copy()->addHour())
            ->pluck('medecin_id')
            ->toArray();

        // Exclude appointment being edited if provided
        if ($request->has('exclude_id')) {
            $busyMedecinIds = RendezVous::where('statut', '!=', 'annule')
                ->where('id', '!=', $request->exclude_id)
                ->where('date_heure', '>', $requestedTime->copy()->subHour())
                ->where('date_heure', '<', $requestedTime->copy()->addHour())
                ->pluck('medecin_id')
                ->toArray();
        }

        $availableDoctors = User::where('role', 'medecin')
            ->whereNotIn('id', $busyMedecinIds)
            ->get(['id', 'name', 'email']);

        return response()->json($availableDoctors);
    }

    /**
     * Search rendez-vous via Axios (async search).
     */
    public function search(Request $request)
    {
        $query = $this->applyRoleScope(
            RendezVous::with(['patient', 'medecin', 'service']),
            $this->currentUser()
        );

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->whereHas('patient', function ($q2) use ($term) {
                    $q2->where('name', 'like', "%{$term}%");
                })
                ->orWhereHas('medecin', function ($q2) use ($term) {
                    $q2->where('name', 'like', "%{$term}%");
                })
                ->orWhereHas('service', function ($q2) use ($term) {
                    $q2->where('name', 'like', "%{$term}%");
                })
                ->orWhere('statut', 'like', "%{$term}%");
            });
        }

        $results = $query->orderBy('date_heure', 'desc')->get();

        return response()->json($results);
    }

    private function currentUser(): User
    {
        return request()->user();
    }

    private function ensureAdmin(): void
    {
        abort_unless($this->currentUser()->isAdmin(), 403, __('Action non autorisée.'));
    }

    private function ensureCanCreate(): void
    {
        $user = $this->currentUser();
        abort_unless($user->isAdmin() || $user->isPatient(), 403, __('Action non autorisée.'));
    }

    private function applyRoleScope(Builder $query, User $user): Builder
    {
        if ($user->isPatient()) {
            return $query->where('patient_id', $user->id);
        }

        if ($user->isMedecin()) {
            return $query->where('medecin_id', $user->id);
        }

        return $query;
    }

    private function canViewRendezVous(RendezVous $rendezVous): bool
    {
        $user = $this->currentUser();

        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isPatient()) {
            return (int) $rendezVous->patient_id === (int) $user->id;
        }

        if ($user->isMedecin()) {
            return (int) $rendezVous->medecin_id === (int) $user->id;
        }

        return false;
    }

    private function canCancelRendezVous(RendezVous $rendezVous): bool
    {
        $user = $this->currentUser();

        if ($user->isAdmin()) {
            return true;
        }

        return $this->canViewRendezVous($rendezVous);
    }

    private function hasOneHourConflict(string $column, int $userId, \Carbon\Carbon $requestedTime, ?int $excludeId = null): bool
    {
        $query = RendezVous::where($column, $userId)
            ->where('statut', '!=', 'annule')
            ->where('date_heure', '>', $requestedTime->copy()->subHour())
            ->where('date_heure', '<', $requestedTime->copy()->addHour());

        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    private function sendConfirmationEmailToPatient(RendezVous $rendezVous): void
    {
        $rendezVous->loadMissing(['patient', 'medecin', 'service']);

        if (!$rendezVous->patient || empty($rendezVous->patient->email)) {
            return;
        }

        try {
            Mail::to($rendezVous->patient->email)->send(new RendezVousConfirmedMail($rendezVous));
        } catch (Throwable $exception) {
            Log::error('Unable to send rendez-vous confirmation email.', [
                'rendezvous_id' => $rendezVous->id,
                'patient_id' => $rendezVous->patient_id,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
