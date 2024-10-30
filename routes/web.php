<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GuaviraController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerificationController;

//Route::get('/guaviras', [GuaviraController::class, 'map'])->name('guavira.map');
Route::redirect('/', '/home');
Route::get('/home', [GuaviraController::class, 'home'])->name('guavira.home');
Route::get('/mapa', [GuaviraController::class, 'map'])->name('guavira.map');

Route::middleware('auth')->group(function () {
    Route::get('/nova/guavira', [GuaviraController::class, 'create'])->name('guavira.create');
    Route::post('/nova/guavira', [GuaviraController::class, 'store'])->name('guavira.store');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
