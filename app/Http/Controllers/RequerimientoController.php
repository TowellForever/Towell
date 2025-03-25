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
        try {
            $data = $request->all();

            // Crear el registro
            $nuevoRequerimiento = Requerimiento::create([
                'cuenta_rizo' => $data['cuenta_rizo'],
                'cuenta_pie' => $data['cuenta_pie'],
                'fecha' => $data['fecha'],
                'turno' => $data['turno'],
                'metros' => $data['metros'],
                'status' => 'activo',
                'julio_reserv' => $data['julio_reserv'] ?? 'valor_predeterminado', // Asigna un valor por defecto si no está presente
                'orden_prod' => $data['orden_prod'] ?? 'valor_predeterminado', // Similar
                'fecha_hora_creacion' => now(), // Usar la fecha actual si es necesario
                'fecha_hora_modificado' => now(), // Usar la fecha actual si es necesario
    
                // Asignación de valores de los checkboxes directamente
                'ck_A1' => $data['ck_A1'],
                'ck_A2' => $data['ck_A2'],
                'ck_A3' => $data['ck_A3'],
                'ck_A4' => $data['ck_A4'],
                'ck_A5' => $data['ck_A5'],
                'ck_A6' => $data['ck_A6'],
                'ck_B1' => $data['ck_B1'],
                'ck_B2' => $data['ck_B2'],
                'ck_B3' => $data['ck_B3'],
                'ck_B4' => $data['ck_B4'],
                'ck_B5' => $data['ck_B5'],
                'ck_B6' => $data['ck_B6'],
                'ck_C1' => $data['ck_C1'],
                'ck_C2' => $data['ck_C2'],
                'ck_C3' => $data['ck_C3'],
                'ck_C4' => $data['ck_C4'],
                'ck_C5' => $data['ck_C5'],
                'ck_C6' => $data['ck_C6'],
                'ck_D1' => $data['ck_D1'],
                'ck_D2' => $data['ck_D2'],
                'ck_D3' => $data['ck_D3'],
                'ck_D4' => $data['ck_D4'],
                'ck_D5' => $data['ck_D5'],
                'ck_D6' => $data['ck_D6'],
                'ck_E1' => $data['ck_E1'],
                'ck_E2' => $data['ck_E2'],
                'ck_E3' => $data['ck_E3'],
                'ck_E4' => $data['ck_E4'],
                'ck_E5' => $data['ck_E5'],
                'ck_E6' => $data['ck_E6'],
                'ck_F1' => $data['ck_F1'],
                'ck_F2' => $data['ck_F2'],
                'ck_F3' => $data['ck_F3'],
                'ck_F4' => $data['ck_F4'],
                'ck_F5' => $data['ck_F5'],
                'ck_F6' => $data['ck_F6'],
                'ck_G1' => $data['ck_G1'],
                'ck_G2' => $data['ck_G2'],
                'ck_G3' => $data['ck_G3'],
                'ck_G4' => $data['ck_G4'],
                'ck_G5' => $data['ck_G5'],
                'ck_G6' => $data['ck_G6'],
            ]);
    
            // Responder con éxito
            return response()->json(['message' => 'Requerimiento guardado correctamente.'], 200);
    
        } catch (\Exception $e) {
            // Si ocurre algún error, responder con el error
            return response()->json(['message' => 'Error al guardar el requerimiento', 'error' => $e->getMessage()], 500);
        }
    }
    
    
   
}
