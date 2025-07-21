<?php

namespace App\Http\Controllers;

use App\Imports\ExcelImport;
use App\Models\Planeacion;
use App\Models\RegistroImportacionesExcel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $telaresRequeridos = [201, 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 213, 214, 215, 299, 300, 301, 302, 303, 304, 305, 306, 307, 308, 309, 310, 311, 312, 313, 314, 315, 316, 317, 318, 319, 320];


        try {
            DB::beginTransaction(); // 🚩 INICIA la transacción

            // 1. Guarda los ids de los registros existentes
            $idsExistentes = \App\Models\Planeacion::pluck('id')->toArray();

            // 2. Importa el archivo (esto inserta los nuevos)
            Excel::import(new ExcelImport, $request->file('archivo'));

            // 3. Valida que existan todos los telares requeridos
            $this->validarTelaresExistentes($telaresRequeridos);

            // 4. Si todo está bien, borra los registros viejos (solo esos)
            if (!empty($idsExistentes)) {
                \App\Models\Planeacion::whereIn('id', $idsExistentes)->delete();
            }

            // 5. Actualiza en_proceso en los nuevos registros
            $this->actualizarEnProceso();

            //contamos registros insertados y guardamos el registro de la importacion en la tabla: registro_importaciones_excel
            //Cuenta los registros actuales en Planeacion (TEJIDO_SCHEDULING)
            $total = \App\Models\Planeacion::count();
            RegistroImportacionesExcel::create([
                'usuario' => Auth::user()->nombre, // O 'email', según tu modelo User
                'total_registros' => $total,
            ]);

            DB::commit(); // 🚩 TERMINA y guarda todo
            // EN EL CONTROLADOR, solo regresa con el mensaje
            return back()->with('success', '¡Archivo importado exitosamente!');
        } catch (\Exception $e) {
            DB::rollBack(); // 🚩 Si hay error, DESHACE TODO
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
    public function validarTelaresExistentes(array $telaresRequeridos)
    {

        // Busca todos los telares que existen en la tabla
        $telaresEnTabla = \App\Models\Planeacion::whereIn('Telar', $telaresRequeridos)
            ->pluck('Telar')
            ->unique()
            ->map(fn($t) => (int) $t)
            ->toArray();

        // Busca los telares que faltan
        $faltantes = array_diff($telaresRequeridos, $telaresEnTabla);

        if (!empty($faltantes)) {
            // Toma el primero que falte (puedes personalizar si quieres mostrar todos)
            $telarFaltante = reset($faltantes);
            // Lanza excepción personalizada
            throw new \Exception("No hay información disponible para el Telar {$telarFaltante}, debes cargar información para cada telar. Proceso anulado.");
        }
    }
}
