<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FallaSeeder extends Seeder
{
    public function run()
    {
        DB::table('fallas')->insert([
            [
                'clave' => 'F001',
                'descripcion' => 'Falla en motor principal',
                'tipo' => 'mecanica',
            ],
            [
                'clave' => 'F002',
                'descripcion' => 'Corto circuito en tablero',
                'tipo' => 'electrica',
            ],
            [
                'clave' => 'F003',
                'descripcion' => 'Desalineación de rodillos',
                'tipo' => 'mecanica',
            ],
            [
                'clave' => 'F004',
                'descripcion' => 'Fusible quemado',
                'tipo' => 'electrica',
            ],
        ]);
    }
}
