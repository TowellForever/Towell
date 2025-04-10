<?php

namespace App\Http\Controllers;

use App\Models\ConstruccionUrdido;
use App\Models\Julio;
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
        $urdido = UrdidoEngomado::where('folio', $folio)->first();
        $julios = Julio::all();
        $engomado = OrdenEngomado::where('folio', $folio)->get();


        // Pasar los datos a la vista
        return view('modulos/engomado', compact('urdido','julios','engomado'));
    }

     //mewtodo para insertar o actualizar registro de ORDEN
     public function updateOrdenEngomado(Request $request)
     {
         // Obtener los registros del request
         $registros = $request->input('registros');
         
         foreach ($registros as $registro) {
             // Validar los datos
             $validated = Validator::make($registro, [
                 'folio' => 'required',
                 'id2' => 'required', // Validar que id2 esté presente
             ])->validate();
     
             // Buscar si ya existe un registro con el mismo 'id2' y 'folio'
             $existente = OrdenEngomado::where('id2', $registro['id2'])    
                 ->where('folio', $registro['folio'])
                 ->first();
             
             // Si existe, actualizamos el registro
             if ($existente) {
                 $existente->update($registro);
             } else {
                 // Si no existe, creamos un nuevo registro
                 OrdenEngomado::create($registro);
             }
         }
     
         return response()->json(['message' => 'Todos los registros fueron guardados correctamente.']);
     }
}