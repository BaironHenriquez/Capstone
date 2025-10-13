<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = [
            [
                'nombre' => 'Juan Carlos García',
                'apellido' => 'Rodríguez',
                'correo' => 'juan.garcia@email.com',
                'telefono' => '555-0101',
                'direccion' => 'Av. Libertador 123, Caracas',
                'rut' => '12345678-9',
                'servicio_tecnico_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'María Elena Pérez',
                'apellido' => 'Silva',
                'correo' => 'maria.perez@techcorp.com',
                'telefono' => '555-0102',
                'direccion' => 'Centro Empresarial Torre Este',
                'rut' => '23456789-1',
                'servicio_tecnico_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Carlos Eduardo',
                'apellido' => 'Martínez López',
                'correo' => 'carlos.martinez@gmail.com',
                'telefono' => '555-0103',
                'direccion' => 'Urbanización Los Palos Grandes',
                'rut' => '34567890-2',
                'servicio_tecnico_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ana Beatriz',
                'apellido' => 'Hernández Vargas',
                'correo' => 'ana.hernandez@digitalplus.ve',
                'telefono' => '555-0104',
                'direccion' => 'Zona Industrial La Urbina',
                'rut' => '45678901-3',
                'servicio_tecnico_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Roberto José',
                'apellido' => 'Sánchez González',
                'correo' => 'roberto.sanchez@hotmail.com',
                'telefono' => '555-0105',
                'direccion' => 'Altamira Sur, Edificio Metro',
                'rut' => '56789012-4',
                'servicio_tecnico_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Luisa Fernanda',
                'apellido' => 'Torres Castro',
                'correo' => 'luisa.torres@medicalcenter.com',
                'telefono' => '555-0106',
                'direccion' => 'Centro Médico Santa Fe',
                'rut' => '67890123-5',
                'servicio_tecnico_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Diego Alejandro',
                'apellido' => 'Moreno Ruiz',
                'correo' => 'diego.moreno@yahoo.com',
                'telefono' => '555-0107',
                'direccion' => 'Las Mercedes, CC Sambil',
                'rut' => '78901234-6',
                'servicio_tecnico_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Carmen Rosa',
                'apellido' => 'Jiménez Medina',
                'correo' => 'carmen.jimenez@outlook.com',
                'telefono' => '555-0108',
                'direccion' => 'Maracay, Urb San Jacinto',
                'rut' => '89012345-7',
                'servicio_tecnico_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Francisco Manuel',
                'apellido' => 'Delgado Ramos',
                'correo' => 'francisco.delgado@consultorios.ve',
                'telefono' => '555-0109',
                'direccion' => 'Valencia, CE Carabobo',
                'rut' => '90123456-8',
                'servicio_tecnico_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Valentina',
                'apellido' => 'Castillo Vega',
                'correo' => 'valentina.castillo@estudiante.ucv.ve',
                'telefono' => '555-0110',
                'direccion' => 'Ciudad Universitaria',
                'rut' => '11223344-9',
                'servicio_tecnico_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedro Antonio',
                'apellido' => 'Ramírez Flores',
                'correo' => 'pedro.ramirez@constructora.ve',
                'telefono' => '555-0111',
                'direccion' => 'Barquisimeto, Zona Industrial',
                'rut' => '22334455-0',
                'servicio_tecnico_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Isabella María',
                'apellido' => 'Gutiérrez Núñez',
                'correo' => 'isabella.gutierrez@gmail.com',
                'telefono' => '555-0112',
                'direccion' => 'Maracaibo, Bella Vista',
                'rut' => '33445566-1',
                'servicio_tecnico_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}
