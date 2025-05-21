<?php

namespace App\Http\Controllers;

use App\Models\ConstruccionJulios;
use App\Models\ConstruccionUrdido;
use App\Models\Julio;
use App\Models\Oficial;
use App\Models\OrdenEngomado;
use App\Models\OrdenUrdido;
use App\Models\Requerimiento;
use App\Models\UrdidoEngomado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class EngomadoController extends Controller
{
    public function cargarDatosEngomado(Request $request)
    {
        //Log::info('Data:', $request->all());
        $folio = $request->folio;

        // Obtener los datos de las tres tablas basadas en el folio
        $engomadoUrd = UrdidoEngomado::where('folio', $folio)->first();
        $julios = Julio::where('tipo', 'engomado')->get();
        $engomado = OrdenEngomado::where('folio', $folio)->get();
        $requerimiento = Requerimiento::where('orden_prod', $folio)->first();
        $oficiales = Oficial::all();
        //Log::info('Data:', $request->all());
        //Log::info('Data:', $engomadoUrd->toArray());
        //Log::info('Data:', $julios->toArray());
        //Log::info('Data:', $engomado->toArray());
        //Log::info('Data:', $requerimiento->toArray());

        if (!$engomadoUrd || !$julios || !$engomado || !$requerimiento || !$oficiales) {
            return redirect()->route('ingresarFolio')->withErrors('La orden ingresada (' . $request->folio . ') no se ha encontrado. Por favor, valide el número e intente de nuevo.');
        }

        // Pasar los datos a la vista
        return view('modulos/engomado', compact('engomadoUrd', 'julios', 'engomado', 'requerimiento', 'oficiales'));
    }

    //mewtodo para insertar o actualizar registro de ORDEN

    public function guardarYFinalizar(Request $request)
    {
        // 1. Obtener datos del request
        $registros = $request->input('registros');
        $generales = $request->input('generales');

        // 2. Validar que exista folio
        if (!$generales || !isset($generales['folio'])) {
            return response()->json(['message' => 'Folio no proporcionado.'], 400);
        }

        $folio = $generales['folio'];

        // 3. Guardar o actualizar los datos generales en la tabla urdido_engomado
        \App\Models\UrdidoEngomado::updateOrCreate(
            ['folio' => $folio],
            $generales
        );

        // 4. Guardar o actualizar los registros en orden_engomado
        foreach ($registros as $registro) {
            $validated = Validator::make($registro, [
                'folio' => 'required',
                'id2' => 'required',
            ])->validate();

            $existente = \App\Models\OrdenEngomado::where('id2', $registro['id2'])
                ->where('folio', $registro['folio'])
                ->first();

            if ($existente) {
                $existente->update($registro);
            } else {
                \App\Models\OrdenEngomado::create($registro);
            }
        }

        // 5. Finalizar el engomado (cambiar estatus)
        $registroGeneral = \App\Models\UrdidoEngomado::where('folio', $folio)->first();

        if (!$registroGeneral) {
            return response()->json(['message' => 'Registro no encontrado.'], 404);
        }

        $registroGeneral->estatus_engomado = 'finalizado';
        $registroGeneral->save();

        return response()->json(['message' => 'Registros guardados y engomado finalizado correctamente.']);
    }


    //Metodo para la impresion de Urdido Engomado
    public function imprimirOrdenUE($folio)
    {
        //el FOLIO esta llegando como parte de la url, no como un objto que se trata con REQUEST.
        // escribir $folio = $request; Eso guarda todo el objeto Request en la variable $folio, lo cual no tiene sentido a menos que luego vayas a manipular el request completo con ese nombre (lo cual es confuso y no recomendado). 
        $orden = UrdidoEngomado::where('folio', $folio)->first();
        $julios = ConstruccionJulios::where('folio', $folio)->get(); //julios dados de alta en programacion-requerimientos

        return view('modulos\tejido\imprimir-orden-UrdEng', compact('folio', 'orden', 'julios'));
    }
}
