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
        $atadores = DB::table('Produccion.dbo.requerimiento as r')
            ->join('Produccion.dbo.urdido_engomado as u', 'r.orden_prod', '=', 'u.folio')
            ->select('fecha', 'tipo', 'valor', 'telar', 'orden_prod', 'proveedor', 'u.metros')
            ->where('status', 'activo')
            ->orderByRaw("CONVERT(DATETIME, fecha, 103)") // 103 = formato dd/mm/yyyy - usamos la funcion CONVERT porque es la que funciona en Windows Server 2008.
            ->get();




        // Pasar los datos a la vista
        return view('modulos/atadores/programar', compact('atadores'));
    }
}
