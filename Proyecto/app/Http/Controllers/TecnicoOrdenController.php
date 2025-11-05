<?php

namespace App\Http\Controllers;

use App\Models\OrdenServicio;
use Illuminate\Http\Request;

class TecnicoOrdenController extends Controller
{
    public function index()
    {
        $ordenes = OrdenServicio::with('cliente')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tecnico.ordenes', compact('ordenes'));
    }

    public function show(OrdenServicio $orden)
    {
        return view('tecnico.ordenes.show', compact('orden'));
    }

    public function edit($id)
    {
        $orden = OrdenServicio::with('cliente')->findOrFail($id);
        return view('tecnico.ordenes.edit', compact('orden'));
    }

    public function update(Request $request, $id)
    {
        $orden = OrdenServicio::findOrFail($id);
        
        $request->validate([
            'estado' => 'required|in:pendiente,en_progreso,completada,retrasada',
            'prioridad' => 'required|in:baja,media,alta',
            'fecha_programada' => 'nullable|date',
            'fecha_estimada_completion' => 'nullable|date',
            'descripcion_problema' => 'nullable|string',
            'dictamen_tecnico' => 'nullable|string',
            'observaciones_tecnico' => 'nullable|string',
        ]);

        try {
            $orden->update($request->all());

            return redirect()
                ->route('tecnico.ordenes.index')
                ->with('success', 'Orden actualizada correctamente');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la orden: ' . $e->getMessage());
        }
    }

    public function actualizarEstado(Request $request, OrdenServicio $orden)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,en_progreso,completada,retrasada'
        ]);

        try {
            $orden->update([
                'estado' => $request->estado
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado'
            ], 500);
        }
    }

    public function actualizarPrioridad(Request $request, OrdenServicio $orden)
    {
        $request->validate([
            'prioridad' => 'required|in:baja,media,alta'
        ]);

        try {
            $orden->update([
                'prioridad' => $request->prioridad
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Prioridad actualizada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la prioridad'
            ], 500);
        }
    }
}