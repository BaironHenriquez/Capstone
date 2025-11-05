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
        return view('login.login');
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

        // Intentar login con la base de datos
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            \Log::info('LOGIN SUCCESS', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'role_id' => $user->role_id,
                'servicio_tecnico_id' => $user->servicio_tecnico_id
            ]);
            
            // Obtener el rol del usuario para redirección
            $role = $user->role;
            $redirectUrl = $this->getRedirectByRole($role ? $role->nombre_rol : 'user');
            
            return redirect($redirectUrl)->with('success', '¡Bienvenido ' . $user->nombre . '!');
        }

        \Log::warning('LOGIN FAILED', [
            'email' => $credentials['email'],
            'timestamp' => now()
        ]);

        throw ValidationException::withMessages([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }

    /**
     * Determinar redirección según el rol del usuario
     */
    private function getRedirectByRole($roleNombre)
    {
        \Log::info('GET REDIRECT BY ROLE', [
            'role' => $roleNombre,
            'timestamp' => now()
        ]);

        $redirectUrl = match ($roleNombre) {
            'admin', 'administrador' => '/admin/gestion-tecnicos',
            'tecnico' => '/dashboard_tecnico',
            'trabajador' => '/dashboard_tecnico',
            default => '/home'
        };

        \Log::info('REDIRECT URL DETERMINED', [
            'role' => $roleNombre,
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
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Sesión cerrada correctamente');
    }
}
