<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // Usuario Administrador - TechFix Pro
            [
                'name' => 'admin',
                'nombre' => 'Carlos',
                'apellido' => 'Administrador',
                'rut' => '12.345.678-9',
                'telefono' => '+56 9 8765 4321',
                'email' => 'admin@baieco.cl',
                'password' => Hash::make('admin123'),
                'contrasena' => 'admin123',
                'role_id' => 3, // Administrador
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Usuario Técnico - TechFix Pro
            [
                'name' => 'tecnico1',
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'rut' => '11.222.333-4',
                'telefono' => '+56 9 1234 5678',
                'email' => 'tecnico@techfixpro.cl',
                'password' => Hash::make('tecnico123'),
                'contrasena' => 'tecnico123',
                'role_id' => 2, // Técnico
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Usuario Trabajador - TechFix Pro
            [
                'name' => 'trabajador1',
                'nombre' => 'María',
                'apellido' => 'González',
                'rut' => '13.444.555-6',
                'telefono' => '+56 9 2345 6789',
                'email' => 'maria@techfixpro.cl',
                'password' => Hash::make('trabajador123'),
                'contrasena' => 'trabajador123',
                'role_id' => 1, // Trabajador
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Usuario Técnico - RepairZone (servicio independiente)
            [
                'name' => 'tecnico2',
                'nombre' => 'Pedro',
                'apellido' => 'Martínez',
                'rut' => '14.666.777-8',
                'telefono' => '+56 32 345 6789',
                'email' => 'pedro@repairzone.cl',
                'password' => Hash::make('demo123'),
                'contrasena' => 'demo123',
                'role_id' => 2, // Técnico
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Usuario demo con credenciales simples
            [
                'name' => 'demo',
                'nombre' => 'Usuario',
                'apellido' => 'Demo',
                'rut' => '10.000.000-1',
                'telefono' => '+56 9 0000 0000',
                'email' => 'demo@baieco.cl',
                'password' => Hash::make('123456'),
                'contrasena' => '123456',
                'role_id' => 2, // Técnico
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
