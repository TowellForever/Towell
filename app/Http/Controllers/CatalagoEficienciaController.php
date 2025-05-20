<?php

namespace App\Http\Controllers;

use App\Models\CatalagoEficiencia;
use App\Models\CatalagoVelocidad;
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
            ->when($request->telar, fn($q) => $q->where('telar', 'like', '%' . $request->telar . '%'))
            ->when($request->tipo_hilo, fn($q) => $q->where('tipo_hilo', 'like', '%' . $request->tipo_hilo . '%'))
            ->when($request->eficiencia, fn($q) => $q->where('eficiencia', 'like', '%' . $request->eficiencia . '%'))
            ->when($request->densidad, fn($q) => $q->where('densidad', 'like', '%' . $request->densidad . '%'));;

        // Contar total de registros sin paginar
        $total = (clone $query)->count();


        $subQuery = $query->selectRaw('*, ROW_NUMBER() OVER (ORDER BY id ASC) AS row_num');

        $eficiencia = DB::table(DB::raw("({$subQuery->toSql()}) as sub"))
            ->mergeBindings($subQuery)
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
            'tipo_hilo' => 'required',
            'eficiencia' => 'required',
            'densidad' => 'required',
        ]);

        // Crear una nueva entrada en la tabla de eficiencia
        CatalagoEficiencia::create([
            'telar' => $request->telar,
            'tipo_hilo' => $request->tipo_hilo,
            'eficiencia' => $request->eficiencia,
            'densidad' => $request->densidad,
        ]);

        // Redirigir a la lista de eficiencias con un mensaje de éxito
        return redirect()->route('eficiencia.index')->with('success', 'Eficiencia agregada exitosamente!');
    }

    public function edit($id)
    {
        $registro = CatalagoEficiencia::findOrFail($id);
        return view('catalagos.Eficiencia-edit', compact('registro'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'telar' => 'required',
            'tipo_hilo' => 'required',
            'eficiencia' => 'required',
            'densidad' => 'required',
        ]);

        $registro = CatalagoEficiencia::findOrFail($id);
        $registro->update($request->all());

        return redirect()->route('eficiencia.index')->with('success', 'Registro actualizado correctamente.');
    }

    public function destroy($id)
    {
        $registro = CatalagoVelocidad::findOrFail($id);
        $registro->delete();

        return redirect()->route('eficiencia.index')->with('success', 'Registro eliminado correctamente.');
    }
}
