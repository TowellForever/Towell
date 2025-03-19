<?php

namespace App\Http\Controllers;

use App\Models\CatalagoEficiencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalagoEficienciaController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page', 1); // Página actual
        $perPage = 10; // Número de registros por página
        $offset = ($page - 1) * $perPage; // Cálculo del inicio

        $query = DB::table('catalago_eficiencia')
            ->selectRaw('*, ROW_NUMBER() OVER (ORDER BY id ASC) AS row_num')
            ->when($request->telar, fn($q) => $q->where('telar', 'like', '%' . $request->telar . '%'))
            ->when($request->salon, fn($q) => $q->where('salon', 'like', '%' . $request->salon . '%'))
            ->when($request->tipo_hilo, fn($q) => $q->where('tipo_hilo', 'like', '%' . $request->tipo_hilo . '%'))
            ->when($request->eficiencia, fn($q) => $q->where('eficiencia', 'like', '%' . $request->eficiencia . '%'))
            ->when($request->densidad, fn($q) => $q->where('densidad', 'like', '%' . $request->densidad . '%'));

        // Contar total de registros sin paginar
        $total = $query->count();

        // Aplicar paginación usando una subconsulta
        $eficiencia = DB::table(DB::raw("({$query->toSql()}) as sub"))
            ->mergeBindings($query)
            ->whereBetween('row_num', [$offset + 1, $offset + $perPage])
            ->get();

        $noResults = $eficiencia->isEmpty();

        return view('catalagos.catalagoEficiencia', [
            'eficiencia' => $eficiencia,
            'noResults' => $noResults,
            'total' => $total,
            'perPage' => $perPage,
            'currentPage' => $page // Se mantiene la coherencia en la variable para la vista
        ]);
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
