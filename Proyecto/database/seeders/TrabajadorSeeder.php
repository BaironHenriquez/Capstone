<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Trabajador;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TrabajadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the trabajador1 user created in UserSeeder
        $trabajadorUser = User::where('email', 'maria@techfixpro.cl')->first();
        
        // Get the first servicio tecnico
        $servicioTecnicoId = DB::table('servicios_tecnicos')->first()->id;

        $trabajadores = [
            [
                'user_id' => $trabajadorUser->id,
                'tecnico_id' => null,
                'tipo_trabajo' => 'general',
                'habilidades' => json_encode(['Gestión de Equipos', 'Control de Calidad', 'Logística']),
                'nivel_experiencia' => 'avanzado',
                'zona_trabajo' => 'Taller Principal',
                'disponible' => true,
                'telefono_trabajo' => '555-2001',
                'horario_trabajo' => '08:00-17:00 L-V',
                'salario_por_hora' => 35.00,
                'estado' => 'activo',
                'fecha_ingreso' => now()->subMonths(36),
                'notas_admin' => 'Supervisor principal del taller, coordina todas las reparaciones',
                'servicio_tecnico_id' => $servicioTecnicoId,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($trabajadores as $trabajador) {
            Trabajador::create($trabajador);
        }
    }
}
