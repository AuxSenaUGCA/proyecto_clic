<?php

use App\Http\Controllers\ClicController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CubeController;
use App\Http\Controllers\SentenceController;

Route::get('/', function () {
    return view('main');
})->name('home');


Route::prefix('cubes')->group(function () {
    Route::get('/index', [CubeController::class, 'index'])->name('cubes.index'); // Listar todos
    Route::get('/show/{id}', [CubeController::class, 'show'])->name('cubes.show'); // Consultar
    Route::post('/store', [CubeController::class, 'store'])->name('cubes.store'); // Crear
    Route::put('/update/{id_cube}', [CubeController::class, 'update'])->name('cubes.update'); // Actualizar
    Route::delete('/delete/{id_cube}', [CubeController::class, 'destroy'])->name('cubes.destroy'); // Eliminar)
});

Route::prefix('sentences')->group(function () {
    Route::get('/index', [SentenceController::class, 'index'])->name('sentences.index'); // Listar todos
    Route::get('/show/{id}', [SentenceController::class, 'show'])->name('sentences.show'); // Consultar
    Route::post('/store', [SentenceController::class, 'store'])->name('sentences.store'); // Crear
    Route::put('/update/{id_sentence}', [SentenceController::class, 'update'])->name('sentences.update'); // Actualizar
    Route::delete('/delete/{id_sentence}', [SentenceController::class, 'destroy'])->name('sentences.destroy'); // Eliminar
    Route::get('/search', [SentenceController::class, 'search'])->name('sentences.search'); // Buscar
});

Route::get('/Test/{dato}', [ClicController::class, 'index']);
