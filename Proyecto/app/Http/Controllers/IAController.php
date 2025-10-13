<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cliente;
use Carbon\Carbon;

class IAController extends Controller
{
    /**
     * Recomendador de técnicos basado en especialidad, carga de trabajo y ubicación
     */
    public function recomendarTecnico(Request $request)
    {
        $tipoServicio = $request->input('tipo_servicio');
        $prioridad = $request->input('prioridad', 'media');
        $ubicacion = $request->input('ubicacion');

        // Algoritmo simulado de recomendación
        $tecnicos = [
            [
                'id' => 1,
                'nombre' => 'Carlos Rodriguez',
                'especialidad' => 'Computadoras',
                'carga_trabajo' => 75,
                'calificacion' => 4.8,
                'tiempo_estimado' => '2-3 horas',
                'score_ia' => 95,
                'razon_recomendacion' => 'Alta experiencia en hardware, carga moderada'
            ],
            [
                'id' => 2,
                'nombre' => 'María González',
                'especialidad' => 'Móviles',
                'carga_trabajo' => 60,
                'calificacion' => 4.7,
                'tiempo_estimado' => '1-2 horas',
                'score_ia' => 88,
                'razon_recomendacion' => 'Especialista en dispositivos móviles, disponibilidad inmediata'
            ],
            [
                'id' => 3,
                'nombre' => 'Ana Hernández',
                'especialidad' => 'Equipos Médicos',
                'carga_trabajo' => 45,
                'calificacion' => 4.9,
                'tiempo_estimado' => '4-6 horas',
                'score_ia' => 92,
                'razon_recomendacion' => 'Certificaciones especializadas, excelente historial'
            ]
        ];

        // Filtrar y ordenar por algoritmo de IA simulado
        $recomendaciones = collect($tecnicos)
            ->sortByDesc('score_ia')
            ->take(3)
            ->values();

        return response()->json([
            'recomendaciones' => $recomendaciones,
            'criterios_aplicados' => [
                'tipo_servicio' => $tipoServicio,
                'prioridad' => $prioridad,
                'factores_considerados' => [
                    'Especialización técnica',
                    'Carga de trabajo actual',
                    'Calificación histórica',
                    'Tiempo de respuesta estimado'
                ]
            ]
        ]);
    }

    /**
     * Priorizador automático de órdenes usando machine learning simulado
     */
    public function priorizarOrdenes(Request $request)
    {
        // Algoritmo simulado de priorización
        $ordenes = [
            [
                'id' => 'TS-2025-001',
                'cliente' => 'Hospital Central',
                'tipo' => 'Equipos Médicos',
                'descripcion' => 'Monitor de signos vitales no funciona',
                'prioridad_original' => 'media',
                'prioridad_ia' => 'urgente',
                'score_prioridad' => 98,
                'factores' => [
                    'Cliente crítico (hospital)' => 40,
                    'Equipo esencial para pacientes' => 35,
                    'Tiempo sin servicio' => 23
                ],
                'tiempo_sugerido' => 'Inmediato',
                'impacto_estimado' => 'Alto - Operaciones críticas'
            ],
            [
                'id' => 'TS-2025-002',
                'cliente' => 'Oficina Contable López',
                'tipo' => 'Computadoras',
                'descripcion' => 'Servidor de archivos lento',
                'prioridad_original' => 'alta',
                'prioridad_ia' => 'media',
                'score_prioridad' => 65,
                'factores' => [
                    'Afecta productividad' => 25,
                    'Tiene workaround temporal' => -15,
                    'Cliente empresarial' => 20
                ],
                'tiempo_sugerido' => '24-48 horas',
                'impacto_estimado' => 'Medio - Reducción productividad'
            ]
        ];

        // Aplicar algoritmo de machine learning simulado
        $ordenesOptimizadas = collect($ordenes)
            ->sortByDesc('score_prioridad')
            ->map(function ($orden, $index) {
                $orden['posicion_cola'] = $index + 1;
                $orden['tiempo_estimado_atencion'] = $this->calcularTiempoEspera($index);
                return $orden;
            });

        return response()->json([
            'ordenes_priorizadas' => $ordenesOptimizadas,
            'algoritmo_usado' => 'ML-Priority-Engine v2.1',
            'factores_considerados' => [
                'Criticidad del cliente',
                'Tipo de equipo/servicio',
                'Impacto operacional',
                'SLA contractual',
                'Recursos disponibles',
                'Historial de incidencias'
            ],
            'optimizacion' => [
                'tiempo_total_reducido' => '35%',
                'satisfaccion_cliente_estimada' => '92%'
            ]
        ]);
    }

    /**
     * Generador de alertas predictivas
     */
    public function alertasPredictivas(Request $request)
    {
        $alertas = [
            [
                'id' => 'PRED-001',
                'tipo' => 'sobrecarga_tecnico',
                'severidad' => 'alta',
                'mensaje' => 'Diego Sánchez alcanzará sobrecarga (>90%) en las próximas 2 horas',
                'probabilidad' => 87,
                'acciones_sugeridas' => [
                    'Reasignar 2 órdenes pendientes a María González',
                    'Programar backup de Carlos Rodriguez para mañana',
                    'Activar protocolo de carga equilibrada'
                ],
                'impacto_previsto' => 'Retrasos de 3-4 horas en nuevas asignaciones',
                'tiempo_prediccion' => '2 horas'
            ],
            [
                'id' => 'PRED-002',
                'tipo' => 'demanda_pico',
                'severidad' => 'media',
                'mensaje' => 'Se prevé aumento del 40% en órdenes el viernes por la tarde',
                'probabilidad' => 73,
                'acciones_sugeridas' => [
                    'Programar técnicos adicionales 14:00-18:00',
                    'Preparar stock de repuestos comunes',
                    'Notificar a clientes sobre posibles demoras'
                ],
                'impacto_previsto' => 'Posible saturación del sistema',
                'tiempo_prediccion' => '3 días'
            ],
            [
                'id' => 'PRED-003',
                'tipo' => 'falla_equipo',
                'severidad' => 'baja',
                'mensaje' => 'Equipo médico #MED-789 muestra patrones de pre-falla',
                'probabilidad' => 65,
                'acciones_sugeridas' => [
                    'Programar mantenimiento preventivo esta semana',
                    'Contactar al cliente para agendar revisión',
                    'Preparar repuesto preventivo'
                ],
                'impacto_previsto' => 'Falla completa en 7-10 días sin intervención',
                'tiempo_prediccion' => '1 semana'
            ]
        ];

        // Análisis de tendencias
        $tendencias = [
            'crecimiento_ordenes' => [
                'porcentaje' => 15.3,
                'periodo' => 'mensual',
                'proyeccion_6_meses' => 'Aumento sostenido del 12-18%'
            ],
            'satisfaccion_cliente' => [
                'actual' => 94.2,
                'tendencia' => 'estable',
                'factores_riesgo' => ['Tiempo de respuesta en horas pico']
            ],
            'eficiencia_tecnicos' => [
                'promedio' => 87.5,
                'mejor_tecnico' => 'Ana Hernández (96.2%)',
                'area_mejora' => 'Capacitación en nuevas tecnologías'
            ]
        ];

        return response()->json([
            'alertas' => $alertas,
            'tendencias' => $tendencias,
            'recomendaciones_estrategicas' => [
                'Contratar 1 técnico adicional en los próximos 2 meses',
                'Implementar sistema de turnos rotativos',
                'Ampliar inventario de repuestos críticos en 20%'
            ],
            'modelo_ia' => [
                'version' => 'TechPredict v3.2',
                'precision' => '89.4%',
                'datos_analizados' => '2,847 órdenes históricas'
            ]
        ]);
    }

    /**
     * Optimizador de rutas para técnicos
     */
    public function optimizarRutas(Request $request)
    {
        $tecnicoId = $request->input('tecnico_id');
        $fecha = $request->input('fecha', now()->format('Y-m-d'));

        // Simulación de algoritmo de optimización de rutas
        $rutaOptimizada = [
            'tecnico' => [
                'id' => $tecnicoId,
                'nombre' => 'Carlos Rodriguez',
                'vehiculo' => 'Furgoneta TS-001'
            ],
            'fecha' => $fecha,
            'ordenes_programadas' => [
                [
                    'orden' => 'TS-2025-010',
                    'cliente' => 'Empresa ABC',
                    'direccion' => 'Av. Principal 123',
                    'hora_estimada' => '08:30',
                    'duracion_estimada' => '1.5h',
                    'distancia_anterior' => '2.3 km'
                ],
                [
                    'orden' => 'TS-2025-012',
                    'cliente' => 'Consultorio Dr. Pérez',
                    'direccion' => 'Calle Salud 456',
                    'hora_estimada' => '10:15',
                    'duracion_estimada' => '2h',
                    'distancia_anterior' => '1.8 km'
                ],
                [
                    'orden' => 'TS-2025-008',
                    'cliente' => 'TechCorp Oficinas',
                    'direccion' => 'Centro Empresarial Torre 2',
                    'hora_estimada' => '13:00',
                    'duracion_estimada' => '45min',
                    'distancia_anterior' => '3.1 km'
                ]
            ],
            'optimizacion' => [
                'distancia_total' => '47.2 km',
                'tiempo_total' => '6h 15min',
                'ahorro_vs_ruta_original' => [
                    'distancia' => '12.8 km (21%)',
                    'tiempo' => '1h 25min (18%)',
                    'combustible' => '$8.50'
                ]
            ],
            'alertas_ruta' => [
                'Tráfico pesado esperado 12:30-13:30 en Av. Principal',
                'Estacionamiento limitado en Centro Empresarial'
            ]
        ];

        return response()->json($rutaOptimizada);
    }

    /**
     * Calcular tiempo de espera estimado
     */
    private function calcularTiempoEspera($posicion)
    {
        $tiempoBase = 30; // minutos base
        $incremento = 45; // minutos por posición
        
        $tiempoTotal = $tiempoBase + ($posicion * $incremento);
        
        if ($tiempoTotal < 60) {
            return $tiempoTotal . ' minutos';
        } else {
            $horas = floor($tiempoTotal / 60);
            $minutos = $tiempoTotal % 60;
            return $horas . 'h ' . ($minutos > 0 ? $minutos . 'm' : '');
        }
    }
}
