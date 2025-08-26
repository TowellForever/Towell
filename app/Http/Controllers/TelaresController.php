<?php

namespace App\Http\Controllers;

use App\Models\Planeacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TelaresController
{
    //
    //metodos de TELARES (tablas de datos de tejido)********************************************************************************************************
    //El siguiente método obtiene un objeto con la informacion completa de la tabla TEJIDO_SCHEDULING, en lo sucesivo, se mostrará la informacon del telar en la vista dinámica individual
    public function mostrarTelarSulzer($telar)
    {
        // Buscar el registro en proceso para este telar
        $datos = DB::table('TEJIDO_SCHEDULING')
            ->where('en_proceso', true)
            ->where('Telar', $telar)
            ->get();


        //buscamos la orden que sigue despues de la que esta en proceso
        $actual = $datos->sortByDesc('Inicio_Tejido')->first(); // toma 1 (ajusta si quieres el más reciente/antiguo)
        $ref = $actual->Inicio_Tejido; // referencia: fecha del registro en proceso
        $ordenSig = DB::table('TEJIDO_SCHEDULING')
            ->where('en_proceso', 0)
            ->where('Telar', $telar)
            ->whereNotNull('Inicio_Tejido')
            ->where('Inicio_Tejido', '>', $ref)
            ->orderBy('Inicio_Tejido', 'asc') // la más próxima hacia adelante
            ->first();

        if ($datos->isEmpty()) {
            return redirect()->back()->with(
                'warning',
                "Selecciona un registro en planeación para poner en proceso y ver los datos del telar {$telar}."
            );
        }

        return view('modulos/tejido/telares/telar-informacion-individual', compact('telar', 'datos', 'ordenSig'));
    }

    public function obtenerOrdenesProgramadas($telar)
    {
        // Traemos solo los registros en_proceso = 0 para este telar
        $ordenes = Planeacion::where('Telar', $telar)
            ->where('en_proceso', 0)
            ->orderBy('Inicio_Tejido')
            ->get();
        // retornamos la vista correcta (no 'login')
        return view('modulos/tejido/telares/ordenes-programadas', compact('ordenes', 'telar'));
    }
}
