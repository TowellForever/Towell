<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ Esto es lo que faltaba

class TejedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuario = \App\Models\Usuario::with('telares')->find(Auth::id()); //usando la relacion creada entre usuarios y catalago_telares, buscamos los telares pertenecientes al id (numero_usuario) del usuario que esta logeado o autenticado


        return view('modulos.tejedores.formato-BuenasPracticasManu', compact('usuario'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
