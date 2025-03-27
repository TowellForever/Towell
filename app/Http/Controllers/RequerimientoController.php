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
        
        // Si el registro es de tipo 'rizo'
        if ($request->rizo == 1) {
            // Verificar si ya existe un registro activo de tipo 'rizo' para este telar
            $ultimoRequerimientoRizo = Requerimiento::where('rizo', 1)
                ->where('status', 'activo')
                ->where('telar', $request->telar)  // Verificar por telar
                ->orderBy('fecha_hora_creacion', 'desc')
                ->first();
            
            if ($ultimoRequerimientoRizo) {
                // Si ya existe un activo, lo marcamos como 'cancelado'
                Requerimiento::where('id', $ultimoRequerimientoRizo->id)
                    ->update(['status' => 'cancelado']);
            }
        }
        
        // Si el registro es de tipo 'pie'
        if ($request->pie == 1) {
            // Verificar si ya existe un registro activo de tipo 'pie' para este telar
            $ultimoRequerimientoPie = Requerimiento::where('pie', 1)
                ->where('status', 'activo')
                ->where('telar', $request->telar)  // Verificar por telar
                ->orderBy('fecha_hora_creacion', 'desc')
                ->first();
            
            if ($ultimoRequerimientoPie) {
                // Si ya existe un activo, lo marcamos como 'cancelado'
                Requerimiento::where('id', $ultimoRequerimientoPie->id)
                    ->update(['status' => 'cancelado']);
            }
        }
        
        // Insertar el nuevo registro
        $nuevoRequerimiento = Requerimiento::create([
            'telar' => $request->telar,
            'cuenta_rizo' => $request->cuenta_rizo,
            'cuenta_pie' => $request->cuenta_pie,
            'fecha'=>$request->fecha,
            //'metros' => $request->metros,
            //'julio_reserv' => $request->julio_reserv,
            'status' => 'activo', // El nuevo registro será activo
            'orden_prod' => $request->orden_prod,
            'valor'=>$request->valor,
            //'metros_pie'=>$request->metros_pie,
            //'julio_reserv_pie'=>$request->julio_reserv_pie,
            'fecha_hora_creacion' => now(), // Fecha actual
            'rizo'=>$request->rizo,
            'pie'=>$request->pie,
        ]);
        
        return response()->json(['message' => 'Requerimiento guardado exitosamente', 'data' => $nuevoRequerimiento]);
    }
    


    public function obtenerRequerimientosActivos()
    {
        $fechaHoy = now()->toDateString(); // Fecha actual
    
        // Filtrar por el valor de 'rizo' o 'pie'
        $requerimientos = Requerimiento::where('status', 'activo')
            ->whereDate('fecha_hora_creacion', $fechaHoy) // Filtrar por la fecha actual
            ->where(function ($query) {
                $query->where('rizo', 1) // Si 'rizo' es 1
                      ->orWhere('pie', 1); // O si 'pie' es 1
            })
            ->get();
    
        return response()->json($requerimientos);
    }    

}
