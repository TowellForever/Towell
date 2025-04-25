<?php

namespace App\Http\Controllers;

use App\Models\Modelos;
use Illuminate\Http\Request;

class ModelosController extends Controller
{
    public function index()
    {
        // Obtener todos los modelos
        $modelos = Modelos::paginate(100); // 100 por página


        return view('/modelos', compact('modelos'));
    }
}
