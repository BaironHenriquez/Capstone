<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\ServicioTecnico;
use App\Models\Payment;
use App\Models\Subscription;

class ConfiguracionController extends Controller
{
    /**
     * Mostrar la página de configuración
     */
    public function index()
    {
        $user = Auth::user();
        $servicioTecnico = $user->servicioTecnico;
        
        // Obtener la suscripción activa más reciente
        $subscription = Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('ends_at', '>', now())
            ->orderBy('created_at', 'desc')
            ->first();
        
        // Verificar que tenga suscripción activa
        if (!$subscription) {
            return redirect()->route('subscription.plans')
                ->with('error', 'Debes tener una suscripción activa para acceder a la configuración.');
        }
        
        // Obtener historial de pagos
        $payments = Payment::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.configuracion.index', compact('user', 'servicioTecnico', 'subscription', 'payments'));
    }

    /**
     * Actualizar información del servicio técnico
     */
    public function updateServicio(Request $request)
    {
        $user = Auth::user();
        
        // Validación básica de formato
        $request->validate([
            'nombre_servicio' => 'required|string|max:45',
            'direccion' => 'required|string|max:45',
            'telefono' => 'required|string|max:45',
            'correo' => 'required|email|max:45',
            'rut' => 'required|string|max:45',
        ], [
            'nombre_servicio.required' => 'El nombre del servicio técnico es obligatorio.',
            'nombre_servicio.max' => 'El nombre no puede exceder 45 caracteres.',
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.max' => 'La dirección no puede exceder 45 caracteres.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.max' => 'El teléfono no puede exceder 45 caracteres.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'Debe ser un correo válido.',
            'correo.max' => 'El correo no puede exceder 45 caracteres.',
            'rut.required' => 'El RUT del servicio es obligatorio.',
            'rut.max' => 'El RUT no puede exceder 45 caracteres.',
        ]);

        // Validar que no existan duplicados (excluyendo el servicio del usuario actual)
        $duplicados = [];
        
        // Verificar nombre de servicio duplicado
        $nombreExiste = ServicioTecnico::where('nombre_servicio', $request->nombre_servicio)
            ->where('user_id', '!=', $user->id)
            ->exists();
        if ($nombreExiste) {
            $duplicados['nombre_servicio'] = 'Este nombre de servicio técnico ya está en uso por otro usuario.';
        }
        
        // Verificar correo duplicado
        $correoExiste = ServicioTecnico::where('correo', $request->correo)
            ->where('user_id', '!=', $user->id)
            ->exists();
        if ($correoExiste) {
            $duplicados['correo'] = 'Este correo ya está registrado por otro servicio técnico.';
        }
        
        // Verificar teléfono duplicado
        $telefonoExiste = ServicioTecnico::where('telefono', $request->telefono)
            ->where('user_id', '!=', $user->id)
            ->exists();
        if ($telefonoExiste) {
            $duplicados['telefono'] = 'Este teléfono ya está registrado por otro servicio técnico.';
        }
        
        // Verificar dirección duplicada
        $direccionExiste = ServicioTecnico::where('direccion', $request->direccion)
            ->where('user_id', '!=', $user->id)
            ->exists();
        if ($direccionExiste) {
            $duplicados['direccion'] = 'Esta dirección ya está registrada por otro servicio técnico.';
        }
        
        // Verificar RUT duplicado
        $rutExiste = ServicioTecnico::where('rut', $request->rut)
            ->where('user_id', '!=', $user->id)
            ->exists();
        if ($rutExiste) {
            $duplicados['rut'] = 'Este RUT ya está registrado por otro servicio técnico.';
        }
        
        // Si hay duplicados, retornar con errores
        if (!empty($duplicados)) {
            return back()
                ->withErrors($duplicados)
                ->withInput();
        }

        try {
            DB::beginTransaction();
            
            // Actualizar servicio técnico
            $servicioTecnico = ServicioTecnico::where('user_id', $user->id)->first();
            $servicioTecnico->update([
                'nombre_servicio' => $request->nombre_servicio,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'correo' => $request->correo,
                'rut' => $request->rut,
            ]);

            Log::info('Servicio técnico actualizado', [
                'user_id' => $user->id,
                'servicio_tecnico_id' => $servicioTecnico->id
            ]);

            DB::commit();
            
            return back()->with('success', 'Información del servicio técnico actualizada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al actualizar servicio técnico', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return back()
                ->withErrors(['error' => 'Error al actualizar la información: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Actualizar datos personales del usuario
     */
    public function updatePersonal(Request $request)
    {
        $user = Auth::user();
        
        // Validación
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ];

        // Si se proporciona contraseña, validar
        if ($request->filled('current_password') || $request->filled('password')) {
            $rules['current_password'] = 'required';
            $rules['password'] = 'required|min:8|confirmed';
        }

        $messages = [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Debe ser un correo válido.',
            'email.unique' => 'Este correo ya está en uso.',
            'current_password.required' => 'Debes proporcionar tu contraseña actual.',
            'password.required' => 'Debes proporcionar una nueva contraseña.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];

        $request->validate($rules, $messages);

        try {
            DB::beginTransaction();

            // Actualizar nombre y email
            $user->name = $request->name;
            $user->email = $request->email;

            // Si se proporciona contraseña, validar y actualizar
            if ($request->filled('current_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
                }

                $user->password = Hash::make($request->password);
            }

            $user->save();

            Log::info('Datos personales actualizados', ['user_id' => $user->id]);

            DB::commit();

            return back()->with('success', 'Datos personales actualizados correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al actualizar datos personales', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return back()
                ->withErrors(['error' => 'Error al actualizar los datos: ' . $e->getMessage()])
                ->withInput();
        }
    }
}
