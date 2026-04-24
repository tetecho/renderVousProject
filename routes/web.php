<?php

use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MedecinController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
require __DIR__ . '/auth.php';
