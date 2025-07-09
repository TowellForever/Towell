<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReporteTemporal;

class ReporteTemporalController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'telar' => 'required|integer',
            'tipo' => 'required|string',
            'clave_falla' => 'required|string',
            'descripcion' => 'nullable|string',
            'fecha_reporte' => 'required|date',
            'hora_reporte' => 'required',
            'operador' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $reporte = ReporteTemporal::create($data);

        return response()->json([
            'success' => true,
            'id' => $reporte->id
        ]);
    }

    public function index()
    {
        $reportes = \App\Models\ReporteTemporal::orderBy('created_at', 'desc')->get();
        return view('modulos.mantenimiento', compact('reportes'));
    }
}
