<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requerimiento;

class RequerimientoController extends Controller
{
    public function index()
    {
        $requerimientos = Requerimiento::all();
        return view('requerimiento.index', compact('requerimientos'));
    }
    
    public function store(Request $request)
    {
        $fechaHoy = now()->toDateString(); // Fecha actual
    
        // Obtener el último registro con la misma orden de producción
        $ultimoRequerimiento = Requerimiento::where('orden_prod', $request->orden_prod)
        ->orderBy('fecha_hora_creacion', 'desc')
        ->first();

        if ($ultimoRequerimiento) {
        // Marcar todos los registros anteriores como "cancelado"
        Requerimiento::where('orden_prod', $request->orden_prod)
            ->where('fecha_hora_creacion', '<', $ultimoRequerimiento->fecha_hora_creacion)
            ->update(['status' => 'cancelado']);
        }

    
        // Insertar el nuevo registro
        $nuevoRequerimiento = Requerimiento::create([
            'cuenta_rizo' => $request->cuenta_rizo,
            'cuenta_pie' => $request->cuenta_pie,
            'metros' => $request->metros,
            'julio_reserv' => $request->julio_reserv,
            'status' => 'activo', // El nuevo registro será activo
            'orden_prod' => $request->orden_prod,
            'valor'=>$request->valor,
            'fecha_hora_creacion' => now(), // Fecha actual
        ]);
    
        return response()->json(['message' => 'Requerimiento guardado exitosamente', 'data' => $nuevoRequerimiento]);
    }
    


    public function obtenerRequerimientosActivos()
    {
        $fechaHoy = now()->toDateString(); // Fecha actual
    
        $requerimientos = Requerimiento::where('status', 'activo')
            ->whereDate('fecha_hora_creacion', $fechaHoy) // Filtrar por la fecha actual
            ->get();
    
        return response()->json($requerimientos);
    }
    

   
}
