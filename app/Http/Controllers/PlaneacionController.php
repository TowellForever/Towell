<?php

namespace App\Http\Controllers;

use App\Models\Planeacion; // Asegúrate de importar el modelo Planeacion
use Illuminate\Http\Request;

class PlaneacionController extends Controller
{
    // Método para obtener los datos y pasarlos a la vista
    public function index()
    {
        // Obtener todos los registros de la tabla planeacion
        $datos = Planeacion::all();

        // Pasar los datos a la vista
        return view('modulos.planeacion', compact('datos'));
    }

    public function calendarios()
    {
        return view('/catalagos/calendarios');
    }
    
    public function aplicaciones()
    {
        return view('/catalagos/aplicaciones');
    }
    
    public function update(Request $request, $id)
    {
        // Buscar el registro por Id
        $registro = Planeacion::where('Id', $id)->first();
    
        if (!$registro) {
            return redirect()->route('planeacion.index')->with('error', 'Registro no encontrado');
        }
    
        // Verificar si se marca el checkbox 'en_proceso'
        if ($request->has('en_proceso') && $request->en_proceso == '1') {
            // Desmarcar todos los registros con el mismo telar
            Planeacion::where('Telar', $registro->Telar)
                ->update(['en_proceso' => false]); // Desmarcar todos los registros del mismo telar
    
            // Luego marcar solo el registro actual
            $registro->update(['en_proceso' => true]);
        } else {
            // Si no se marca, simplemente desmarcar el registro actual
            $registro->update(['en_proceso' => false]);
        }
    
        // Redirigir con mensaje
        return redirect()->route('planeacion.index') // Asegúrate de redirigir a la ruta correcta
            ->with('success', 'Estado actualizado correctamente');
    }
    
    


}
