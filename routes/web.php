<?php

use Illuminate\Support\Facades\Route;

// Web route kept for health check. No frontend redirect needed.
Route::get('/', function () {
    return response()->json(['message' => 'BudgetApp API backend operativo.'], 200);
});

Route::get('/login', function () {
    return response()->json(['message' => 'Usa la app para iniciar sesión.'], 401);
})->name('login');
