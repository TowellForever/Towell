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


    //TELEGRAM
    public function guardar(Request $request)
    {
        dd($request);
        $data = $request->validate([
            'telar'         => 'required|string|max:50',
            'tipo'          => 'required|string|max:50',
            'clave_falla'   => 'nullable|string|max:50',
            'descripcion'   => 'required|string|max:1000',
            'fecha_reporte' => 'required|date_format:Y-m-d',
            'hora_reporte'  => 'required|date_format:H:i',
            'operador'      => 'nullable|string|max:100',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        $reporte = ReporteTemporal::create($data + [
            'enviado_telegram' => false,
        ]);

        return redirect()
            ->back()
            ->with('ok', "Reporte #{$reporte->id} capturado. Se enviará por Telegram desde el worker.");
    }
}
