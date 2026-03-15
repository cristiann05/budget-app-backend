<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user = User::create([
            'name'                         => $request->name,
            'email'                        => $request->email,
            'password'                     => $request->password,
            'role'                         => 2,
            'verification_code'            => $code,
            'verification_code_expires_at' => now()->addMinutes(15),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user'              => new UserResource($user),
            'token'             => $token,
            'verification_code' => $code,
        ], 201);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ], [
            'code.required' => 'El código es obligatorio.',
            'code.size'     => 'El código debe tener 6 dígitos.',
        ]);

        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email ya verificado.']);
        }

        if ($user->verification_code !== $request->code) {
            return response()->json(['message' => 'Código incorrecto.'], 422);
        }

        if ($user->verification_code_expires_at->isPast()) {
            return response()->json(['message' => 'El código ha expirado.'], 422);
        }

        $user->markEmailAsVerified();
        $user->update([
            'verification_code'            => null,
            'verification_code_expires_at' => null,
        ]);

        return response()->json(['message' => 'Email verificado correctamente.']);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Credenciales incorrectas.',
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user'  => new UserResource($user),
            'token' => $token,
        ]);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente.',
        ]);
    }

    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Sesión cerrada en todos los dispositivos.',
        ]);
    }
}
