<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    /**
     * Redirigir al usuario a Google OAuth
     */
    public function redirectToGoogle()
    {
        // Verificar configuración antes de redireccionar
        if (!$this->isGoogleConfigured()) {
            return redirect()->route('auth.social')
                ->with('error', 'Google OAuth no está configurado correctamente.');
        }
        
        return Socialite::driver('google')->redirect();
    }

    /**
     * Manejar la respuesta de Google OAuth
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Buscar usuario existente por Google ID
            $user = User::where('google_id', $googleUser->getId())->first();
            
            if ($user) {
                // Usuario existente, actualizar información
                $user->update([
                    'name' => $googleUser->getName(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified' => true,
                ]);
            } else {
                // Buscar usuario por email
                $existingUser = User::where('email', $googleUser->getEmail())->first();
                
                if ($existingUser) {
                    // Vincular cuenta existente con Google
                    $existingUser->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                        'provider' => 'google',
                        'email_verified' => true,
                    ]);
                    $user = $existingUser;
                } else {
                    // Crear nuevo usuario
                    $user = User::create([
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                        'provider' => 'google',
                        'email_verified' => true,
                        'password' => Hash::make(Str::random(16)), // Password temporal
                        'trial_ends_at' => now()->addDays(7), // 7 días de prueba gratis
                    ]);
                }
            }

            // Iniciar sesión
            Auth::login($user);

            // Redirigir basado en el estado de suscripción
            if ($user->canAccessSystem()) {
                return redirect()->intended('/dashboard')->with('success', '¡Bienvenido! Has iniciado sesión correctamente.');
            } else {
                return redirect()->route('subscription.plans')->with('info', 'Tu período de prueba ha expirado. Selecciona un plan para continuar.');
            }

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Error al autenticar con Google. Intenta nuevamente.');
        }
    }

    /**
     * Mostrar página de registro/login
     */
    public function showAuthPage()
    {
        // Verificar si Google OAuth está configurado
        if (!$this->isGoogleConfigured()) {
            return view('oauth.setup-required');
        }
        
        return view('login.social-auth');
    }
    
    /**
     * Verificar si Google OAuth está configurado correctamente
     */
    private function isGoogleConfigured()
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');
        
        return $clientId && 
               $clientSecret && 
               $clientId !== 'your_google_client_id' && 
               $clientSecret !== 'your_google_client_secret';
    }
}
