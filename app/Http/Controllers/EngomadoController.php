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
        $requerimiento = Requerimiento::where('orden_prod', 'like', $folio . '-%')->first();
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

        // 2. Validar campos obligatorios en 'generales'
        $validator = Validator::make($generales, [
            'folio' => 'required',
            'color' => 'required',
            'solidos' => 'required',
            'engomado' => 'required',
        ], [
            'folio.required' => 'Folio no proporcionado.',
            'color.required' => 'El campo "color" es obligatorio.',
            'solidos.required' => 'El campo "sólidos" es obligatorio.',
            'engomado.required' => 'El campo "engomado" es obligatorio.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Aún hay campos sin información, favor de llenar.',
                'errors' => $validator->errors()
            ], 422);
        }

        $folio = explode('-', $generales['folio']);

        // 3. Guardar o actualizar los datos generales en la tabla urdido_engomado
        \App\Models\UrdidoEngomado::updateOrCreate(
            ['folio' => $folio],
            $generales
        );

        // 4. Guardar o actualizar los registros en orden_engomado
        foreach ($registros as $registro) {
            // Limpiar el folio: eliminar cualquier sufijo como "-1", "-2", etc.
            if (isset($registro['folio'])) {
                $registro['folio'] = preg_replace('/-\d+$/', '', $registro['folio']);
            }

            $validated = Validator::make($registro, [
                'folio' => 'required',
                'id2' => 'required',
            ])->validate();

            $existente = \App\Models\OrdenEngomado::where('id2', $registro['id2'])
                ->where('folio', $registro['folio'])
                ->first();

            if ($existente) {
                $existente->update($registro); // Aquí ya se guarda limpio
            } else {
                \App\Models\OrdenEngomado::create($registro); // También se guarda limpio
            }
        }


        // 5. Finalizar el engomado
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
        $telares = Requerimiento::where('orden_prod', 'like', $folio . '-%')->pluck('telar');

        return view('modulos.programar_requerimientos.imprimir-orden-UrdEng', compact('folio', 'orden', 'julios', 'telares'));
    }

    public function cargarOrdenesPendientesEng()
    {
        $ordenesPendientesEngo = UrdidoEngomado::where('estatus_engomado', 'en_proceso')->get();
        return view('modulos.engomado.ingresar_folio', compact('ordenesPendientesEngo'));
    }
}
