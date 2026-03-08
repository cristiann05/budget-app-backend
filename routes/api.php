<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AllocationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

// Auth pública — limitada a 5 intentos por minuto
Route::middleware('throttle:5,1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword']);
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // Verificación de email — no requiere estar verificado
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('/email/resend', [EmailVerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Rutas protegidas — requiere estar verificado
    Route::middleware(['throttle:60,1', 'verified'])->group(function () {

        Route::post('/logout-all', [AuthController::class, 'logoutAll']);

        // Cuenta
        Route::post('/account/change-password', [AccountController::class, 'changePassword']);
        Route::post('/account/change-email', [AccountController::class, 'changeEmail']);
        Route::delete('/account', [AccountController::class, 'deleteAccount']);

        Route::apiResource('/users', UserController::class)->except('store', 'create');
        Route::apiResource('/categories', CategoryController::class);
        Route::apiResource('/budgets', BudgetController::class);
        Route::apiResource('/budgets/{budget}/allocations', AllocationController::class)
            ->except('show');
        Route::apiResource('/allocations/{allocation}/expenses', ExpenseController::class)
            ->except('show');
    });
});
