<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ServicioTecnico;

class SetupController extends Controller
{
    /**
     * Mostrar formulario de configuración de servicio técnico
     */
    public function showTechnicalServiceForm()
    {
        $user = Auth::user();
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
            'direccion.required' => 'La dirección es obligatoria.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'Debe ser un correo válido.',
            'rut.required' => 'El RUT del servicio es obligatorio.',
        ]);

        $user = Auth::user();

        try {
            // Crear o actualizar servicio técnico
            $servicioTecnico = ServicioTecnico::updateOrCreate(
                ['id' => $user->servicio_tecnico_id],
                [
                    'nombre_servicio' => $request->nombre_servicio,
                    'direccion' => $request->direccion,
                    'telefono' => $request->telefono,
                    'correo' => $request->correo,
                    'rut' => $request->rut,
                    'activo' => true,
                ]
            );

            // Asociar el servicio técnico al usuario si no lo tiene
            if (!$user->servicio_tecnico_id) {
                $user->update([
                    'servicio_tecnico_id' => $servicioTecnico->id
                ]);
            }

            return redirect()->route('dashboard')->with('success', '¡Configuración completada! Bienvenido a tu dashboard.');

        } catch (\Exception $e) {
            \Log::error('Error al guardar servicio técnico: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al guardar la configuración. Intenta nuevamente.'])->withInput();
        }
    }
}
