<?php

namespace App\Http\Controllers;

use App\Models\CatalagoVelocidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalagoVelocidadController extends Controller
{
    public function index(Request $request)
    {
         // Realiza la consulta con los filtros
         $velocidad = DB::table('catalago_velocidad')
         ->when($request->telar, function ($query) use ($request) {
             return $query->where('telar', 'like', '%' . $request->telar . '%');
         })
         ->when($request->salon, function ($query) use ($request) {
             return $query->where('salon', 'like', '%' . $request->salon . '%');
         })
         ->when($request->tipo_hilo, function ($query) use ($request) {
             return $query->where('tipo_hilo', 'like', '%' . $request->tipo_hilo . '%');
         })
         ->when($request->velocidad, function ($query) use ($request) {
             return $query->where('velocidad', 'like', '%' . $request->velocidad . '%');
         })
         ->when($request->densidad, function ($query) use ($request) {
             return $query->where('densidad', 'like', '%' . $request->densidad . '%');
         })
         ->get();
 
         // Verifica si hay resultados
         $noResults = $velocidad->isEmpty();
 
         // Pasa los resultados y el estado de "sin resultados"
         return view('catalagos.catalagoVelocidad', compact('velocidad', 'noResults'));
    }

    public function create()
    {
        return view('catalagos.velocidadCreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'telar' => 'required',
            'salon' => 'required',
            'tipo_hilo' => 'required',
            'velocidad' => 'required',
            'densidad' => 'required',
        ]);

        CatalagoVelocidad::create([
            'telar' => $request->telar,
            'salon' => $request->salon,
            'tipo_hilo' => $request->tipo_hilo,
            'velocidad' => $request->velocidad,
            'densidad' => $request->densidad,
        ]);

        return redirect()->route('velocidad.index')->with('success', 'Velocidad agregada exitosamente!');
    }
}
