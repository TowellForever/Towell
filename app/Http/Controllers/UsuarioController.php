<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // Muestra el formulario de creación de usuario
    public function create() {
        return view('alta_usuarios');
    }

    // Almacena un nuevo usuario en la base de datos
    public function store(Request $request) {
        //dd($request->all()); // Muestra los datos enviados (puedes comentarlo después de probar)
    
        $data = $request->validate([
            'numero_empleado' => 'required|string',
            'nombre' => 'required|string',
            'contrasenia' => 'required|string',
            'area' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);
    
        // Asegurar que los checkboxes siempre tengan un valor válido (0 o 1)
        $checkboxes = ['almacen', 'urdido', 'engomado', 'tejido', 'atadores', 'tejedores', 'mantenimiento'];
        foreach ($checkboxes as $checkbox) {
            $data[$checkbox] = $request->has($checkbox) ? 1 : 0;
        }
    
        // Guardar usuario en la base de datos
        Usuario::create($data);
    
        return redirect()->route('usuarios.create')->with('success', 'Usuario registrado correctamente');
    }
    
    
}
