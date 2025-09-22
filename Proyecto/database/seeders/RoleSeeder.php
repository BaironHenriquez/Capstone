<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'nombre_rol' => 'Trabajador',
                'descripcion' => 'Usuario con permisos básicos para consultar y actualizar órdenes asignadas',
                'jerarquia' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_rol' => 'Técnico',
                'descripcion' => 'Usuario con permisos para gestionar órdenes, clientes y equipos',
                'jerarquia' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_rol' => 'Administrador',
                'descripcion' => 'Usuario con acceso completo al sistema y gestión de usuarios',
                'jerarquia' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
