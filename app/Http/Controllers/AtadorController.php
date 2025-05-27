<?php

namespace App\Http\Controllers;

use App\Models\UrdidoEngomado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AtadorController extends Controller
{
    public function cargarDatosUrdEngAtador()
    {
        //Log::info('Data:', $request->all());

        // Obtener los datos de las tres tablas basadas en el folio
        $atadores = DB::table('Produccion.dbo.TWDISPONIBLEURDENG2 as d')
            ->join('Produccion.dbo.requerimiento as r', 'd.reqid', '=', 'r.id')
            ->select('d.fecha', 'd.tipo', 'd.no_julio', 'd.metros', 'd.orden', 'r.telar', 'r.valor') // O especifica campos como: 'd.dis_id', 'r.telar', etc.
            ->get();

        // Pasar los datos a la vista
        return view('modulos/atadores/programar', compact('atadores'));
    }
}
