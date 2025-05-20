<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Select2Controller extends Controller
{
    // CONTROLADOR PARA TODOS LOS SELECTs2 del proyecto c:
    public function getBomIds(Request $request)
    {
        $search = $request->input('q');     // texto del buscador
        $tipo = $request->input('tipo');    // nuevo filtro

        $query = DB::connection('sqlsrv_ti')
            ->table('TI_PRO.dbo.BOMVersion')
            ->select('BOMID')
            ->where('ITEMID', 'julio-urdido');

        // Filtro por búsqueda
        if (!empty($search)) {
            $query->where('BOMID', 'like', '%' . $search . '%');
        }

        // Filtro por tipo (si es que aplica a tu lógica)
        if (!empty($tipo)) {
            $query->where('BOMID', 'like', '%' . $tipo . '%'); // o tu lógica personalizada
        }

        $data = $query->groupBy('BOMID')->orderBy('BOMID')->get();

        return response()->json($data);
    }

    //funcion para recuperar BOMIDs segun PIE o RIZO para ENGOMADO DATA
    public function getBomIds2(Request $request)
    {
        $search = $request->input('q');     // texto buscado
        $tipo = $request->input('tipo');    // Pie o Rizo

        $query = DB::connection('sqlsrv_ti')
            ->table('TI_PRO.dbo.BOMVersion')
            ->select('BOMID');

        // Filtro por tipo
        if ($tipo === 'Rizo') {
            $query->whereIn('ITEMID', ['JU-ENG-RI-C', 'JU-ENG-RI-A']);
        } elseif ($tipo === 'Pie') {
            $query->whereIn('ITEMID', ['JU-ENG-PI-C', 'JU-ENG-PI-A']);
        }

        // Filtro por texto buscado
        if (!empty($search)) {
            $query->where('BOMID', 'like', '%' . $search . '%');
        }

        $data = $query->groupBy('BOMID')->orderBy('BOMID')->get();

        return response()->json($data);
    }
}
