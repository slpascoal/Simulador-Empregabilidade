<?php

use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    // Consome a API pública
    $response = Http::get('https://random-data-api.com/api/v2/users?size=100');
    $users = $response->json();

    return view('index', compact('users'));
});
