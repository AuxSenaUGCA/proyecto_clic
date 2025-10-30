<?php

use App\Http\Controllers\ClicController;
use App\Http\Controllers\CubeController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SentenceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('cubes')->group(function () {
    Route::get('/index', [CubeController::class, 'index'])->name('cubes.index'); 
    Route::get('/show/{id}', [CubeController::class, 'show'])->name('cubes.show'); 
    Route::post('/store', [CubeController::class, 'store'])->name('cubes.store');
    Route::put('/update/{id_cube}', [CubeController::class, 'update'])->name('cubes.update'); 
    Route::delete('/delete/{id_cube}', [CubeController::class, 'destroy'])->name('cubes.destroy'); 
});

Route::prefix('users')->group(function () {
    Route::get('/index', [UserController::class, 'index'])->name('users.index');
    Route::get('/show/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('users.update'); 
    Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy'); 
    Route::get('/search', [UserController::class, 'search'])->name('users.search'); 
});

Route::prefix('sentences')->group(function () {
    Route::get('/sentencesActives', [SentenceController::class, 'indexActive']);
});

Route::prefix('sections')->group(function () {
    Route::get('/index', [SectionController::class, 'index'])->name('sections.index'); 
    Route::get('/indexActive', [SectionController::class, 'indexActive'])->name('sections.indexActive'); 
});
