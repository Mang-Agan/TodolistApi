<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodolistController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('auth')->middleware('throttle:60,1')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::prefix('checklist')->middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    Route::get('/', [TodolistController::class, 'getAll'])->name('checklist.all');
    Route::post('/', [TodolistController::class, 'create'])->name('checklist.create');
    Route::delete('/{id}', [TodolistController::class, 'destroy'])->name('checklist.delete');
    Route::put('/{id}', [TodolistController::class, 'checkTodo'])->name('checklist.check');
    Route::patch('/update', [TodolistController::class, 'updateTodo'])->name('checklist.update');
});

Route::prefix('user')->middleware('throttle:60,1')->group(function () {
    Route::post('/register', [UserController::class, 'register'])->name('user.register');
});
