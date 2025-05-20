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
}
