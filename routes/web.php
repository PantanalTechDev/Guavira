<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GuaviraController;
use Illuminate\Support\Facades\Route;

Route::get('/guaviras', [GuaviraController::class, 'map'])->name('guavira.map');

Route::get('/nova/guavira', [GuaviraController::class, 'create'])->name('guavira.create');
Route::post('/nova/guavira', [GuaviraController::class, 'store'])->name('guavira.store');

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

require __DIR__.'/auth.php';
