<?php

namespace App\Http\Controllers;

use App\Imports\ExcelImport;
use App\Models\Planeacion;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImportacionesController extends Controller
{
    //
    public function showForm()
    {
        return view('TEJIDO-SCHEDULING.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'archivo' => 'required|mimes:xlsx,xls'
        ]);

        try {
            \App\Models\Planeacion::query()->delete(); //primero borramos todos los registros de TEJIDO_SCHEDULING, al ser tabla padre de tipo_movimientos estos se borrarán automaticamente
            Excel::import(new ExcelImport, $request->file('archivo'));
            // ← ACTUALIZA aquí después de importar:
            $this->actualizarEnProceso();
            return back()->with('success', '¡Archivo importado exitosamente!');
        } catch (\Exception $e) {
            return back()->with('error', 'Hubo un error al importar el archivo: ' . $e->getMessage());
        }
    }

    // En tu controlador, después de importar
    public function actualizarEnProceso()
    {
        // Resetea todos
        \App\Models\Planeacion::query()->update(['en_proceso' => 0]);

        // Por cada telar, selecciona el id con la fecha más baja
        $planeaciones = \App\Models\Planeacion::select('id', 'Telar', 'Inicio_Tejido')
            ->orderBy('Telar')
            ->orderBy('Inicio_Tejido')
            ->get();

        $agrupados = $planeaciones->groupBy('Telar');
        $ids = $agrupados->map(function ($items) {
            return $items->sortBy('Inicio_Tejido')->first()->id;
        })->values();

        \App\Models\Planeacion::whereIn('id', $ids)->update(['en_proceso' => 1]);
    }
}
