<?php

namespace App\Http\Controllers;

use App\Models\CatalagoEficiencia;
use Illuminate\Http\Request;

class CatalagoEficienciaController extends Controller
{
    public function index()
    {
        // Obtener todos los registros de la tabla 'catalago_telares'
        $eficiencia = CatalagoEficiencia::all();

        // Pasar los datos a la vista
        return view('catalagos.catalagoEficiencia', compact('eficiencia'));
    }
}
