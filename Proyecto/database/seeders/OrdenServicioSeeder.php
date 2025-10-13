<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrdenServicio;
use Illuminate\Support\Facades\DB;

class OrdenServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ordenes = [
            [
                'numero_orden' => 'TS-2025-001',
                'cliente_id' => 1,
                'tecnico_id' => 1,
                'tipo_servicio' => 'reparacion',
                'descripcion_problema' => 'Laptop no enciende, posible problema en la fuente de alimentación',
                'descripcion_solucion' => 'Reemplazo de fuente de poder interna, limpieza general',
                'estado' => 'completada',
                'prioridad' => 'media',
                'fecha_programada' => now()->subDays(10),
                'fecha_inicio' => now()->subDays(10),
                'fecha_completado' => now()->subDays(8),
                'costo_estimado' => 85.00,
                'costo_final' => 80.00,
                'tiempo_estimado_horas' => 3,
                'tiempo_real_horas' => 2.5,
                'equipos' => json_encode([
                    'marca' => 'HP',
                    'modelo' => 'Pavilion 15',
                    'serie' => 'HP001234',
                    'año' => 2021
                ]),
                'repuestos_utilizados' => json_encode([
                    ['nombre' => 'Fuente de poder 65W', 'cantidad' => 1, 'precio' => 45.00]
                ]),
                'created_at' => now()->subDays(12),
                'updated_at' => now()->subDays(8),
            ],
            [
                'numero_orden' => 'TS-2025-002',
                'cliente_id' => 2,
                'tecnico_id' => 4,
                'tipo_servicio' => 'mantenimiento',
                'descripcion_problema' => 'Mantenimiento preventivo mensual de equipos médicos',
                'descripcion_solucion' => 'Calibración completa, limpieza y verificación de todos los sistemas',
                'estado' => 'completada',
                'prioridad' => 'alta',
                'fecha_programada' => now()->subDays(7),
                'fecha_inicio' => now()->subDays(7),
                'fecha_completado' => now()->subDays(6),
                'costo_estimado' => 250.00,
                'costo_final' => 250.00,
                'tiempo_estimado_horas' => 8,
                'tiempo_real_horas' => 7.5,
                'equipos' => json_encode([
                    'marca' => 'Philips',
                    'modelo' => 'Monitor Paciente MX40',
                    'serie' => 'PH789456',
                    'año' => 2020
                ]),
                'repuestos_utilizados' => json_encode([
                    ['nombre' => 'Kit de calibración', 'cantidad' => 1, 'precio' => 50.00]
                ]),
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(6),
            ],
            [
                'numero_orden' => 'TS-2025-003',
                'cliente_id' => 3,
                'tecnico_id' => 2,
                'tipo_servicio' => 'reparacion',
                'descripcion_problema' => 'iPhone 12 con pantalla rota, touch no responde',
                'descripcion_solucion' => 'Reemplazo completo de pantalla OLED y digitalizador',
                'estado' => 'completada',
                'prioridad' => 'media',
                'fecha_programada' => now()->subDays(5),
                'fecha_inicio' => now()->subDays(5),
                'fecha_completado' => now()->subDays(4),
                'costo_estimado' => 180.00,
                'costo_final' => 175.00,
                'tiempo_estimado_horas' => 2,
                'tiempo_real_horas' => 1.5,
                'equipos' => json_encode([
                    'marca' => 'Apple',
                    'modelo' => 'iPhone 12',
                    'serie' => 'IP567890',
                    'año' => 2021
                ]),
                'repuestos_utilizados' => json_encode([
                    ['nombre' => 'Pantalla OLED iPhone 12', 'cantidad' => 1, 'precio' => 140.00]
                ]),
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(4),
            ],
            [
                'numero_orden' => 'TS-2025-004',
                'cliente_id' => 5,
                'tecnico_id' => 1,
                'tipo_servicio' => 'diagnostico',
                'descripcion_problema' => 'Laptop muy lenta, posible virus o hardware defectuoso',
                'descripcion_solucion' => 'Diagnóstico completo realizado, instalación de SSD y limpieza de software',
                'estado' => 'en_progreso',
                'prioridad' => 'baja',
                'fecha_programada' => now()->addDays(1),
                'fecha_inicio' => now(),
                'fecha_completado' => null,
                'costo_estimado' => 120.00,
                'costo_final' => null,
                'tiempo_estimado_horas' => 4,
                'tiempo_real_horas' => null,
                'equipos' => json_encode([
                    'marca' => 'ASUS',
                    'modelo' => 'VivoBook 15',
                    'serie' => 'AS123456',
                    'año' => 2020
                ]),
                'repuestos_utilizados' => json_encode([]),
                'created_at' => now()->subDays(2),
                'updated_at' => now(),
            ],
            [
                'numero_orden' => 'TS-2025-005',
                'cliente_id' => 7,
                'tecnico_id' => 6,
                'tipo_servicio' => 'instalacion',
                'descripcion_problema' => 'Instalación de nueva impresora multifuncional en red',
                'descripcion_solucion' => null,
                'estado' => 'asignada',
                'prioridad' => 'media',
                'fecha_programada' => now()->addDays(2),
                'fecha_inicio' => null,
                'fecha_completado' => null,
                'costo_estimado' => 75.00,
                'costo_final' => null,
                'tiempo_estimado_horas' => 2,
                'tiempo_real_horas' => null,
                'equipos' => json_encode([
                    'marca' => 'Canon',
                    'modelo' => 'PIXMA G6020',
                    'serie' => 'CN789012',
                    'año' => 2025
                ]),
                'repuestos_utilizados' => json_encode([]),
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'numero_orden' => 'TS-2025-006',
                'cliente_id' => 4,
                'tecnico_id' => 8,
                'tipo_servicio' => 'recuperacion_datos',
                'descripcion_problema' => 'Disco duro externo no reconocido, datos importantes perdidos',
                'descripcion_solucion' => 'Proceso de recuperación en curso, 85% de datos recuperables',
                'estado' => 'en_progreso',
                'prioridad' => 'urgente',
                'fecha_programada' => now()->subDays(3),
                'fecha_inicio' => now()->subDays(3),
                'fecha_completado' => null,
                'costo_estimado' => 200.00,
                'costo_final' => null,
                'tiempo_estimado_horas' => 12,
                'tiempo_real_horas' => null,
                'equipos' => json_encode([
                    'marca' => 'Seagate',
                    'modelo' => 'Backup Plus 2TB',
                    'serie' => 'SG456789',
                    'año' => 2022
                ]),
                'repuestos_utilizados' => json_encode([]),
                'created_at' => now()->subDays(4),
                'updated_at' => now(),
            ],
            [
                'numero_orden' => 'TS-2025-007',
                'cliente_id' => 8,
                'tecnico_id' => 3,
                'tipo_servicio' => 'configuracion',
                'descripcion_problema' => 'Configuración de red wifi en laboratorio de cómputo',
                'descripcion_solucion' => null,
                'estado' => 'pendiente',
                'prioridad' => 'media',
                'fecha_programada' => now()->addDays(3),
                'fecha_inicio' => null,
                'fecha_completado' => null,
                'costo_estimado' => 150.00,
                'costo_final' => null,
                'tiempo_estimado_horas' => 6,
                'tiempo_real_horas' => null,
                'equipos' => json_encode([
                    'marca' => 'Cisco',
                    'modelo' => 'Access Point WAP121',
                    'serie' => 'CS234567',
                    'año' => 2024
                ]),
                'repuestos_utilizados' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'numero_orden' => 'TS-2025-008',
                'cliente_id' => 9,
                'tecnico_id' => 7,
                'tipo_servicio' => 'instalacion',
                'descripcion_problema' => 'Instalación de sistema de videovigilancia en consultorios',
                'descripcion_solucion' => 'Sistema instalado y configurado, pruebas pendientes',
                'estado' => 'en_progreso',
                'prioridad' => 'alta',
                'fecha_programada' => now()->subDays(2),
                'fecha_inicio' => now()->subDays(2),
                'fecha_completado' => null,
                'costo_estimado' => 800.00,
                'costo_final' => null,
                'tiempo_estimado_horas' => 16,
                'tiempo_real_horas' => null,
                'equipos' => json_encode([
                    'marca' => 'Hikvision',
                    'modelo' => 'DS-2CD2085FWD-I',
                    'serie' => 'HK345678',
                    'año' => 2024
                ]),
                'repuestos_utilizados' => json_encode([
                    ['nombre' => 'Cámaras IP 8MP', 'cantidad' => 8, 'precio' => 450.00],
                    ['nombre' => 'DVR 16 canales', 'cantidad' => 1, 'precio' => 180.00']
                ]),
                'created_at' => now()->subDays(5),
                'updated_at' => now(),
            ],
            [
                'numero_orden' => 'TS-2025-009',
                'cliente_id' => 10,
                'tecnico_id' => 2,
                'tipo_servicio' => 'reparacion',
                'descripcion_problema' => 'Samsung Galaxy S21 no carga, puerto USB dañado',
                'descripcion_solucion' => null,
                'estado' => 'pendiente',
                'prioridad' => 'baja',
                'fecha_programada' => now()->addDays(4),
                'fecha_inicio' => null,
                'fecha_completado' => null,
                'costo_estimado' => 65.00,
                'costo_final' => null,
                'tiempo_estimado_horas' => 1.5,
                'tiempo_real_horas' => null,
                'equipos' => json_encode([
                    'marca' => 'Samsung',
                    'modelo' => 'Galaxy S21',
                    'serie' => 'SM456789',
                    'año' => 2021
                ]),
                'repuestos_utilizados' => json_encode([]),
                'created_at' => now()->subHours(12),
                'updated_at' => now()->subHours(12),
            ],
            [
                'numero_orden' => 'TS-2025-010',
                'cliente_id' => 11,
                'tecnico_id' => 5,
                'tipo_servicio' => 'actualizacion',
                'descripcion_problema' => 'Actualización de hardware para gaming, instalación de nueva GPU',
                'descripcion_solucion' => null,
                'estado' => 'asignada',
                'prioridad' => 'media',
                'fecha_programada' => now()->addDays(5),
                'fecha_inicio' => null,
                'fecha_completado' => null,
                'costo_estimado' => 450.00,
                'costo_final' => null,
                'tiempo_estimado_horas' => 3,
                'tiempo_real_horas' => null,
                'equipos' => json_encode([
                    'marca' => 'MSI',
                    'modelo' => 'Gaming Desktop GTX',
                    'serie' => 'MSI567890',
                    'año' => 2023
                ]),
                'repuestos_utilizados' => json_encode([]),
                'created_at' => now()->subHours(6),
                'updated_at' => now()->subHours(6),
            ],
            [
                'numero_orden' => 'TS-2025-011',
                'cliente_id' => 12,
                'tecnico_id' => 10,
                'tipo_servicio' => 'configuracion',
                'descripcion_problema' => 'Configuración de equipo de streaming profesional',
                'descripcion_solucion' => 'Configuración completa de OBS, iluminación y audio',
                'estado' => 'completada',
                'prioridad' => 'media',
                'fecha_programada' => now()->subDays(14),
                'fecha_inicio' => now()->subDays(14),
                'fecha_completado' => now()->subDays(13),
                'costo_estimado' => 300.00,
                'costo_final' => 280.00,
                'tiempo_estimado_horas' => 5,
                'tiempo_real_horas' => 4.5,
                'equipos' => json_encode([
                    'marca' => 'Elgato',
                    'modelo' => 'Stream Deck XL',
                    'serie' => 'EL678901',
                    'año' => 2024
                ]),
                'repuestos_utilizados' => json_encode([
                    ['nombre' => 'Micrófono profesional', 'cantidad' => 1, 'precio' => 120.00]
                ]),
                'created_at' => now()->subDays(16),
                'updated_at' => now()->subDays(13),
            ],
            [
                'numero_orden' => 'TS-2025-012',
                'cliente_id' => 6,
                'tecnico_id' => 4,
                'tipo_servicio' => 'mantenimiento',
                'descripcion_problema' => 'Mantenimiento anual de equipos médicos especializados',
                'descripcion_solucion' => null,
                'estado' => 'asignada',
                'prioridad' => 'alta',
                'fecha_programada' => now()->addDays(7),
                'fecha_inicio' => null,
                'fecha_completado' => null,
                'costo_estimado' => 400.00,
                'costo_final' => null,
                'tiempo_estimado_horas' => 10,
                'tiempo_real_horas' => null,
                'equipos' => json_encode([
                    'marca' => 'GE Healthcare',
                    'modelo' => 'Ultrasonido LOGIQ E9',
                    'serie' => 'GE789012',
                    'año' => 2019
                ]),
                'repuestos_utilizados' => json_encode([]),
                'created_at' => now()->subHours(18),
                'updated_at' => now()->subHours(18),
            ]
        ];

        foreach ($ordenes as $orden) {
            OrdenServicio::create($orden);
        }
    }
}
