<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/docs/api');
});

Route::get('/reset-password/{token}', function () {
    return response()->json(['message' => 'Usa la app para restablecer tu contraseña.']);
})->name('password.reset');

Route::get('/login', function () {
    return response()->json(['message' => 'Usa la app para iniciar sesión.'], 401);
})->name('login');
