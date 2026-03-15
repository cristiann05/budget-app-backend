<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

// Controlador de gestión de cuenta. Soporta contraseñas y eliminación de cuenta.
// Ya no realiza acciones sobre email ni redirecciones a front-end.
class AccountController extends Controller
{
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = $request->user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Borrar TODOS los tokens — forzar nuevo login
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Contraseña cambiada correctamente. Inicia sesión de nuevo.',
        ]);
    }

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'current_password'],
        ], [
            'password.required' => 'La contraseña es obligatoria.',
            'password.current_password' => 'La contraseña no es correcta.',
        ]);

        $user = $request->user();

        // Borrar todos los tokens
        $user->tokens()->delete();

        // Borrar cuenta
        $user->delete();

        return response()->noContent();
    }
}
