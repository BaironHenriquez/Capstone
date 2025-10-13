<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Trabajador;
use Illuminate\Support\Facades\DB;

class TrabajadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trabajadores = [
            [
                'nombre' => 'José Miguel',
                'apellidos' => 'López Herrera',
                'email' => 'jose.lopez@techservice.com',
                'telefono' => '555-2001',
                'posicion' => 'Supervisor de Taller',
                'departamento' => 'Operaciones',
                'salario' => 1200.00,
                'fecha_contratacion' => now()->subMonths(36),
                'horario_trabajo' => json_encode([
                    'lunes' => ['08:00', '17:00'],
                    'martes' => ['08:00', '17:00'],
                    'miercoles' => ['08:00', '17:00'],
                    'jueves' => ['08:00', '17:00'],
                    'viernes' => ['08:00', '17:00']
                ]),
                'habilidades' => json_encode(['Gestión de Equipos', 'Control de Calidad', 'Logística']),
                'estado' => 'activo',
                'supervisor_id' => null,
                'notas' => 'Supervisor principal del taller, coordina todas las reparaciones',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Carmen Elena',
                'apellidos' => 'Vargas Morales',
                'email' => 'carmen.vargas@techservice.com',
                'telefono' => '555-2002',
                'posicion' => 'Recepcionista',
                'departamento' => 'Atención al Cliente',
                'salario' => 800.00,
                'fecha_contratacion' => now()->subMonths(18),
                'horario_trabajo' => json_encode([
                    'lunes' => ['07:30', '16:30'],
                    'martes' => ['07:30', '16:30'],
                    'miercoles' => ['07:30', '16:30'],
                    'jueves' => ['07:30', '16:30'],
                    'viernes' => ['07:30', '16:30'],
                    'sabado' => ['08:00', '12:00']
                ]),
                'habilidades' => json_encode(['Atención al Cliente', 'Gestión de Citas', 'Facturación']),
                'estado' => 'activo',
                'supervisor_id' => 1,
                'notas' => 'Encargada de recepción y primera atención a clientes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedro Alfonso',
                'apellidos' => 'Ruiz Castillo',
                'email' => 'pedro.ruiz@techservice.com',
                'telefono' => '555-2003',
                'posicion' => 'Almacenista',
                'departamento' => 'Logística',
                'salario' => 750.00,
                'fecha_contratacion' => now()->subMonths(24),
                'horario_trabajo' => json_encode([
                    'lunes' => ['08:00', '17:00'],
                    'martes' => ['08:00', '17:00'],
                    'miercoles' => ['08:00', '17:00'],
                    'jueves' => ['08:00', '17:00'],
                    'viernes' => ['08:00', '17:00']
                ]),
                'habilidades' => json_encode(['Inventario', 'Logística', 'Control de Stock']),
                'estado' => 'activo',
                'supervisor_id' => 1,
                'notas' => 'Responsable del almacén de repuestos y herramientas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Luisa Fernanda',
                'apellidos' => 'González Medina',
                'email' => 'luisa.gonzalez@techservice.com',
                'telefono' => '555-2004',
                'posicion' => 'Coordinadora de Servicios',
                'departamento' => 'Operaciones',
                'salario' => 1000.00,
                'fecha_contratacion' => now()->subMonths(30),
                'horario_trabajo' => json_encode([
                    'lunes' => ['08:30', '17:30'],
                    'martes' => ['08:30', '17:30'],
                    'miercoles' => ['08:30', '17:30'],
                    'jueves' => ['08:30', '17:30'],
                    'viernes' => ['08:30', '17:30']
                ]),
                'habilidades' => json_encode(['Planificación', 'Coordinación', 'Gestión de Proyectos']),
                'estado' => 'activo',
                'supervisor_id' => 1,
                'notas' => 'Coordina asignación de técnicos y seguimiento de órdenes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Miguel Ángel',
                'apellidos' => 'Torres Jiménez',
                'email' => 'miguel.torres@techservice.com',
                'telefono' => '555-2005',
                'posicion' => 'Messenger/Delivery',
                'departamento' => 'Logística',
                'salario' => 650.00,
                'fecha_contratacion' => now()->subMonths(12),
                'horario_trabajo' => json_encode([
                    'lunes' => ['09:00', '18:00'],
                    'martes' => ['09:00', '18:00'],
                    'miercoles' => ['09:00', '18:00'],
                    'jueves' => ['09:00', '18:00'],
                    'viernes' => ['09:00', '18:00'],
                    'sabado' => ['09:00', '13:00']
                ]),
                'habilidades' => json_encode(['Delivery', 'Logística Urbana', 'Atención al Cliente']),
                'estado' => 'activo',
                'supervisor_id' => 3,
                'notas' => 'Encargado de entregas y recolección de equipos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Sofia Alejandra',
                'apellidos' => 'Ramírez Contreras',
                'email' => 'sofia.ramirez@techservice.com',
                'telefono' => '555-2006',
                'posicion' => 'Asistente Administrativa',
                'departamento' => 'Administración',
                'salario' => 900.00,
                'fecha_contratacion' => now()->subMonths(15),
                'horario_trabajo' => json_encode([
                    'lunes' => ['08:00', '17:00'],
                    'martes' => ['08:00', '17:00'],
                    'miercoles' => ['08:00', '17:00'],
                    'jueves' => ['08:00', '17:00'],
                    'viernes' => ['08:00', '17:00']
                ]),
                'habilidades' => json_encode(['Administración', 'Contabilidad Básica', 'Documentación']),
                'estado' => 'activo',
                'supervisor_id' => 1,
                'notas' => 'Apoyo administrativo y documentación de procesos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Daniel Esteban',
                'apellidos' => 'Silva Moreno',
                'email' => 'daniel.silva@techservice.com',
                'telefono' => '555-2007',
                'posicion' => 'Técnico Trainee',
                'departamento' => 'Operaciones',
                'salario' => 600.00,
                'fecha_contratacion' => now()->subMonths(6),
                'horario_trabajo' => json_encode([
                    'lunes' => ['08:00', '16:00'],
                    'martes' => ['08:00', '16:00'],
                    'miercoles' => ['08:00', '16:00'],
                    'jueves' => ['08:00', '16:00'],
                    'viernes' => ['08:00', '16:00']
                ]),
                'habilidades' => json_encode(['Apoyo Técnico', 'Diagnóstico Básico', 'Aprendizaje']),
                'estado' => 'activo',
                'supervisor_id' => 1,
                'notas' => 'En entrenamiento para convertirse en técnico certificado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Andrea Paola',
                'apellidos' => 'Delgado Núñez',
                'email' => 'andrea.delgado@techservice.com',
                'telefono' => '555-2008',
                'posicion' => 'Especialista en Calidad',
                'departamento' => 'Control de Calidad',
                'salario' => 1100.00,
                'fecha_contratacion' => now()->subMonths(27),
                'horario_trabajo' => json_encode([
                    'lunes' => ['08:30', '17:30'],
                    'martes' => ['08:30', '17:30'],
                    'miercoles' => ['08:30', '17:30'],
                    'jueves' => ['08:30', '17:30'],
                    'viernes' => ['08:30', '17:30']
                ]),
                'habilidades' => json_encode(['Control de Calidad', 'Auditoría', 'Procesos']),
                'estado' => 'activo',
                'supervisor_id' => 1,
                'notas' => 'Revisa calidad de reparaciones antes de entrega al cliente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Andrés Felipe',
                'apellidos' => 'Gutiérrez Sandoval',
                'email' => 'andres.gutierrez@techservice.com',
                'telefono' => '555-2009',
                'posicion' => 'Operador de Limpieza',
                'departamento' => 'Mantenimiento',
                'salario' => 550.00,
                'fecha_contratacion' => now()->subMonths(9),
                'horario_trabajo' => json_encode([
                    'lunes' => ['06:00', '14:00'],
                    'martes' => ['06:00', '14:00'],
                    'miercoles' => ['06:00', '14:00'],
                    'jueves' => ['06:00', '14:00'],
                    'viernes' => ['06:00', '14:00'],
                    'sabado' => ['07:00', '11:00']
                ]),
                'habilidades' => json_encode(['Limpieza Industrial', 'Mantenimiento Básico', 'Organización']),
                'estado' => 'activo',
                'supervisor_id' => 1,
                'notas' => 'Mantiene las instalaciones limpias y organizadas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Gabriela Beatriz',
                'apellidos' => 'Herrera Vásquez',
                'email' => 'gabriela.herrera@techservice.com',
                'telefono' => '555-2010',
                'posicion' => 'Coordinadora de Atención',
                'departamento' => 'Atención al Cliente',
                'salario' => 950.00,
                'fecha_contratacion' => now()->subMonths(21),
                'horario_trabajo' => json_encode([
                    'lunes' => ['10:00', '19:00'],
                    'martes' => ['10:00', '19:00'],
                    'miercoles' => ['10:00', '19:00'],
                    'jueves' => ['10:00', '19:00'],
                    'viernes' => ['10:00', '19:00'],
                    'sabado' => ['09:00', '14:00']
                ]),
                'habilidades' => json_encode(['Atención al Cliente', 'Resolución de Conflictos', 'Seguimiento']),
                'estado' => 'activo',
                'supervisor_id' => 2,
                'notas' => 'Coordina el seguimiento post-servicio con clientes',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($trabajadores as $trabajador) {
            Trabajador::create($trabajador);
        }
    }
}
