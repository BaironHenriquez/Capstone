<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Verificar credenciales demo hardcodeadas
        if ($this->attemptDemoLogin($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', '¡Bienvenido a Baieco!');
        }

        // Intento de login normal con base de datos (cuando esté disponible)
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', '¡Bienvenido de vuelta!');
        }

        throw ValidationException::withMessages([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }

    /**
     * Verificar credenciales demo
     */
    private function attemptDemoLogin($credentials)
    {
        $demoUsers = [
            [
                'email' => 'admin@baieco.cl',
                'password' => 'admin123',
                'role' => 'admin',
                'name' => 'Carlos Administrador'
            ],
            [
                'email' => 'tecnico@techfixpro.cl',
                'password' => 'tecnico123',
                'role' => 'tecnico',
                'name' => 'Juan Pérez'
            ],
            [
                'email' => 'demo@baieco.cl',
                'password' => '123456',
                'role' => 'tecnico',
                'name' => 'Usuario Demo'
            ],
            [
                'email' => 'pedro@repairzone.cl',
                'password' => 'demo123',
                'role' => 'tecnico',
                'name' => 'Pedro Martínez'
            ]
        ];

        foreach ($demoUsers as $user) {
            if ($user['email'] === $credentials['email'] && 
                $user['password'] === $credentials['password']) {
                
                // Simular usuario autenticado en sesión
                session([
                    'demo_user' => $user,
                    'authenticated' => true
                ]);
                
                return true;
            }
        }

        return false;
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        // Limpiar sesión demo
        $request->session()->forget(['demo_user', 'authenticated']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Sesión cerrada correctamente');
    }
}
