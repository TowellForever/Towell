<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalagoEficienciaController;
use App\Http\Controllers\CatalagoTelarController;
use App\Http\Controllers\CatalagoVelocidadController;
use App\Http\Controllers\UsuarioController;
use App\Models\Usuario;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('bienvenida');
});

//Rutas de login
Route::get('/login', function () {
    return view('login');
});
Route::post('/login', [AuthController::class, 'login']);
// Ruta para obtener el nombre y la foto del empleado
Route::get('/obtener-nombre/{noEmpleado}', function ($noEmpleado) {
    $empleado = App\Models\Usuario::where('numero_empleado', $noEmpleado)->first();
    
    if ($empleado) {
        return response()->json([
            'nombre' => $empleado->nombre,
            'foto' => $empleado->foto // Asumiendo que 'foto' es el campo en la base de datos
        ]);
    }
    return response()->json([], 404);
});

Route::get('/produccionProceso', function () { return view('produccionProceso');});

//RUTAS DEL MODULO planeacion
Route::get('/modulo-planeacion', function () { return view('modulos/planeacion');});

//RUTAS DEL MODULO tejido
Route::get('/modulo-tejido', function () { return view('modulos/tejido');});
Route::get('/tejido/jacquard-sulzer', function () { return view('modulos/tejido/jacquard-sulzer');});
Route::get('/tejido/jacquard-smith', function () { return view('modulos/tejido/jacquard-smith');});
Route::get('/tejido/smith', function () { return view('modulos/tejido/smith');});
Route::get('/tejido/itema-viejo', function () { return view('modulos/tejido/itema-viejo');});
Route::get('/tejido/itema-nuevo', function () { return view('modulos/tejido/itema-nuevo');});
Route::get('/tejido/programar-requerimientos', function () { return view('modulos/tejido/programar-requerimientos');});

//Route::get('/alta-usuarios', function () { return view('alta_usuarios');});//BORRAR UNA VEZ CREADO EL CONTROLLER

Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');


// Ruta para obtener los empleados de un área específica
Route::get('/obtener-empleados/{area}', function ($area) {
    return App\Models\Usuario::where('area', $area)->get();
});

//RUTAS de CATALAGOS (3 catalagos)
Route::get('/telares', [CatalagoTelarController::class, 'index'])->name('telares');
Route::get('/eficiencia', [CatalagoEficienciaController::class, 'index'])->name('eficiencia');
Route::get('/velocidad', [CatalagoVelocidadController::class, 'index'])->name('velocidad');
