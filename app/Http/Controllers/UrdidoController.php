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
        $julios = Julio::all();

        if (!$urdido || !$construccion || !$requerimiento||!$ordenUrdido||!$julios) {
            return redirect()->route('ingresarFolio')->withErrors('No se encontraron datos para el folio proporcionado.');
        }

        // Pasar los datos a la vista
        return view('modulos/urdido', compact('urdido', 'construccion', 'requerimiento','ordenUrdido','julios'));
    }

    //mewtodo para insertar o actualizar registro de ORDEN
    public function updateOrdenUrdido(Request $request)
    {
        //Log::info('Datos recibidos:', $request->all());

        $registros = $request->input('registros');
    
        foreach ($registros as $registro) {
            
            $validated = Validator::make($registro, [
                'folio' => 'required',
                'id' => 'required',
                'fecha' => 'required',
            ])->validate();

             
            // Asegúrate de que el folio y el id coincidan con lo esperado
            //Log::info("Buscando registro con folio: {$registro['folio']} y id: {$registro['id']}");
    
            $existente = OrdenUrdido::where('folio', $registro['folio'])
                ->where('id', $registro['id'])
                ->first();
    
            if ($existente) {
                $existente->update($registro);
            } else {
                OrdenUrdido::create($registro);
            }
        }

        return response()->json(['message' => 'Todos los registros fueron guardados correctamente.']);
    }
    
}
