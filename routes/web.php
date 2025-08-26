<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FacilityController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FacilityController::class, 'index'])->middleware(['auth', 'verified'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('facilities', FacilityController::class);
    Route::get('facilities-export', [FacilityController::class, 'exportCsv'])->name('facilities.export');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
