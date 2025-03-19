<?php

namespace App\Http\Controllers;

use App\Models\CatalagoEficiencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalagoEficienciaController extends Controller
{
    public function index(Request $request)
    {
        // Realiza la consulta con los filtros
        $eficiencia = DB::table('catalago_eficiencia')
        ->when($request->telar, function ($query) use ($request) {
            return $query->where('telar', 'like', '%' . $request->telar . '%');
        })
        ->when($request->salon, function ($query) use ($request) {
            return $query->where('salon', 'like', '%' . $request->salon . '%');
        })
        ->when($request->tipo_hilo, function ($query) use ($request) {
            return $query->where('tipo_hilo', 'like', '%' . $request->tipo_hilo . '%');
        })
        ->when($request->eficiencia, function ($query) use ($request) {
            return $query->where('eficiencia', 'like', '%' . $request->eficiencia . '%');
        })
        ->when($request->densidad, function ($query) use ($request) {
            return $query->where('densidad', 'like', '%' . $request->densidad . '%');
        })
        ->get();

        // Verifica si hay resultados
        $noResults = $eficiencia->isEmpty();

        // Pasa los resultados y el estado de "sin resultados"
        return view('catalagos.catalagoEficiencia', compact('eficiencia', 'noResults'));
    }

    public function create()
    {
        return view('catalagos.eficienciaCreate');
    }

    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'telar' => 'required',
            'salon' => 'required',
            'tipo_hilo' => 'required',
            'eficiencia' => 'required',
            'densidad' => 'required',
        ]);

        // Crear una nueva entrada en la tabla de eficiencia
        CatalagoEficiencia::create([
            'telar' => $request->telar,
            'salon' => $request->salon,
            'tipo_hilo' => $request->tipo_hilo,
            'eficiencia' => $request->eficiencia,
            'densidad' => $request->densidad,
        ]);

        // Redirigir a la lista de eficiencias con un mensaje de éxito
        return redirect()->route('eficiencia.index')->with('success', 'Eficiencia agregada exitosamente!');
    }
}
