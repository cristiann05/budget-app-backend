<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AllocationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

// Auth pública — limitada a 5 intentos por minuto
Route::middleware('throttle:5,1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // Rutas protegidas — ya no se requiere verificación de email
    Route::middleware(['throttle:60,1'])->group(function () {

        Route::post('/logout-all', [AuthController::class, 'logoutAll']);

        // Cuenta
        Route::post('/account/change-password', [AccountController::class, 'changePassword']);
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
