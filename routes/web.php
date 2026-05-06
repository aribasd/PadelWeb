<?php

use App\Http\Controllers\PartitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PistaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\PerfilEstadisticaController;

use App\Http\Controllers\IniciController;
use App\Http\Controllers\ComunitatController;
use App\Http\Controllers\GaleriaController;

use App\Http\Controllers\MissatgeController;
use App\Http\Controllers\DirectMessageController;

use Illuminate\Support\Facades\Route;



Route::get('/test', function () {
    return view('test');
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('pistes', PistaController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
});
Route::resource('pistes', PistaController::class)->only(['index', 'show']);


Route::middleware('auth')->group(function () {
    Route::resource('reserves', ReservaController::class);
});


/* Auth Comunitat */

Route::middleware('auth')->get('comunitats/meves', [ComunitatController::class, 'meves'])->name('comunitats.meves');

Route::middleware('auth')->group(function () {
    Route::post('comunitats/{comunitat}/join', [ComunitatController::class, 'join'])->name('comunitats.join');
    Route::delete('comunitats/{comunitat}/leave', [ComunitatController::class, 'leave'])->name('comunitats.leave');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('comunitats', ComunitatController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
});
Route::resource('comunitats', ComunitatController::class)->only(['index', 'show']);

Route::get('comunitats/{comunitat}/missatges', [MissatgeController::class, 'index'])->name('comunitats.missatges');
Route::middleware('auth')->post('comunitats/{comunitat}/missatges', [MissatgeController::class, 'store'])->name('comunitats.missatges.store');

Route::resource('inici', IniciController::class);

Route::resource('partits', PartitController::class);

Route::get('/galeria', [GaleriaController::class, 'index'])->name('galeria.index');

Route::resource('perfils_estadistiques', PerfilEstadisticaController::class);

Route::resource('users', \App\Http\Controllers\UserController::class)->only(['show']);

Route::get('geocoding/search', [\App\Http\Controllers\GeocodingController::class, 'search'])->name('geocoding.search');

Route::middleware('auth')->group(function () {      
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('friendships', [\App\Http\Controllers\FriendshipController::class, 'store'])->name('friendships.store');
    Route::patch('friendships/{friendship}/accept', [\App\Http\Controllers\FriendshipController::class, 'accept'])->name('friendships.accept');
    Route::patch('friendships/{friendship}/decline', [\App\Http\Controllers\FriendshipController::class, 'decline'])->name('friendships.decline');
    Route::delete('friendships/{friendship}', [\App\Http\Controllers\FriendshipController::class, 'destroy'])->name('friendships.destroy');

    Route::get('social/missatges/{user?}', [DirectMessageController::class, 'index'])->name('social.missatges');
    Route::post('social/missatges/{user}', [DirectMessageController::class, 'store'])->name('social.missatges.store');

    Route::middleware('role:admin')->group(function () {
        Route::get('comunitats/{comunitat}/pistes/create', [\App\Http\Controllers\PistaController::class, 'createForComunitat'])->name('comunitats.pistes.create');
        Route::post('comunitats/{comunitat}/pistes', [\App\Http\Controllers\PistaController::class, 'storeForComunitat'])->name('comunitats.pistes.store');

        Route::post('/galeria', [GaleriaController::class, 'store'])->name('galeria.store');
    });
});

require __DIR__.'/auth.php';
