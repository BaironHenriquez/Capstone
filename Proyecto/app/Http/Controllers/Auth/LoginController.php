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

        \Log::info('LOGIN ATTEMPT', [
            'email' => $credentials['email'],
            'timestamp' => now()
        ]);

        // Verificar credenciales demo hardcodeadas PRIMERO
        if ($this->attemptDemoLogin($credentials)) {
            $request->session()->regenerate();
            
            // Obtener el rol del usuario demo para redirección
            $user = session('demo_user');
            $redirectUrl = $this->getRedirectByRole($user['role']);
            
            \Log::info('DEMO LOGIN SUCCESS', [
                'user' => $user,
                'redirect_url' => $redirectUrl,
                'role' => $user['role']
            ]);
            
            return redirect($redirectUrl)->with('success', '¡Bienvenido a Baieco!');
        }

        // Solo intentar login con base de datos si NO es un usuario demo
        // Comentado temporalmente para usar solo sistema demo
        /*
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', '¡Bienvenido de vuelta!');
        }
        */

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
                'password' => '123',
                'role' => 'admin',
                'name' => 'Carlos Administrador'
            ],
            [
                'email' => 'tecnico@techfixpro.cl',
                'password' => '123',
                'role' => 'tecnico',
                'name' => 'Juan Pérez'
            ],
            [
                'email' => 'maria@techfixpro.cl',
                'password' => '123',
                'role' => 'trabajador',
                'name' => 'María González'
            ],
            [
                'email' => 'pedro@repairzone.cl',
                'password' => '123',
                'role' => 'tecnico',
                'name' => 'Pedro Martínez'
            ],
            [
                'email' => 'demo@baieco.cl',
                'password' => '123',
                'role' => 'admin',
                'name' => 'Usuario Demo'
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
     * Determinar redirección según el rol del usuario
     */
    private function getRedirectByRole($role)
    {
        \Log::info('GET REDIRECT BY ROLE', [
            'role' => $role,
            'timestamp' => now()
        ]);

        $redirectUrl = match ($role) {
            'admin' => '/dashboard-admin',
            'tecnico', 'trabajador' => '/dashboard_tecnico',
            default => '/home'
        };

        \Log::info('REDIRECT URL DETERMINED', [
            'role' => $role,
            'redirect_url' => $redirectUrl
        ]);

        return $redirectUrl;
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
