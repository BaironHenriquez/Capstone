<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicioTecnicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('servicios_tecnicos')->insert([
            [
                'nombre_servicio' => 'TechFix Pro',
                'direccion' => 'Av. Providencia 1234, Santiago',
                'telefono' => '+56 2 2345 6789',
                'correo' => 'contacto@techfixpro.cl',
                'rut' => '76.123.456-7',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_servicio' => 'RepairZone',
                'direccion' => 'Calle San Antonio 567, Valparaíso',
                'telefono' => '+56 32 234 5678',
                'correo' => 'info@repairzone.cl',
                'rut' => '76.987.654-3',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_servicio' => 'ElectroServ',
                'direccion' => 'Los Carrera 890, Concepción',
                'telefono' => '+56 41 345 6789',
                'correo' => 'soporte@electroserv.cl',
                'rut' => '76.555.444-9',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
