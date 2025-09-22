<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $marcas = [
            'Apple', 'Samsung', 'Sony', 'LG', 'Xiaomi', 'Huawei', 
            'Lenovo', 'HP', 'Dell', 'Asus', 'Acer', 'MSI',
            'Nintendo', 'Microsoft', 'Logitech', 'Razer',
            'Canon', 'Nikon', 'GoPro', 'JBL', 'Bose'
        ];

        foreach ($marcas as $marca) {
            DB::table('marcas')->insert([
                'nombre_marca' => $marca,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
