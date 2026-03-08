<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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

        // Notificar al usuario por email
        Mail::raw(
            'Tu contraseña ha sido cambiada. Si no fuiste tú, contacta con soporte inmediatamente.',
            function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('⚠️ Tu contraseña ha sido cambiada — BudgetApp');
            }
        );

        return response()->json([
            'message' => 'Contraseña cambiada correctamente. Inicia sesión de nuevo.',
        ]);
    }

    public function changeEmail(ChangeEmailRequest $request)
    {
        $user = $request->user();

        $user->update([
            'email' => $request->email,
            'email_verified_at' => null,
        ]);

        // Reenviar verificación al nuevo email
        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Email actualizado. Te hemos enviado un email de verificación.',
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
