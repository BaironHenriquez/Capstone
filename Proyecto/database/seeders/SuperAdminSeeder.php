<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = Role::where('nombre_rol', 'Super Admin')->first();

        if (!$superAdminRole) {
            $this->command->error('El rol Super Admin no existe. Ejecuta primero la migración.');
            return;
        }

        $existingSuperAdmin = User::where('role_id', $superAdminRole->id)->first();

        if ($existingSuperAdmin) {
            $this->command->info('Ya existe un usuario Super Admin: ' . $existingSuperAdmin->email);
            return;
        }

        $superAdmin = User::create([
            'name' => 'Super Administrador',
            'nombre' => 'Super',
            'apellido' => 'Administrador',
            'email' => 'superadmin@baieco.com',
            'password' => Hash::make('SuperAdmin2025!'),
            'contrasena' => Hash::make('SuperAdmin2025!'),
            'role_id' => $superAdminRole->id,
            'email_verified' => true,
            'email_verified_at' => now(),
        ]);

        $this->command->info('Super Admin creado exitosamente:');
        $this->command->info('Email: superadmin@baieco.com');
        $this->command->info('Password: SuperAdmin2025!');
    }
}
