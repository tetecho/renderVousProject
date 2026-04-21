<?php

use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
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
require __DIR__ . '/auth.php';
