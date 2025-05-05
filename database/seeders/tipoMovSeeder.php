<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class tipoMovSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = Carbon::now();

        for ($tej_num = 2; $tej_num <= 50; $tej_num++) {
            for ($tipo_mov = 1; $tipo_mov <= 12; $tipo_mov++) {

                DB::table('tipo_movimientos')->insert([
                    'fecha'     => Carbon::create($now->year, $now->month, rand(1, 30))->toDateString(),
                    'tipo_mov'  => $tipo_mov,
                    'cantidad'  => round(mt_rand(100, 1000) / 10, rand(1, 2)), // 10.5, 87.43, etc.
                    'tej_num'   => $tej_num,
                ]);
            }
        }
    }
}
