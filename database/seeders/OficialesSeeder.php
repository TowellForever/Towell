<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Oficial;

class OficialesSeeder extends Seeder
{
    public function run()
    {
        $oficiales = [
            ['oficial' => 'Carlos Pérez', 'tipo' => 'urdido'],
            ['oficial' => 'Laura Gómez', 'tipo' => 'engomado'],
            ['oficial' => 'Juan Martínez', 'tipo' => 'urdido'],
            ['oficial' => 'Ana Torres', 'tipo' => 'engomado'],
            ['oficial' => 'Luis Ramírez', 'tipo' => 'urdido'],
            ['oficial' => 'Sofía Herrera', 'tipo' => 'engomado'],
            ['oficial' => 'Marco Díaz', 'tipo' => 'urdido'],
            ['oficial' => 'Daniela Luna', 'tipo' => 'engomado'],
            ['oficial' => 'Héctor Ortega', 'tipo' => 'urdido'],
            ['oficial' => 'Miriam Soto', 'tipo' => 'engomado'],
        ];

        foreach ($oficiales as $oficial) {
            Oficial::create($oficial);
        }
    }
}
