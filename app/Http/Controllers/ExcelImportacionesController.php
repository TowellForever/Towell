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
            Excel::import(new ExcelImport, $request->file('archivo'));
            return back()->with('success', '¡Archivo importado exitosamente!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with('error', 'Hubo un error al importar el archivo: ' . $e->getMessage());
        }
    }
}
