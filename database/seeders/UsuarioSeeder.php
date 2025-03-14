<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Usuario::insert([
            [
                'numero_empleado' => '1001',
                'nombre' => 'Juan Pérez',
                'contrasenia' => bcrypt('123'),
                'area' => 'Almacen',
                'foto' => 'fotos_usuarios/juan_perez2.jpg',
            ],
            [
                'numero_empleado' => '1002',
                'nombre' => 'María López',
                'contrasenia' => bcrypt('123'),
                'area' => 'Urdido',
                'foto' => 'fotos_usuarios/maría_lopez.jpg',
            ],
            [
                'numero_empleado' => '1003',
                'nombre' => 'Almacen',
                'contrasenia' => bcrypt('123'),
                'area' => 'Finanzas',
                'foto' => 'fotos_usuarios/carlos_ramirez.jpg',
            ],
            [
                'numero_empleado' => '1004',
                'nombre' => 'Engomado',
                'contrasenia' => bcrypt('123'),
                'area' => 'Marketing',
                'foto' => 'fotos_usuarios/ana_torres.jpg',
            ],
            [
                'numero_empleado' => '1005',
                'nombre' => 'Tejido',
                'contrasenia' => bcrypt('123'),
                'area' => 'Ventas',
                'foto' => 'fotos_usuarios/pedro_gomez.jpg',
            ],
        ]);
    }
}
