<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalagoEficienciaController;
use App\Http\Controllers\CatalagoTelarController;
use App\Http\Controllers\CatalagoVelocidadController;
use App\Http\Controllers\PlaneacionController;
use App\Http\Controllers\RequerimientoController;
use App\Http\Controllers\UsuarioController;
use App\Models\Usuario;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReporteFallaController;
use App\Http\Controllers\WhatsAppController;

//Rutas de login
Route::get('/', function () { return view('login'); });
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
// Ruta para obtener los empleados de un área específica
Route::get('/obtener-empleados/{area}', function ($area) { return App\Models\Usuario::where('area', $area)->get();});

Route::get('/produccionProceso', function () {return view('produccionProceso');})->name('produccionProceso');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/login-qr', [AuthController::class, 'loginQR']);
Route::get('/produccionProceso', [UsuarioController::class, 'index'])->name('produccion.index')->middleware('auth');

//RUTAS DEL MODULO **tejido************************************************************************************************************
Route::get('/modulo-tejido', function () { return view('modulos/tejido');});
Route::get('/tejido/jacquard-sulzer', function () { return view('modulos/tejido/jacquard-sulzer');});
Route::get('/tejido/jacquard-smith', function () { return view('modulos/tejido/jacquard-smith');});
Route::get('/tejido/smith', function () { return view('modulos/tejido/smith');});
Route::get('/tejido/itema-viejo', function () { return view('modulos/tejido/itema-viejo');});
Route::get('/tejido/itema-nuevo', function () { return view('modulos/tejido/itema-nuevo');});
Route::get('/tejido/programar-requerimientos', function () { return view('modulos/tejido/programar-requerimientos');});

//RUTAS DEL MODULO **urdido**
Route::get('/modulo-urdido', function () { return view('modulos/urdido');});
Route::get('/urdido/programar-requerimientos', function () { return view('modulos/urdido/programar-requerimientos');});

//RUTAS DEL MODULO **engomado**
Route::get('/modulo-engomado', function () { return view('modulos/engomado');});
Route::get('/engomado/programar-requerimientos', function () { return view('modulos/engomado/programar-requerimientos');});

//RUTAS DEL MODULO **atadores**
Route::get('/modulo-atadores', function () { return view('modulos/atadores');});
Route::get('/atadores/programar-requerimientos', function () { return view('modulos/atadores/programar-requerimientos');});

//RUTAS DEL MODULO **tejedores**
Route::get('/modulo-tejedores', function () { return view('modulos/tejedores');});
Route::get('/tejedores/programar-requerimientos', function () { return view('modulos/tejedores/programar-requerimientos');});

//RUTAS DEL MODULO **mantenimiento**
Route::get('/modulo-mantenimiento', function () { return view('modulos/mantenimiento');});

//RUTAS DEL MODULO **configuracion**
Route::get('/modulo-configuracion', function () { return view('modulos/configuracion');});

//ruta temporal para vista de circulo - borrar despues
Route::get('/urdido/urdidoTemporal', function () { return view('modulos/urdido/urdidoTemporal');});

//ruta para llegar a la vista dinamica de los telares de jacquard-sulzer*************************************************************
//***********************************************************************************************************************************
Route::get('/tejido/jacquard-sulzer/{telar}', [PlaneacionController::class, 'mostrarTelarSulzer'])->name('tejido.mostrarTelarSulzer');
Route::get('/modulos/tejido/telares/ordenes-programadas/{telar}', [PlaneacionController::class, 'mostrarOrdenesProgramadas'])->name('tejido.mostrarOrdenesProgramadas');
Route::post('/guardar-requerimiento', [RequerimientoController::class, 'store']);

Route::get('/ultimos-requerimientos', [RequerimientoController::class, 'obtenerRequerimientosActivos']);
Route::get('/ordenes-programadas/{telar}', [PlaneacionController::class, 'obtenerOrdenesProgramadas'])->name('ordenes.programadas');

//Route::get('/alta-usuarios', function () { return view('alta_usuarios');});//BORRAR UNA VEZ CREADO EL CONTROLLER
Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');

//RUTAS DEL MODULO planeacion
// Ruta de recursos para Planeacion
Route::resource('planeacion', PlaneacionController::class);
//RUTAS de CATALAGOS (3 catalagos), se usaron rutas de recursos para manejar las operaciones CRUD
Route::resource('telares', CatalagoTelarController::class);
Route::resource('eficiencia', CatalagoEficienciaController::class);
Route::resource('velocidad', CatalagoVelocidadController::class);
// ✅ NUEVAS RUTAS de planeacion
Route::get('/calendarios', [PlaneacionController::class, 'calendarios'])->name('planeacion.calendarios');
Route::get('/aplicaciones', [PlaneacionController::class, 'aplicaciones'])->name('planeacion.aplicaciones');

Route::put('/tejido-en-proceso/{id}', [PlaneacionController::class, 'update'])->name('tejido_scheduling.update');

// Rutas de catálogos
Route::resource('telares', CatalagoTelarController::class);
Route::resource('eficiencia', CatalagoEficienciaController::class);
Route::resource('velocidad', CatalagoVelocidadController::class);

Route::get('/falla', function () { return view('falla');})->name('telares.falla');

//twilio
// Ruta para mostrar el formulario (GET)
Route::get('/reportar', function () {return view('reportar');})->name('reportar.falla.form');
Route::post('/reportar-falla', [ReporteFallaController::class, 'enviarReporte'])->name('reportar.falla');

//WhatsApp Business
Route::get('/whatsapp', function () {return view('whatsapp');});
Route::post('/send-whatsapp', [WhatsAppController::class, 'sendMessage']);

