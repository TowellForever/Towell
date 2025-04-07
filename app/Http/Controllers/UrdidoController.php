<?php

namespace App\Http\Controllers;

use App\Models\ConstruccionUrdido;
use App\Models\OrdenUrdido;
use Illuminate\Http\Request;
use App\Models\UrdidoEngomado;
use App\Models\Requerimiento;
use Illuminate\Support\Facades\Log;

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

        if (!$urdido || !$construccion || !$requerimiento) {
            return redirect()->route('ingresarFolio')->withErrors('No se encontraron datos para el folio proporcionado.');
        }

        // Pasar los datos a la vista
        return view('modulos/urdido', compact('urdido', 'construccion', 'requerimiento'));
    }

    //mewtodo para insertar o actualizar registro de ORDEN
    public function updateOrdenUrdido(Request $request)
    {
         // Validar los datos que llegan del formulario
        $validated = $request->validate([
            'folio' => 'required',
            'id' => 'required',
            'fecha' => 'required',
            'turno' => 'nullable',
            'hora_inicio' => 'nullable',
            'hora_fin' => 'nullable',
            'no_julio' => 'nullable',
            'hilos' => 'nullable',
            'peso_bruto' => 'nullable',
            'tara' => 'nullable',
            'peso_neto' => 'nullable',
            'metros' => 'nullable',
            'hilatura' => 'nullable',
            'maquina' => 'nullable',
            'operacion' => 'nullable',
            'transferencia' => 'nullable',
        ]);

        // Comprobar si ya existe un registro con el mismo folio y id
        $registroExistente = OrdenUrdido::where('folio', $request->folio)
                                        ->where('id', $request->id)
                                        ->first();

        if ($registroExistente) {
            // Si el registro ya existe, actualizar los campos
            $registroExistente->update([
                'fecha' => $request->fecha,
                'oficial' => $request->oficial,
                'turno' => $request->turno,
                'hora_inicio' => $request->hora_inicio,
                'hora_fin' => $request->hora_fin,
                'no_julio' => $request->no_julio,
                'hilos' => $request->hilos,
                'peso_bruto' => $request->peso_bruto,
                'tara' => $request->tara,
                'peso_neto' => $request->peso_neto,
                'metros' => $request->metros,
                'hilatura' => $request->hilatura,
                'maquina' => $request->maquina,
                'operacion' => $request->operacion,
                'transferencia' => $request->transferencia,
            ]);
            return response()->json(['message' => 'Registro actualizado correctamente.']);
        } else {
            // Si no existe, crear un nuevo registro
            OrdenUrdido::create([
                'folio' => $request->folio,
                'id' => $request->id,
                'fecha' => $request->fecha,
                'oficial'=>$request->oficial,
                'turno' => $request->turno,
                'hora_inicio' => $request->hora_inicio,
                'hora_fin' => $request->hora_fin,
                'no_julio' => $request->no_julio,
                'hilos' => $request->hilos,
                'peso_bruto' => $request->peso_bruto,
                'tara' => $request->tara,
                'peso_neto' => $request->peso_neto,
                'metros' => $request->metros,
                'hilatura' => $request->hilatura,
                'maquina' => $request->maquina,
                'operacion' => $request->operacion,
                'transferencia' => $request->transferencia,
            ]);
            return response()->json(['message' => 'Registro guardado correctamente.']);
        }
    }
}
