<?php

use App\Http\Controllers\ClicController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/Prueba/{dato}', [ClicController::class, 'index']);
