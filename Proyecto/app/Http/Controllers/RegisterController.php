<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register-login');
    }

    public function register(Request $request)
    {
        // Validación de los datos
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:45',
            'apellido' => 'required|string|max:45',
            'email' => 'required|string|email|max:255|unique:users',
            'rut' => 'required|string|max:45|unique:users',
            'telefono' => 'required|string|max:45',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.unique' => 'Este email ya está registrado.',
            'rut.required' => 'El RUT es obligatorio.',
            'rut.unique' => 'Este RUT ya está registrado.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Crear el usuario con todos los campos necesarios
            $user = User::create([
                'name' => $request->nombre . ' ' . $request->apellido, // Combinar nombre y apellido para el campo name
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'rut' => $request->rut,
                'telefono' => $request->telefono,
                'password' => Hash::make($request->password),
                'contrasena' => Hash::make($request->password), // También guardar en contrasena si es necesario
                'email_verified' => false,
                'trial_ends_at' => now()->addDays(30), // 30 días de prueba
                'is_subscribed' => false,
                'role_id' => 3, // Asignar rol de Administrador por defecto (nivel más alto)
            ]);

            // Autenticar al usuario
            Auth::login($user);

            // Redirigir a la página de planes
            return redirect()->route('subscription.plans')->with('success', 'Registro exitoso. ¡Bienvenido!');

        } catch (\Exception $e) {
            \Log::error('Error en registro: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al crear la cuenta. Inténtalo nuevamente.'])->withInput();
        }
    }

    public function login(Request $request)
    {
        // Validación de credenciales
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Verificar si el usuario tiene suscripción activa
            if ($user->is_subscribed || ($user->trial_ends_at && $user->trial_ends_at > now())) {
                return redirect()->intended(route('dashboard'));
            } else {
                return redirect()->route('subscription.plans');
            }
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('register');
    }
}