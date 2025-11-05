<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\ServicioTecnico;

class SetupController extends Controller
{
    /**
     * Mostrar formulario de configuración de servicio técnico
     */
    public function showTechnicalServiceForm()
    {
        $user = Auth::user();
        
        // Verificar que el usuario tenga suscripción activa
        if (!$user->is_subscribed) {
            return redirect()->route('subscription.plans')
                ->with('error', 'Debes tener una suscripción activa para configurar tu servicio técnico.');
        }
        
        $servicioTecnico = $user->servicioTecnico;
        
        return view('setup.technical-service', compact('user', 'servicioTecnico'));
    }

    /**
     * Guardar o actualizar servicio técnico
     */
    public function saveTechnicalService(Request $request)
    {
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

        $user = Auth::user();

        try {
            DB::beginTransaction();
            
            Log::info('Guardando servicio técnico para usuario', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'datos' => $request->only(['nombre_servicio', 'direccion', 'telefono', 'correo', 'rut'])
            ]);

            // Crear o actualizar servicio técnico del usuario
            $servicioTecnico = ServicioTecnico::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nombre_servicio' => $request->nombre_servicio,
                    'direccion' => $request->direccion,
                    'telefono' => $request->telefono,
                    'correo' => $request->correo,
                    'rut' => $request->rut,
                    'activo' => true,
                ]
            );

            Log::info('Servicio técnico guardado exitosamente', [
                'servicio_tecnico_id' => $servicioTecnico->id,
                'user_id' => $user->id
            ]);

            DB::commit();
            
            // Forzar la redirección con mensaje de éxito
            Log::info('Redirigiendo a dashboard', [
                'user_id' => $user->id,
                'servicio_tecnico_id' => $servicioTecnico->id
            ]);

            return redirect()->route('dashboard')
                ->with('success', '¡Configuración completada! Bienvenido a tu dashboard.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al guardar servicio técnico', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withErrors(['error' => 'Error al guardar la configuración: ' . $e->getMessage()])
                ->withInput();
        }
    }
}