<?php

use App\Models\Pista;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PistaController;


Route::get('/', function () {
    return view('welcome');
});


Route :: resource ('pistes', PistaController::class);
