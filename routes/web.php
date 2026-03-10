<?php

use App\Http\Controllers\PartitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PistaController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::resource('pistes', PistaController::class);

Route::resource('reserves', ReservaController::class);

Route::resource('partits', PartitController::class);

Route::middleware('auth')->group(function () {      
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
