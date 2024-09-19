<?php

namespace App\Http\Controllers;

// app/Http/Controllers/AuthController.php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users', // Validar que el email sea único
                'password' => 'required|string|min:4',
                'department_id' => 'required|exists:departments,id',
            ]);

            // Si la validación pasa, creamos el usuario
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'department_id' => $validated['department_id'],
                'role' => 'employee',
            ]);

            // Creamos el token de autenticación
            $token = $user->createToken('auth_token')->plainTextToken;

            // Devolvemos el token y un código de estado 201 (creado)
            return response()->json(['token' => $token], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Si hay un error de validación, devolvemos un mensaje de error con código 422 (Unprocessable Entity)
            return response()->json([
                'message' => 'El usuario ya está registrado con este correo electrónico.',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
