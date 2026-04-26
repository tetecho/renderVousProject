<?php

use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\RendezVousController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/locale/{locale}', function (Request $request, string $locale) {
    $availableLocales = config('app.available_locales', ['fr', 'en', 'es', 'ar']);
    if (in_array($locale, $availableLocales, true)) {
        $request->session()->put('locale', $locale);
    }

    return redirect()->back();
})->name('locale.switch');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('patient')->group(function () {
    Route::get('/',[PatientController::class, 'index'])->name('patient.index');
    Route::post('/',[PatientController::class, 'store'])->name('patient.store');
    Route::get('/create',[PatientController::class, 'create'])->name('patient.create');
    Route::get('/{id}',[PatientController::class, 'show'])->name('patient.show');
    Route::get('/{id}/edit',[PatientController::class, 'edit'])->name('patient.edit');
    Route::put('/{id}',[PatientController::class, 'update'])->name('patient.update');
    Route::delete('/{id}',[PatientController::class, 'destroy'])->name('patient.destroy');
});
Route::middleware('auth')->prefix('medecin')->group(function () {
    Route::get('/',[MedecinController::class, 'index'])->name('medecin.index');
    Route::post('/',[MedecinController::class, 'store'])->name('medecin.store');
    Route::get('/create',[MedecinController::class, 'create'])->name('medecin.create');
    Route::get('/{id}',[MedecinController::class, 'show'])->name('medecin.show');
    Route::get('/{id}/edit',[MedecinController::class, 'edit'])->name('medecin.edit');
    Route::put('/{id}',[MedecinController::class, 'update'])->name('medecin.update');
    Route::delete('/{id}',[MedecinController::class, 'destroy'])->name('medecin.destroy');
});

Route::middleware('auth')->prefix('rendezvous')->group(function () {
    Route::get('/', [RendezVousController::class, 'index'])->name('rendezvous.index');
    Route::post('/', [RendezVousController::class, 'store'])->name('rendezvous.store');
    Route::patch('/{id}/confirm', [RendezVousController::class, 'confirm'])->name('rendezvous.confirm');
    Route::patch('/{id}/cancel', [RendezVousController::class, 'cancel'])->name('rendezvous.cancel');
    Route::get('/search', [RendezVousController::class, 'search'])->name('rendezvous.search');
    Route::get('/available-doctors', [RendezVousController::class, 'availableDoctors'])->name('rendezvous.available-doctors');
    Route::get('/{id}', [RendezVousController::class, 'show'])->name('rendezvous.show');
    Route::get('/{id}/edit', [RendezVousController::class, 'edit'])->name('rendezvous.edit');
    Route::put('/{id}', [RendezVousController::class, 'update'])->name('rendezvous.update');
    Route::delete('/{id}', [RendezVousController::class, 'destroy'])->name('rendezvous.destroy');
});

require __DIR__ . '/auth.php';
