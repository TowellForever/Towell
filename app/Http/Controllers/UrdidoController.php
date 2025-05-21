<?php

namespace App\Http\Controllers;

use App\Models\ConstruccionJulios;
use App\Models\ConstruccionUrdido;
use App\Models\Julio;
use App\Models\Oficial;
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
        $oficiales = Oficial::all();

        if (!$urdido || !$construccion || !$requerimiento || !$ordenUrdido || !$julios || !$oficiales) {
            return redirect()->route('ingresarFolio')->withErrors('La orden ingresada (' . $request->folio . ') no se ha encontrado. Por favor, valide el número e intente de nuevo.');
        }

        // Pasar los datos a la vista
        return view('modulos/urdido', compact('urdido', 'construccion', 'requerimiento', 'ordenUrdido', 'julios', 'oficiales'));
    }

    //mewtodo para insertar o actualizar registro de ORDEN-URDIDO y FINALIZARLO - se unificó dado que solicitaron borrar uno de los 2 botones.
    public function guardarYFinalizarUrdido(Request $request)
    {
        // Validación inicial del folio general
        $folio = $request->input('folio');

        if (!$folio) {
            return response()->json(['message' => 'Folio no proporcionado.'], 400);
        }

        // Guardar o actualizar registros de orden_urdido
        $registros = $request->input('registros');

        foreach ($registros as $registro) {
            // Validar los datos
            $validated = Validator::make($registro, [
                'folio' => 'required',
                'id2' => 'required',
                'fecha' => 'required',
            ])->validate();

            // Buscar si ya existe un registro con el mismo 'id2' y 'folio'
            $existente = OrdenUrdido::where('id2', $registro['id2'])
                ->where('folio', $registro['folio'])
                ->first();

            // Actualizar o crear
            if ($existente) {
                $existente->update($registro);
            } else {
                OrdenUrdido::create($registro);
            }
        }

        // Actualizar estatus en urdido_engomado
        $registroUrdido = \App\Models\UrdidoEngomado::where('folio', $folio)->first();

        if (!$registroUrdido) {
            return response()->json(['message' => 'Registro en urdido_engomado no encontrado.'], 404);
        }

        $registroUrdido->estatus_urdido = 'finalizado';
        $registroUrdido->save();

        return response()->json(['message' => 'Registros guardados y estatus actualizado a FINALIZADO.']);
    }
    //Metodo para la impresion de Urdido ya CON DATOS
    public function imprimirOrdenUrdido($folio)
    {
        //el FOLIO esta llegando como parte de la url, no como un objeto que se trata con REQUEST.
        // escribir $folio = $request; Eso guarda todo el objeto Request en la variable $folio, lo cual no tiene sentido a menos que luego vayas a manipular el request completo con ese nombre (lo cual es confuso y no recomendado). 
        $orden = UrdidoEngomado::where('folio', $folio)->first();
        $julios = ConstruccionJulios::where('folio', $folio)->get(); //julios dados de alta en programacion-requerimientos
        $ordUrdido = OrdenUrdido::where('folio', $folio)->get(); // recupero todos los registros que coincidan con el folio enviado del front

        return view('modulos\urdido\imprimir_orden_urdido_llena', compact('folio', 'orden', 'julios', 'ordUrdido'));
    }
}
