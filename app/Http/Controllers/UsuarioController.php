<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
        //dd($request->all());
        try {
            // 1) Validación (re-agregamos 'contrasenia')
            $data = $request->validate([
                'area'            => 'required|string|in:Almacen,Urdido,Engomado,Tejido,Atadores,Tejedores,Mantenimiento',
                'numero_empleado' => 'required|string|max:50',
                'nombre'          => 'required|string|max:255',
                'contrasenia'     => 'required|string',
                'turno'           => 'required|in:1,2,3',
                'telefono'        => 'nullable|string',
                'foto'            => 'nullable|image|max:2048',
            ]);

            // 3) Checkboxes -> 0/1
            $checkboxes = [
                'enviarMensaje',
                'almacen',
                'urdido',
                'engomado',
                'tejido',
                'atadores',
                'tejedores',
                'mantenimiento',
                'planeacion',
                'configuracion',
                'UrdidoEngomado'
            ];
            foreach ($checkboxes as $cb) {
                $data[$cb] = $request->boolean($cb) ? 1 : 0;
            }

            // 4) Foto (guardar ruta pública)
            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('usuarios', 'public');
            }

            // 5) Hashear contraseña
            $data['contrasenia'] = Hash::make($data['contrasenia']);

            // 6) remember_token
            $data['remember_token'] = Str::random(60);

            // 7) Crear
            Usuario::create($data);

            return redirect()
                ->route('usuarios.create')
                ->with('success', 'Usuario registrado correctamente');
        } catch (ValidationException $e) {
            // Validación: mostramos errores con SweetAlert (ya lo tienes en el Blade)
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $e) {
            Log::error('Error al crear usuario', ['msg' => $e->getMessage()]);
            return back()
                ->with('error', 'No se pudo registrar el usuario. Intenta de nuevo.')
                ->withInput();
        }
    }

    public function select(Request $request)
    {
        $usuarios = Usuario::query()
            ->select('numero_empleado', 'nombre', 'area', 'turno', 'telefono', 'foto', 'enviarMensaje')
            ->orderBy('nombre')
            ->get(); // sin paginar

        return view('modulos.usuarios.select', compact('usuarios'));
    }

    //CRUD REST, solo edit, update y destroy

    // EDITAR
    public function edit(Usuario $usuario)
    {
        return view('modulos.usuarios.edit', compact('usuario'));
    }

    // ACTUALIZAR
    public function update(Request $request, Usuario $usuario)
    {
        // Campos de texto/base (no validamos checkboxes como boolean por el "on")
        $data = $request->validate([
            'nombre'   => 'required|string|max:255',
            'area'     => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:30',
            'turno'    => 'nullable|string|max:50',
            'foto'     => 'nullable|url',
            // 'contrasenia' => 'nullable|string|max:255', // solo si la vas a usar (ojo hashing)
        ]);

        // Checkboxes -> boolean
        $checks = [
            'enviarMensaje',
            'almacen',
            'urdido',
            'engomado',
            'tejido',
            'atadores',
            'tejedores',
            'mantenimiento',
            'planeacion',
            'configuracion',
            'UrdidoEngomado'
        ];
        foreach ($checks as $f) {
            $data[$f] = $request->boolean($f);
        }

        // Si deseas permitir cambiar la contraseña (no se actualiza si viene vacía).
        if ($request->filled('contrasenia')) {
            // Si esta contraseña fuera de login, idealmente: $data['contrasenia'] = Hash::make($request->input('contrasenia'));
            $data['contrasenia'] = $request->input('contrasenia');
        }

        // numero_empleado lo dejamos como clave, no editable aquí
        $usuario->update($data);

        return redirect()
            ->route('usuarios.select')
            ->with('success', "Usuario #{$usuario->numero_empleado} actualizado correctamente.");
    }

    // ELIMINAR
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        return redirect()
            ->route('usuarios.select')
            ->with('success', "Usuario #{$usuario->numero_empleado} eliminado.");
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
            ['nombre' => 'MANTENIMIENTO', 'imagen' => 'mantenimiento.png', 'ruta' => '/reportes-temporales', 'permiso' => 'mantenimiento'],
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
