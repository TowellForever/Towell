<?php

namespace App\Http\Controllers;

use App\Models\CatalagoVelocidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalagoVelocidadController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page', 1); // Página actual
        $perPage = 10; // Número de registros por página
        $offset = ($page - 1) * $perPage; // Cálculo del inicio
    
        $query = DB::table('catalago_velocidad')
            ->selectRaw('*, ROW_NUMBER() OVER (ORDER BY id ASC) AS row_num')
            ->when($request->telar, fn($q) => $q->where('telar', 'like', '%' . $request->telar . '%'))
            ->when($request->salon, fn($q) => $q->where('salon', 'like', '%' . $request->salon . '%'))
            ->when($request->tipo_hilo, fn($q) => $q->where('tipo_hilo', 'like', '%' . $request->tipo_hilo . '%'))
            ->when($request->velocidad, fn($q) => $q->where('velocidad', 'like', '%' . $request->velocidad . '%'))
            ->when($request->densidad, fn($q) => $q->where('densidad', 'like', '%' . $request->densidad . '%'));
    
        // Contar total de registros sin paginar
        $total = $query->count();
    
        // Aplicar paginación usando una subconsulta
        $velocidad = DB::table(DB::raw("({$query->toSql()}) as sub"))
            ->mergeBindings($query)
            ->whereBetween('row_num', [$offset + 1, $offset + $perPage])
            ->get();
    
        $noResults = $velocidad->isEmpty();
    
        return view('catalagos.catalagoVelocidad', [
            'velocidad' => $velocidad,
            'noResults' => $noResults,
            'total' => $total,
            'perPage' => $perPage,
            'currentPage' => $page // Se mantiene la coherencia en la variable para la vista
        ]);
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
