<?php

use App\Http\Controllers\ClicController;
use App\Http\Controllers\CubeController;
use App\Http\Controllers\SentenceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('cubes')->group(function () {
    Route::get('/index', [CubeController::class, 'index'])->name('cubes.index'); // Listar todos
    Route::get('/show/{id}', [CubeController::class, 'show'])->name('cubes.show'); // Consultar
    Route::post('/store', [CubeController::class, 'store'])->name('cubes.store'); // Crear
    Route::put('/update/{id_cube}', [CubeController::class, 'update'])->name('cubes.update'); // Actualizar
    Route::delete('/delete/{id_cube}', [CubeController::class, 'destroy'])->name('cubes.destroy'); // Eliminar)
});

Route::prefix('users')->group(function () {
    Route::get('/index', [UserController::class, 'index'])->name('users.index'); // Listar todos
    Route::get('/show/{id}', [UserController::class, 'show'])->name('users.show'); // Consultar un usuario
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('users.update'); // Actualizar usuario
    Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy'); // Eliminar usuario
    Route::get('/search', [UserController::class, 'search'])->name('users.search'); // Buscar
});

Route::prefix('sentences')->group(function () {
    Route::get('/sentencesActives', [SentenceController::class, 'indexActive']);
});


Route::get('/Test/{dato}', [ClicController::class, 'index']);
