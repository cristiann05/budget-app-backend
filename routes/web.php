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

Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    $user = \App\Models\User::findOrFail($id);

    if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
        return redirect('http://localhost:4200/auth/login?verified=error');
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    return redirect('http://localhost:4200/auth/login?verified=1');
})->middleware('signed')->name('verification.verify');
