<?php

use App\Http\Controllers\SentenceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TeacherController;

Route::get('/', function () {
    return view('main');
})->name('sentences');

Route::get('/users', function () {
    return view('users');
})->name('users');

Route::prefix('sentences')->group(function () {
    Route::get('/index', [SentenceController::class, 'index'])->name('sentences.index'); 
    Route::get('/indexSection/{id_section}', [SentenceController::class, 'indexBySection'])->name('sentences.bySection');
    Route::get('/show/{id}', [SentenceController::class, 'show'])->name('sentences.show'); 
    Route::post('/store', [SentenceController::class, 'store'])->name('sentences.store'); 
    Route::put('/update/{id_sentence}', [SentenceController::class, 'update'])->name('sentences.update'); 
    Route::delete('/delete/{id_sentence}', [SentenceController::class, 'destroy'])->name('sentences.destroy'); 
    Route::get('/search', [SentenceController::class, 'search'])->name('sentences.search'); 
});

Route::prefix('users')->group(function () {
    Route::get('/index', [UserController::class, 'index'])->name('users.index');
    Route::get('/show/{id}', [UserController::class, 'show'])->name('users.show'); 
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy'); 
    Route::get('/search', [UserController::class, 'search'])->name('users.search'); 
    Route::post('/clear', [UserController::class, 'clearAll'])->name('users.clear');
    Route::post('/clear/{id}', [UserController::class, 'clearOne'])->name('users.clearOne');
    Route::delete('/destroyAll', [UserController::class, 'destroyAll'])->name('users.destroyAll');
});

Route::prefix('sections')->group(function () {
    Route::get('/indexPaginated', [SectionController::class, 'indexPaginated'])->name('sections.indexPaginated'); 
    Route::get('/show/{id_section}', [SectionController::class, 'show'])->name('sections.show'); 
    Route::post('/store', [SectionController::class, 'store'])->name('sections.store'); 
    Route::put('/update/{id_section}', [SectionController::class, 'update'])->name('sections.update'); 
    Route::delete('/delete/{id_section}', [SectionController::class, 'destroy'])->name('sections.destroy');
    Route::get('/search', [SectionController::class, 'search'])->name('sections.search'); 
});

Route::prefix('teachers')->group(function () {
    Route::get('/index', [TeacherController::class, 'index'])->name('teachers.index');   
    Route::get('/show/{id}', [TeacherController::class, 'show'])->name('teachers.show');
    Route::post('/store', [TeacherController::class, 'store'])->name('teachers.store');    
    Route::put('/update/{id}', [TeacherController::class, 'update'])->name('teachers.update'); 
    Route::delete('/delete/{id}', [TeacherController::class, 'destroy'])->name('teachers.destroy'); 
});
