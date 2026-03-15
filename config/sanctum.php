<?php

use Laravel\Sanctum\Sanctum;

return [
    // En entorno backend-only, el frontend no debe estar acoplado en el estado de Sanctum.
// Se usa SANCTUM_STATEFUL_DOMAINS vacío o con dominios de API válidos.
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', '')),

    'guard' => ['web'],

    'expiration' => 60 * 24, // 24 horas

    'token_prefix' => env('SANCTUM_TOKEN_PREFIX', ''),

    'middleware' => [
        'authenticate_session' => Laravel\Sanctum\Http\Middleware\AuthenticateSession::class,
        'encrypt_cookies' => Illuminate\Cookie\Middleware\EncryptCookies::class,
        'validate_csrf_token' => Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
    ],
];
