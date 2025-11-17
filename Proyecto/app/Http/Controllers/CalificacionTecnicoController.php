<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalificacionTecnico;
use App\Models\OrdenServicio;

class CalificacionTecnicoController extends Controller
{
    /**
     * Guardar calificación del técnico
     */
    public function store(Request $request)
    {
        $request->validate([
            'orden_servicio_id' => 'required|exists:ordenes_servicio,id',
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500'
        ]);

        $orden = OrdenServicio::findOrFail($request->orden_servicio_id);

        // Verificar que la orden esté completada
        if ($orden->estado !== 'completada') {
            return response()->json([
                'success' => false,
                'message' => 'Solo puedes calificar órdenes completadas'
            ], 400);
        }

        // Verificar que no exista ya una calificación
        $existente = CalificacionTecnico::where('orden_servicio_id', $orden->id)->first();
        if ($existente) {
            return response()->json([
                'success' => false,
                'message' => 'Esta orden ya ha sido calificada'
            ], 400);
        }

        // Crear calificación
        $calificacion = CalificacionTecnico::create([
            'orden_servicio_id' => $orden->id,
            'tecnico_id' => $orden->tecnico_id,
            'cliente_id' => $orden->cliente_id,
            'calificacion' => $request->calificacion,
            'comentario' => $request->comentario
        ]);

        return response()->json([
            'success' => true,
            'message' => '¡Gracias por tu calificación!',
            'calificacion' => $calificacion
        ]);
    }

    /**
     * Obtener promedio de calificaciones de un técnico
     */
    public function promedio($tecnicoId)
    {
        $promedio = CalificacionTecnico::where('tecnico_id', $tecnicoId)->avg('calificacion');
        $total = CalificacionTecnico::where('tecnico_id', $tecnicoId)->count();

        return response()->json([
            'promedio' => round($promedio, 1),
            'total' => $total
        ]);
    }
}
