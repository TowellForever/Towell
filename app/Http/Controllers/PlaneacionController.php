<?php

namespace App\Http\Controllers;

use App\Models\Planeacion; // Asegúrate de importar el modelo Planeacion

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
}
