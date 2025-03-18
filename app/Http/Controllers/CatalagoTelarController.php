<?php

namespace App\Http\Controllers;

use App\Models\CatalagoTelar;

class CatalagoTelarController extends Controller
{
    public function index()
    {
        // Obtener todos los registros de la tabla 'catalago_telares'
        $telares = CatalagoTelar::all();

        // Pasar los datos a la vista
        return view('catalagos.catalagoTelares', compact('telares'));
    }
}
