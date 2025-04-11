<?php

namespace App\Http\Controllers;

use App\Models\ConstruccionUrdido;
use App\Models\Julio;
use App\Models\OrdenUrdido;
use Illuminate\Http\Request;
use App\Models\UrdidoEngomado;
use App\Models\Requerimiento;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UrdidoController extends Controller
{
    //
    public function cargarDatosUrdido(Request $request)
    {
        $folio = $request->folio;

        // Obtener los datos de las tres tablas basadas en el folio
        $urdido = UrdidoEngomado::where('folio', $folio)->first();
        $construccion = ConstruccionUrdido::where('folio', $folio)->get(); // Usamos get() también para la construcción
        $requerimiento = Requerimiento::where('orden_prod', $folio)->first();
        $ordenUrdido = OrdenUrdido::where('folio', $folio)->get(); //obtenemos los registros que van en la tabla de Registro de Produccion
        $julios = Julio::where('tipo', 'urdido')->get();

        if (!$urdido || !$construccion || !$requerimiento||!$ordenUrdido||!$julios) {
            return redirect()->route('ingresarFolio')->withErrors('No se encontraron datos para el folio proporcionado.');
        }

        // Pasar los datos a la vista
        return view('modulos/urdido', compact('urdido', 'construccion', 'requerimiento','ordenUrdido','julios'));
    }

    //mewtodo para insertar o actualizar registro de ORDEN
    public function updateOrdenUrdido(Request $request)
    {
        // Obtener los registros del request
        $registros = $request->input('registros');
        
        foreach ($registros as $registro) {
            // Validar los datos
            $validated = Validator::make($registro, [
                'folio' => 'required',
                'id2' => 'required', // Validar que id2 esté presente
                'fecha' => 'required',
            ])->validate();
    
            // Buscar si ya existe un registro con el mismo 'id2' y 'folio'
            $existente = OrdenUrdido::where('id2', $registro['id2'])    
                ->where('folio', $registro['folio'])
                ->first();
            
            // Si existe, actualizamos el registro
            if ($existente) {
                $existente->update($registro);
            } else {
                // Si no existe, creamos un nuevo registro
                OrdenUrdido::create($registro);
            }
        }
    
        return response()->json(['message' => 'Todos los registros fueron guardados correctamente.']);
    }
    
    public function finalizarUrdido(Request $request)
    {
        $folio = $request->input('folio');

        if (!$folio) {
            return response()->json(['message' => 'Folio no proporcionado.'], 400);
        }

        $registro = \App\Models\UrdidoEngomado::where('folio', $folio)->first();

        if (!$registro) {
            return response()->json(['message' => 'Registro no encontrado.'], 404);
        }

        $registro->estatus_urdido = 'finalizado';
        $registro->save();

        return response()->json(['message' => 'Estatus actualizado a FINALIZADO.']);
    }

    
}
