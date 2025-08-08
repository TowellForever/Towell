<?php

namespace App\Http\Controllers;

use App\Models\Modelos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ModelosController extends Controller
{
  public function index(Request $request)
  {
    $page = $request->input('page', 1);
    $perPage = 30;
    $offset = ($page - 1) * $perPage;

    // Armamos el query base con filtros dinámicos
    $query = DB::table('modelos')
      ->when($request->column && $request->value, function ($q) use ($request) {
        $columns = $request->input('column');
        $values = $request->input('value');
        foreach ($columns as $index => $column) {
          if (!empty($column) && isset($values[$index])) {
            $q->where($column, 'like', '%' . $values[$index] . '%');
          }
        }
      });

    // Contar total de registros (sin paginar)
    $total = (clone $query)->count();

    // Subconsulta con ROW_NUMBER()
    $subQuery = $query->selectRaw('*, ROW_NUMBER() OVER (ORDER BY Fecha_Orden DESC) AS row_num');

    $modelos = DB::table(DB::raw("({$subQuery->toSql()}) as sub"))
      ->mergeBindings($subQuery)
      ->whereBetween('row_num', [$offset + 1, $offset + $perPage])
      ->get();

    // Obtener los fillable fields para mostrar columnas en la vista (usa el modelo Eloquent solo para esto)
    $fillableFields = (new Modelos())->getFillable();

    // Quitar las columnas que no quieres mostrar
    $camposOcultos = [
      'Fecha_Cumplimiento',
      'TOLERANCIA',
      'Fecha_Compromiso',
      'Cantidad_a_Producir',
      'No_De_Marbetes',
      'Cambio_de_repaso',
      'TRAMA_Ancho_Peine',
      'LOG_DE_LUCHA_TOTAL',
      'C1_Trama_de_Fondo',
      'Hilo_A_1',
      'OBS_A_1',
      'PASADAS_1',
      'C1_A_1',
      'Hilo_A_2',
      'OBS_A_2',
      'PASADAS_2',
      'C2_A_2',
      'Hilo_A_3',
      'OBS_A_3',
      'PASADAS_3',
      'C3_A_3',
      'Hilo_A_4',
      'OBS_A_4',
      'PASADAS_4',
      'C4_A_4',
      'Hilo_A_5',
      'OBS_A_5',
      'PASADAS_5',
      'C5_A_5',
      'Hilo_A_6',
      'OBS_A_6',
      'X',
      'TOTAL',
      'PASADAS_DIBUJO',
      'Contraccion',
      'Tramas_cm_Tejido',
      'Contrac_Rizo',
      'Clasificación(KG)',
      'KG_p_dia',
      'Densidad',
      'Pzas_p_dia_pasadas',
      'Pzas_p_dia_formula',
      'DIF',
      'EFIC',
      'Rev',
      'TIRAS_2',
      'PASADAS',
      'CU',
      'CV',
      'CW',
      'COMPROBAR_modelos_duplicados',
    ]; // las que quieras ocultar
    $fillableFields = array_values(array_diff($fillableFields, $camposOcultos));

    return view('modulos.modelos.index', [
      'modelos' => $modelos,
      'total' => $total,
      'perPage' => $perPage,
      'currentPage' => $page,
      'fillableFields' => $fillableFields,
    ]);
  }

  public function create()
  {
    return view('modulos.modelos.create');
  }

  public function store(Request $request)
  {

    Modelos::create($request->all());
    return redirect()->route('modelos.index')->with('success', 'Modelo creado exitosamente');
  }

  public function edit($clave_ax, $tamanio_ax)
  {

    $modelo = Modelos::where('CLAVE_AX', $clave_ax)
      ->where('Tamanio_AX', $tamanio_ax)
      ->first();

    if (!$modelo) {
      return redirect()->route('modelos.create')->with('error', 'Modelo no encontrado');
    }
    return view('modulos.modelos.edit', compact('modelo'));
  }

  public function update(Request $request, $clave_ax, $tamanio_ax)
  {
    Modelos::where('CLAVE_AX', $clave_ax)
      ->where('Tamanio_AX', $tamanio_ax)
      ->update($request->except(['_token', '_method']));

    return redirect()->route('modelos.index')->with('success', 'Modelo actualizado exitosamente');
  }

  public function destroy($concatena)
  {
    DB::table('MODELOS')->where('CONCATENA', $concatena)->delete();

    // Siempre responde JSON
    return response()->json(['success' => true, 'message' => 'Modelo eliminado exitosamente.']);
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
