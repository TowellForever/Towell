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
  
}

