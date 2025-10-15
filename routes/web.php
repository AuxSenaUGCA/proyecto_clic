<?php

use App\Http\Controllers\ClicController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CubeController;
use App\Http\Controllers\SentenceController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('main');
})->name('sentences');

Route::get('/users', function () {
    return view('users');
})->name('users');

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


Route::prefix('users')->group(function () {
    Route::get('/index', [UserController::class, 'index'])->name('users.index'); // Listar todos
    Route::get('/show/{id}', [UserController::class, 'show'])->name('users.show'); // Consultar un usuario
    Route::post('/store', [UserController::class, 'store'])->name('users.store'); // Crear usuario
    Route::put('/update/{id}', [UserController::class, 'update'])->name('users.update'); // Actualizar usuario
    Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy'); // Eliminar usuario
    Route::get('/search', [UserController::class, 'search'])->name('users.search'); // Buscar
});


Route::get('/Test/{dato}', [ClicController::class, 'index']);
