<?php

namespace App\Http\Controllers;

use App\Models\CatalagoVelocidad;
use Illuminate\Http\Request;

class CatalagoVelocidadController extends Controller
{
    public function index()
    {
        // Obtener todos los registros de la tabla 'catalago_telares'
        $velocidad = CatalagoVelocidad::all();

        // Pasar los datos a la vista
        return view('catalagos.catalagoVelocidad', compact('velocidad'));
    }
}
