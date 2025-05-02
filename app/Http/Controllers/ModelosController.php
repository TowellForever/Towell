<?php

namespace App\Http\Controllers;

use App\Models\Modelos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModelosController extends Controller
{
  public function index (Request $request)
  {
      $query = Modelos::query(); // Usamos directamente Eloquent
  
      // Aplicamos filtros si existen
      if ($request->filled('column') && $request->filled('value')) {
          $columns = $request->input('column');
          $values = $request->input('value');
  
          foreach ($columns as $index => $column) {
              if (!empty($column) && isset($values[$index])) {
                  $query->where($column, 'like', '%' . $values[$index] . '%');
                }
            }
      }
  
      $modelos = $query->simplePaginate(10);
      $fillableFields = (new Modelos())->getFillable();
  
      return view('modulos.modelos.index', compact('modelos', 'fillableFields')); //modulos.modelos.index ponemos punto en lugar de slash, usando la convencion correcta de laravel
  }

  //metodos para FLOGS
  public function buscarFlogso(Request $request){
    $query = $request->input('q');

    $resultados = DB::connection('sqlsrv_ti')
    ->table('TWFLOGSTABLE')
    ->select('IDFLOG', 'TIPOPEDIDO', 'NAMEPROYECT', 'ESTADOFLOG', 'CUSTNAME')
    ->whereIn('ESTADOFLOG', [3, 4, 5, 21])
    ->where('DATAAREAID', 'pro')
    ->where(function ($queryBuilder) use ($query) {
        $queryBuilder->where('IDFLOG', 'LIKE', '%' . $query . '%')
            ->orWhere('TIPOPEDIDO', 'LIKE', '%' . $query . '%')
            ->orWhere('NAMEPROYECT', 'LIKE', '%' . $query . '%')
            ->orWhere('CUSTNAME', 'LIKE', '%' . $query . '%');
    })
    ->orderBy('IDFLOG', 'asc') // Orden alfabético
    ->limit(10)
    ->get();

    return response()->json($resultados);
  }

  
}

