<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /**
     * Mostrar el formulario de registro/login
     */
    public function showRegistrationForm(): View
    {
        return view('login.register-login');
    }

    /**
     * Mostrar el formulario de login
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Manejar una solicitud de registro
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:45'],
            'apellido' => ['required', 'string', 'max:45'],
            'rut' => ['nullable', 'string', 'max:45'],
            'telefono' => ['nullable', 'string', 'max:45'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 45 caracteres.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.max' => 'El apellido no puede tener más de 45 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'terms.required' => 'Debes aceptar los términos y condiciones.',
            'terms.accepted' => 'Debes aceptar los términos y condiciones.',
        ]);

        $fullName = trim($request->nombre . ' ' . $request->apellido);

        $user = User::create([
            'name' => $fullName,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'rut' => $request->rut,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contrasena' => Hash::make($request->password), // Para compatibilidad
            'email_verified_at' => Carbon::now(),
            'email_verified' => true,
            'role_id' => 3, // Asignar rol de Administrador por defecto (nivel más alto)
            'is_subscribed' => false,
            'trial_ends_at' => Carbon::now()->addDays(7),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirigir a los planes de suscripción después del período de prueba
        return redirect()->route('subscription.plans')->with('success', 
            '¡Cuenta creada exitosamente! Tu período de prueba de 7 días ha comenzado. Selecciona un plan de suscripción.'
        );
    }

    /**
     * Manejar una solicitud de login
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Verificar si el usuario está en período de prueba o tiene suscripción activa
            $trialEndsAt = $user->created_at->addDays(7);
            
            if (Carbon::now()->lessThan($trialEndsAt)) {
                // Está en período de prueba
                return redirect()->intended('/dashboard')->with('info', 
                    'Bienvenido de vuelta. Tu período de prueba termina el ' . $trialEndsAt->format('d/m/Y')
                );
            } else {
                // Verificar si tiene suscripción activa
                $activeSubscription = $user->subscriptions()
                    ->where('status', 'active')
                    ->where('ends_at', '>', Carbon::now())
                    ->first();
                
                if ($activeSubscription) {
                    return redirect()->intended('/dashboard')->with('success', 'Bienvenido de vuelta.');
                } else {
                    // Período de prueba expirado y sin suscripción
                    return redirect()->route('subscription.plans')->with('warning', 
                        'Tu período de prueba ha expirado. Selecciona un plan para continuar.'
                    );
                }
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Cerrar sesión del usuario
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Has cerrado sesión correctamente.');
    }
}