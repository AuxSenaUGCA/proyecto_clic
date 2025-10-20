<?php

use App\Http\Controllers\SentenceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
})->name('sentences');

Route::get('/users', function () {
    return view('users');
})->name('users');

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
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy'); // Eliminar usuario
    Route::get('/search', [UserController::class, 'search'])->name('users.search'); // Buscar
    Route::post('/clear', [UserController::class, 'clearAll'])->name('users.clear');
    Route::post('/clear/{id}', [UserController::class, 'clearOne'])->name('users.clearOne');
    Route::delete('/destroyAll', [UserController::class, 'destroyAll'])->name('users.destroyAll');
});
