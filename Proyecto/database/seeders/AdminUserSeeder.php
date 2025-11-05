<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use App\Models\ServicioTecnico;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar o crear el rol de administrador
        $rolAdmin = Role::firstOrCreate(
            ['nombre_rol' => 'admin'],
            [
                'descripcion' => 'Administrador del sistema',
                'jerarquia' => 3
            ]
        );

        // Buscar o crear un servicio técnico
        $servicioTecnico = ServicioTecnico::first();
        
        if (!$servicioTecnico) {
            $servicioTecnico = ServicioTecnico::create([
                'nombre_servicio' => 'Servicio Técnico Principal',
                'direccion' => 'Av. Principal 123',
                'telefono' => '+56912345678',
                'correo' => 'servicio@baieco.cl',
                'rut' => '76.123.456-7',
                'descripcion' => 'Servicio técnico de reparación de equipos electrónicos',
                'logo' => null,
                'sitio_web' => 'https://baieco.cl',
                'horario_atencion' => 'Lunes a Viernes 9:00 - 18:00',
            ]);
        }

        // Verificar si ya existe un usuario admin
        $adminUser = User::where('email', 'admin@baieco.cl')->first();

        if (!$adminUser) {
            // Crear usuario administrador
            $adminUser = User::create([
                'name' => 'admin',
                'nombre' => 'Administrador',
                'apellido' => 'Sistema',
                'rut' => '12.345.678-9',
                'telefono' => '+56987654321',
                'email' => 'admin@baieco.cl',
                'password' => Hash::make('admin123'),
                'contrasena' => 'admin123',
                'role_id' => $rolAdmin->id,
                'servicio_tecnico_id' => $servicioTecnico->id,
                'email_verified_at' => now(),
            ]);

            $this->command->info('✅ Usuario administrador creado exitosamente!');
            $this->command->info('📧 Email: admin@baieco.cl');
            $this->command->info('🔑 Password: admin123');
        } else {
            // Actualizar el usuario existente con servicio técnico
            $adminUser->update([
                'servicio_tecnico_id' => $servicioTecnico->id,
            ]);
            
            $this->command->info('✅ Usuario administrador actualizado con servicio técnico!');
            $this->command->info('📧 Email: ' . $adminUser->email);
        }
    }
}
