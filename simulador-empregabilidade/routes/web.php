<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Defina a rota para '/' e dê o nome 'users.index'
Route::get('/', [UserController::class, 'index'])->name('users.index');

// Mantenha a rota /users como um alias, se preferir
Route::get('/users', [UserController::class, 'index']);
