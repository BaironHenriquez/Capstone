<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Tecnico;

class TecnicoAuthController extends Controller
{
    /**
     * Mostrar el formulario de login para técnicos
     */
    public function showLoginForm()
    {
        return view('tecnico.login');
    }

    /**
     * Manejar el login de técnicos
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Buscar técnico por email
        $tecnico = Tecnico::where('email', $credentials['email'])->first();

        if (!$tecnico) {
            return back()->withErrors([
                'email' => 'No se encontró un técnico con este correo electrónico.',
            ])->onlyInput('email');
        }

        // Verificar contraseña
        if (!Hash::check($credentials['password'], $tecnico->password)) {
            return back()->withErrors([
                'email' => 'Las credenciales proporcionadas son incorrectas.',
            ])->onlyInput('email');
        }

        // Verificar que el técnico esté activo
        if ($tecnico->estado !== 'activo') {
            return back()->withErrors([
                'email' => 'Tu cuenta de técnico no está activa. Contacta al administrador.',
            ])->onlyInput('email');
        }

        // Autenticar usando el guard de técnicos
        Auth::guard('tecnico')->login($tecnico, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->route('tecnico.dashboard')->with('success', 'Bienvenido de vuelta, ' . $tecnico->nombre);
    }

    /**
     * Cerrar sesión del técnico
     */
    public function logout(Request $request)
    {
        Auth::guard('tecnico')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('tecnico.login')->with('success', 'Has cerrado sesión correctamente.');
    }
}
