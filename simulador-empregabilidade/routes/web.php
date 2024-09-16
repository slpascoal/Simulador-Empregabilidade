<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
    Define uma rota GET '/' que usa o método index do UserController para retornar a lista de usuários filtrados.
    Ela pode ser nomeada como "users.index" (Escolhi isso para tratar um erro da API Púlbica,
    que não identificava QUERY PARAMETERS em branco)
*/
Route::get('/', [UserController::class, 'index'])->name('users.index');

/*
    Mantenha uma rota GET com caminho '/users' como um alias, como forma também de otimizar a busca em "UserController"
*/
Route::get('/users', [UserController::class, 'index']);
