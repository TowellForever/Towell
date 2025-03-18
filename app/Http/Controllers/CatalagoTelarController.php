<?php

namespace App\Http\Controllers;

use App\Models\CatalagoTelar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalagoTelarController extends Controller
{
    public function index(Request $request)
    {
        // Realiza la consulta con los filtros
        $telares = DB::table('catalago_telares')
        ->when($request->salon, function ($query) use ($request) {
            return $query->where('salon', 'like', '%' . $request->salon . '%');
        })
        ->when($request->telar, function ($query) use ($request) {
            return $query->where('telar', 'like', '%' . $request->telar . '%');
        })
        ->when($request->nombre, function ($query) use ($request) {
            return $query->where('nombre', 'like', '%' . $request->nombre . '%');
        })
        ->when($request->cuenta, function ($query) use ($request) {
            return $query->where('cuenta', 'like', '%' . $request->cuenta . '%');
        })
        ->when($request->piel, function ($query) use ($request) {
            return $query->where('piel', 'like', '%' . $request->piel . '%');
        })
        ->when($request->ancho, function ($query) use ($request) {
            return $query->where('ancho', 'like', '%' . $request->ancho . '%');
        })
        ->get();

        // Verifica si hay resultados
        $noResults = $telares->isEmpty();

        // Pasa los resultados y el estado de "sin resultados"
        return view('catalagos.catalagoTelares', compact('telares', 'noResults'));
    }
}
