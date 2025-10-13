<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Mostrar dashboard principal basado en el rol del usuario
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Verificar que el usuario tenga rol
        if (!$user->role) {
            return redirect()->route('setup.technical-service')
                ->with('error', 'Necesitas completar tu configuración antes de acceder al dashboard.');
        }

        // Redirigir según el rol del usuario
        switch ($user->role->nombre_rol) {
            case 'Administrador':
                return $this->adminDashboard($user);
            case 'Técnico':
                return $this->technicianDashboard($user);
            case 'Trabajador':
                return $this->workerDashboard($user);
            default:
                return redirect()->route('setup.technical-service')
                    ->with('error', 'Rol no reconocido. Contacta al administrador.');
        }
    }

    /**
     * Dashboard para Administrador
     */
    private function adminDashboard($user)
    {
        $servicioTecnicoId = $user->servicio_tecnico_id;
        
        // Estadísticas de clientes reales
        $estadisticasClientes = [
            'total' => Cliente::where('servicio_tecnico_id', $servicioTecnicoId)->count(),
            'nuevos_mes' => Cliente::where('servicio_tecnico_id', $servicioTecnicoId)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'nuevos_semana' => Cliente::where('servicio_tecnico_id', $servicioTecnicoId)
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
        ];

        // Datos para gráfico de clientes por mes (últimos 6 meses)
        $clientesPorMes = [];
        for ($i = 5; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $clientesPorMes[] = [
                'mes' => $fecha->format('M Y'),
                'cantidad' => Cliente::where('servicio_tecnico_id', $servicioTecnicoId)
                    ->whereMonth('created_at', $fecha->month)
                    ->whereYear('created_at', $fecha->year)
                    ->count()
            ];
        }

        // Simulación de órdenes de servicio (ya que no tenemos tabla real)
        $resumenOrdenes = [
            'total' => 45 + $estadisticasClientes['total'] * 2,
            'pendientes' => rand(5, 15),
            'en_progreso' => rand(10, 20),
            'completadas' => 30 + $estadisticasClientes['total'],
            'canceladas' => rand(1, 5)
        ];
        
        $tecnicos = [
            [
                'id' => 1,
                'nombre' => 'Carlos Rodriguez',
                'ordenes_asignadas' => 8,
                'ordenes_completadas' => 12,
                'carga_trabajo' => 85,
                'especialidad' => 'Computadoras',
                'estado' => 'activo'
            ],
            [
                'id' => 2,
                'nombre' => 'Maria González',
                'ordenes_asignadas' => 6,
                'ordenes_completadas' => 15,
                'carga_trabajo' => 65,
                'especialidad' => 'Móviles',
                'estado' => 'activo'
            ],
            [
                'id' => 3,
                'nombre' => 'Diego Sánchez',
                'ordenes_asignadas' => 10,
                'ordenes_completadas' => 8,
                'carga_trabajo' => 95,
                'especialidad' => 'Soporte',
                'estado' => 'sobrecargado'
            ],
            [
                'id' => 4,
                'nombre' => 'Ana Torres',
                'ordenes_asignadas' => 4,
                'ordenes_completadas' => 18,
                'carga_trabajo' => 45,
                'especialidad' => 'Reparaciones',
                'estado' => 'disponible'
            ]
        ];
        
        $alertas = [
            [
                'id' => 1,
                'tipo' => 'retraso_critico',
                'orden' => 'TS-2025-089',
                'cliente' => 'Empresa XYZ',
                'dias_retraso' => 5,
                'tecnico' => 'Carlos Rodriguez',
                'prioridad' => 'alta'
            ],
            [
                'id' => 2,
                'tipo' => 'sobrecarga_tecnico',
                'tecnico' => 'Diego Sánchez',
                'carga' => 95,
                'ordenes_pendientes' => 10,
                'prioridad' => 'media'
            ],
            [
                'id' => 3,
                'tipo' => 'revision_pendiente',
                'orden' => 'TS-2025-091',
                'cliente' => 'TechCorp',
                'dias_pendiente' => 2,
                'prioridad' => 'baja'
            ]
        ];
        
        $metricas = [
            'tiempo_promedio_resolucion' => 3.2,
            'satisfaccion_cliente' => 94,
            'ordenes_mes_actual' => 89,
            'ordenes_mes_anterior' => 76,
            'crecimiento' => 17.1
        ];

        // Datos simulados de técnicos
        $tecnicos = [
            'activos' => 8,
            'disponibles' => 3,
            'ocupados' => 5
        ];

        return view('dashboard.admin', compact(
            'user', 
            'estadisticasClientes',
            'clientesPorMes',
            'resumenOrdenes', 
            'tecnicos'
        ));
    }

    /**
     * Dashboard para Técnico
     */
    private function technicianDashboard($user)
    {
        return view('tecnico.dashboard-tecnico', [
            'user' => $user,
            'servicioTecnico' => $user->servicioTecnico
        ]);
    }

    /**
     * Dashboard para Trabajador
     */
    private function workerDashboard($user)
    {
        return view('trabajador.dashboard-trabajador', [
            'user' => $user,
            'servicioTecnico' => $user->servicioTecnico
        ]);
    }
}
