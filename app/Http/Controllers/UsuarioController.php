<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // Muestra el formulario de creación de usuario
    public function create()
    {
        return view('alta_usuarios');
    }

    // Almacena un nuevo usuario en la base de datos
    public function store(Request $request)
    {
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
            ['nombre' => 'PLANEACIÓN', 'imagen' => 'planeacion.png', 'ruta' => route('planeacion.index'), 'permiso' => 'planeacion'],
            ['nombre' => 'TEJIDO', 'imagen' => 'tejido.jpg', 'ruta' => '/modulo-tejido', 'permiso' => 'tejido'],
            ['nombre' => 'URDIDO', 'imagen' => 'UrdEngo.png', 'ruta' => route('ingresarFolio'), 'permiso' => 'urdido'],
            ['nombre' => 'ENGOMADO', 'imagen' => 'engomado.jpg', 'ruta' => route('ingresarFolioEngomado'), 'permiso' => 'engomado'],
            ['nombre' => 'ATADORES', 'imagen' => 'Atadores.jpg', 'ruta' => '/atadores-juliosAtados', 'permiso' => 'atadores'],
            ['nombre' => 'TEJEDORES', 'imagen' => 'tejedores.jpg', 'ruta' => '/tejedores/formato', 'permiso' => 'tejedores'],
            ['nombre' => 'MANTENIMIENTO', 'imagen' => 'mantenimiento.png', 'ruta' => '/modulo-mantenimiento', 'permiso' => 'mantenimiento'],
            ['nombre' => 'PROGRAMACIÓN URDIDO ENGOMADO', 'imagen' => 'proUE.png', 'ruta' => '/modulo-UrdidoEngomado', 'permiso' => 'UrdidoEngomado'],
            ['nombre' => 'EDICIÓN ORDEN URDIDO ENGOMADO', 'imagen' => 'edit.png', 'ruta' => '/modulo-edicion-urdido-engomado', 'permiso' => 'UrdidoEngomado'],
            ['nombre' => 'CONFIGURACIÓN', 'imagen' => 'configuracion.png', 'ruta' => '/modulo-configuracion', 'permiso' => 'configuracion'],
        ];

        // Filtrar los módulos según los permisos del usuario
        $modulosPermitidos = array_filter($modulos, function ($modulo) use ($usuario) {
            return $usuario->{$modulo['permiso']} == 1;
        });

        // Pasar los módulos permitidos a la vista
        return view('/produccionProceso', ['modulos' => $modulosPermitidos]);
    }
}
