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
use Illuminate\Support\Facades\DB;
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
        $requerimiento = Requerimiento::where('orden_prod', 'like', $folio . '-%')->first();
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

    //este metodo es del módulo de EDICION de URDIDO y ENGOMADO, envía los datos necesarios al front
    public function cargarDatosOrdenUrdEng(Request $request)
    {
        $folio = $request->folio;

        $requerimiento = Requerimiento::where('orden_prod', $folio)->first();
        // Obtener los datos de la tabla urdido_engomado
        $ordenCompleta = UrdidoEngomado::where('folio', $folio)->first(); //obtenemos los registros que van en la tabla de Registro de Produccion
        $julios = ConstruccionJulios::where('folio', $folio)->get(); //julios dados de alta en programacion-requerimientos
        //dd($ordenCompleta);

        //get() nunca será null, sino una colección (posiblemente vacía).
        if (is_null($ordenCompleta)) {
            return redirect()->route('ingresarFolioEdicion')
                ->withErrors('La orden ingresada (' . $request->folio . ') no se ha encontrado. Por favor, valide el número e intente de nuevo.');
        }


        // Pasar los datos a la vista con el folio
        return view('modulos/edicion_urdido_engomado/programarUrdidoEngomado', compact('folio', 'ordenCompleta', 'requerimiento', 'julios'));
    }

    public function ordenToActualizar(Request $request)
    {
        $folio = $request->folio;
        // Validación básica: puedes hacerlo con reglas o de forma manual
        $request->validate([
            'cuenta' => 'required',
            'urdido' => 'required',
            'proveedor' => 'required',
            'tipo' => 'required',
            'destino' => 'required',
            'metros' => 'required|numeric',
            'nucleo' => 'required',
            'no_telas' => 'required|integer',
            'lmaturdido' => 'required',
            'maquinaEngomado' => 'required',
            'lmatengomado' => 'required',
            // puedes agregar más campos si necesitas
        ], [
            'cuenta.required' => 'El campo cuenta es obligatorio.',
            'urdido.required' => 'El campo urdido es obligatorio.',
            'proveedor.required' => 'El campo proveedor es obligatorio.',
            'tipo.required' => 'El campo tipo es obligatorio.',
            'destino.required' => 'El campo destino es obligatorio.',
            'metros.required' => 'El campo metros es obligatorio.',
            'metros.numeric' => 'El campo metros debe ser un número.',
            'nucleo.required' => 'El campo núcleo es obligatorio.',
            'no_telas.required' => 'El campo número de telas es obligatorio.',
            'no_telas.integer' => 'El campo número de telas debe ser un número entero.',
            'lmaturdido.required' => 'El campo L. Mat. Urdido es obligatorio.',
            'maquinaEngomado.required' => 'El campo maquinaEngomado es obligatorio.',
            'lmatengomado.required' => 'El campo L. Mat. Engomado es obligatorio.',
        ]);


        // Validar que los arrays existan y tengan la misma longitud
        if (!is_array($request->no_julios) || !is_array($request->hilos)) {
            return redirect()->back()->with('error', 'Datos de construcción inválidos.');
        }

        // actualizar en urdido_engomado
        DB::table('urdido_engomado')
            ->where('folio', $request->folio)
            ->update([
                'cuenta' => $request->input('cuenta'),
                'urdido' => $request->input('urdido'),
                'proveedor' => $request->input('proveedor'),
                'tipo' => $request->input('tipo'),
                'destino' => $request->input('destino'),
                'metros' => $request->input('metros'),
                'nucleo' => $request->input('nucleo'),
                'no_telas' => $request->input('no_telas'),
                'balonas' => $request->input('balonas'),
                'metros_tela' => $request->input('metros_tela'),
                'cuendados_mini' => $request->input('cuendados_mini'),
                'observaciones' => $request->input('observaciones'),
                'created_at' => now(),
                'updated_at' => now(),
                'lmaturdido' => $request->input('lmaturdido'), //nuevos registros 20-05-2025
                'maquinaEngomado' => $request->input('maquinaEngomado'),
                'lmatengomado' => $request->input('lmatengomado'),

            ]);

        //tablita de construccion de julios 
        // Obtener registros actuales existentes para el folio
        // Obtener registros actuales existentes para el folio
        $registrosExistentes = DB::table('construccion_urdido')
            ->where('folio', $folio)
            ->orderBy('id') // Importante para mantener el orden
            ->get();

        // Datos del formulario
        $no_julios = $request->input('no_julios');
        $hilos = $request->input('hilos');

        // Filtrar datos válidos (ambos campos no vacíos)
        $valores_validos = [];
        for ($i = 0; $i < count($no_julios); $i++) {
            if (!empty($no_julios[$i]) && !empty($hilos[$i])) {
                $valores_validos[] = [
                    'no_julios' => $no_julios[$i],
                    'hilos' => $hilos[$i],
                ];
            }
        }

        // Insertar o actualizar registros válidos
        for ($i = 0; $i < count($valores_validos); $i++) {
            if (isset($registrosExistentes[$i])) {
                // Actualizar registro existente
                DB::table('construccion_urdido')
                    ->where('id', $registrosExistentes[$i]->id)
                    ->update([
                        'no_julios' => $valores_validos[$i]['no_julios'],
                        'hilos' => $valores_validos[$i]['hilos'],
                        'updated_at' => now(),
                    ]);
            } else {
                // Insertar nuevo registro
                DB::table('construccion_urdido')->insert([
                    'folio' => $folio,
                    'no_julios' => $valores_validos[$i]['no_julios'],
                    'hilos' => $valores_validos[$i]['hilos'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Eliminar registros sobrantes (si había más antes)
        if (count($valores_validos) < count($registrosExistentes)) {
            for ($j = count($valores_validos); $j < count($registrosExistentes); $j++) {
                DB::table('construccion_urdido')->where('id', $registrosExistentes[$j]->id)->delete();
            }
        }
        return view('modulos.edicion_urdido_engomado.FolioEnPantalla', compact('folio'));
    }
}
