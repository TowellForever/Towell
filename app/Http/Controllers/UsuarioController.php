<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
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
    
    //METODO para filtrar los contenedores de la interfaz principal (produccionProceso), dependiendo
    public function index()
    {
        // Obtener el usuario autenticado
        $usuario = Auth::User(); 
    
        // Definir los módulos y sus rutas
        $modulos = [
            ['nombre' => 'Planeación', 'imagen' => 'planeacion.png', 'ruta' => route('planeacion.index'), 'permiso' => 'planeacion'],
            ['nombre' => 'Urdido', 'imagen' => 'urdido.jpg', 'ruta' => '#', 'permiso' => 'urdido'],
            ['nombre' => 'Engomado', 'imagen' => 'engomado.jpg', 'ruta' => '#', 'permiso' => 'engomado'],
            ['nombre' => 'Tejido', 'imagen' => 'tejido.jpg', 'ruta' => '/modulo-tejido', 'permiso' => 'tejido'],
            ['nombre' => 'Atadores', 'imagen' => 'Atadores.jpg', 'ruta' => '#', 'permiso' => 'atadores'],
            ['nombre' => 'Tejedores', 'imagen' => 'tejedores.jpg', 'ruta' => '#', 'permiso' => 'tejedores'],
            ['nombre' => 'Mantenimiento', 'imagen' => 'mantenimiento.png', 'ruta' => '#', 'permiso' => 'mantenimiento'],
            ['nombre' => 'Configuración', 'imagen' => 'configuracion.png', 'ruta' => '#', 'permiso' => 'configuracion'],
        ];
    
        // Filtrar los módulos según los permisos del usuario
        $modulosPermitidos = array_filter($modulos, function ($modulo) use ($usuario) {
            return $usuario->{$modulo['permiso']} == 1;
        });
    
        // Pasar los módulos permitidos a la vista
        return view('/produccionProceso', ['modulos' => $modulosPermitidos]);
    }    
}
