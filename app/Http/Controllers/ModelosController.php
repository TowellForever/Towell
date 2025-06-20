<?php

namespace App\Http\Controllers;

use App\Models\Modelos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModelosController extends Controller
{
  public function index(Request $request)
  {
    $query = Modelos::query();

    // Filtros
    if ($request->filled('column') && $request->filled('value')) {
      $columns = $request->input('column');
      $values = $request->input('value');

      foreach ($columns as $index => $column) {
        if (!empty($column) && isset($values[$index])) {
          $query->where($column, 'like', '%' . $values[$index] . '%');
        }
      }
    }

    $page = $request->input('page', 1);
    $perPage = 30;

    $results = $query->get(); // Recuperamos todos los datos compatibles con SQL Server 2008
    $total = $results->count();

    $modelos = $results->slice(($page - 1) * $perPage, $perPage)->values(); // Corte manual de la colección

    $fillableFields = (new Modelos())->getFillable();

    return view('modulos.modelos.index', [
      'modelos' => $modelos,
      'total' => $total,
      'perPage' => $perPage,
      'currentPage' => $page,
      'fillableFields' => $fillableFields,
    ]);
  }


  //metodos para FLOGS
  public function buscarFlogso(Request $request)
  {
    $query = $request->input('fingered');

    // Conexión y búsqueda en la tabla con LIKE para coincidencias parciales
    $resultados = DB::connection('sqlsrv_ti')
      ->table('TWFLOGSITEMLINE')
      ->select('INVENTSIZEID', 'ITEMID', 'IDFLOG', 'ITEMNAME')
      ->where('IDFLOG', 'like', '%' . $query . '%') // <-- Esto busca coincidencias parciales
      ->orderBy('IDFLOG', 'asc')
      ->get();

    return response()->json($resultados);
  }
}


/* Anterior forma de buscar flogs
  public function buscarFlogso(Request $request){
    $query = $request->input('fingered');
    $resultados = DB::connection('sqlsrv_ti')
      ->table('TWFLOGSITEMLINE')
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
 
 
 */
