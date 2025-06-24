<?php

use App\Http\Controllers\AtadorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\CatalagoEficienciaController;
use App\Http\Controllers\CatalagoTelarController;
use App\Http\Controllers\CatalagoVelocidadController;
use App\Http\Controllers\EngomadoController;
use App\Http\Controllers\ModelosController;
use App\Http\Controllers\PlaneacionController;
use App\Http\Controllers\RequerimientoController;
use App\Http\Controllers\UsuarioController;
use App\Models\Usuario;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReporteFallaController;
use App\Http\Controllers\TejedorController;
use App\Http\Controllers\TejidoSchedullingController;
use App\Http\Controllers\UrdidoController;
use App\Http\Controllers\WhatsAppController;
use App\Models\CalendarioT1;

//Rutas de login
Route::get('/', function () {
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
// Ruta para obtener los empleados de un área específica
Route::get('/obtener-empleados/{area}', function ($area) {
    return App\Models\Usuario::where('area', $area)->get();
});

Route::get('/produccionProceso', function () {
    return view('produccionProceso');
})->name('produccionProceso');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/login-qr', [AuthController::class, 'loginQR']);
Route::get('/produccionProceso', [UsuarioController::class, 'index'])->name('produccion.index')->middleware('auth');

//RUTAS DEL MODULO **tejido************************************************************************************************************
Route::get('/modulo-tejido', function () {
    return view('modulos/tejido');
});
Route::get('/tejido/jacquard-sulzer', function () {
    return view('modulos/tejido/jacquard-sulzer');
});
Route::get('/tejido/jacquard-smith', function () {
    return view('modulos/tejido/jacquard-smith');
});
Route::get('/tejido/smith', function () {
    return view('modulos/tejido/smith');
});
Route::get('/tejido/itema-viejo', function () {
    return view('modulos/tejido/itema-viejo');
});
Route::get('/tejido/itema-nuevo', function () {
    return view('modulos/tejido/itema-nuevo');
});
Route::get('/tejido/programarReq', [RequerimientoController::class, 'requerimientosAProgramar'])->name('formulario.programarRequerimientos');
Route::post('/tejido/guardarUrdidoEngomado', [RequerimientoController::class, 'requerimientosAGuardar'])->name('orden.produccion.store');
Route::get('/tejido/bomids', [App\Http\Controllers\Select2Controller::class, 'getBomIds'])->name('bomids.api'); //<- rutas para buscador select2 BOMIDs
Route::get('/tejido/bomids2', [App\Http\Controllers\Select2Controller::class, 'getBomIds2'])->name('bomids.api2'); //<- rutas para buscador select2 BOMIDs

//RUTAS DEL MODULO **urdido**
Route::get('/modulo-urdido', function () {
    return view('modulos/urdido');
});
Route::get('/urdido/programar-requerimientos', function () {
    return view('modulos/urdido/programar-requerimientos');
});
Route::get('ingresar-folio', function () {
    return view('modulos/urdido/ingresar_folio');
})->name('ingresarFolio');
Route::post('orden-trabajo', [UrdidoController::class, 'cargarDatosUrdido'])->name('produccion.ordenTrabajo');
Route::post('/urdido/guardar-finalizar', [UrdidoController::class, 'guardarYFinalizarUrdido'])->name('urdido.guardarFinalizar');
Route::get('/imprimir-orden-llena-urd/{folio}', [UrdidoController::class, 'imprimirOrdenUrdido'])->name('imprimir.orden.urdido');
Route::get('/imprimir-papeletas-pequenias/{folio}', [UrdidoController::class, 'imprimirPapeletas'])->name('imprimir.orden.papeletas');

//RUTAS DEL MODULO **engomado**
Route::get('/modulo-engomado', function () {
    return view('modulos/engomado');
});
Route::get('/engomado/programar-requerimientos', function () {
    return view('modulos/engomado/programar-requerimientos');
});
Route::get('/ingresar-folio-engomado', function () {
    return view('modulos/engomado/ingresar_folio');
})->name('ingresarFolioEngomado');
Route::post('/orden-trabajo-engomado', [EngomadoController::class, 'cargarDatosEngomado'])->name('produccion.ordenTrabajoEngomado');
Route::post('/guardar-y-finalizar-engomado', [EngomadoController::class, 'guardarYFinalizar'])->name('ordenEngomado.guardarYFinalizar'); //Ruta que sustituye a 2 amtiguas rutas de 2 botones que se unificaron
Route::get('/imprimir-orden/{folio}', [EngomadoController::class, 'imprimirOrdenUE'])->name('imprimir.orden');
Route::get('/folio-pantalla/{folio}', function ($folio) {
    return view('modulos.programar_requerimientos.FolioEnPantalla')->with('folio', $folio);
})->name('folio.pantalla');

//RUTAS DEL MODULO **atadores**
Route::get('/modulo-atadores', function () {
    return view('modulos/atadores');
});
Route::get('/atadores/programar-requerimientos', function () {
    return view('modulos/atadores/programar-requerimientos');
});
Route::get('/atadores-juliosAtados',  [AtadorController::class, 'cargarDatosUrdEngAtador'])->name('datosAtadores.Atador');

//RUTAS DEL MODULO **tejedores** TEJEDORES TEJEDORES
Route::get('/modulo-tejedores', function () {
    return view('modulos/tejedores');
});
Route::get('/tejedores/programar-requerimientos', function () {
    return view('modulos/tejedores/programar-requerimientos');
});
Route::get('/tejedores/formato', [TejedorController::class, 'index'])->name('tejedores.index');
Route::post('/manufactura/guardar', [TejedorController::class, 'store'])->name('manufactura.guardar');

//RUTAS DEL MODULO **mantenimiento**
Route::get('/modulo-mantenimiento', function () {
    return view('modulos/mantenimiento');
});

//RUTAS DEL MODULO **Programacion-Urdido-Engomado**
Route::get('/modulo-UrdidoEngomado', [RequerimientoController::class, 'requerimientosActivos'])->name('index.requerimientosActivos');

//RUTAS DEL MODULO **EDICION-Urdido-Engomado** 22-05-2025
Route::get('/modulo-edicion-urdido-engomado', function () {
    return view('/modulos/edicion_urdido_engomado/edicion-urdido-engomado-folio');
})->name('ingresarFolioEdicion');
Route::get('/orden-trabajo-editar', [UrdidoController::class, 'cargarDatosOrdenUrdEng'])->name('update.ordenTrabajo');
Route::post('/tejido/actualizarUrdidoEngomado', [UrdidoController::class, 'ordenToActualizar'])->name('orden.produccion.update');
Route::post('/reservar-inventario', [RequerimientoController::class, 'BTNreservar'])->name('reservar.inventario');



//RUTAS DEL MODULO **configuracion**
Route::get('/modulo-configuracion', function () {
    return view('modulos/configuracion');
});

//ruta temporal para vista de circulo - borrar despues
Route::get('/urdido/urdidoTemporal', function () {
    return view('modulos/urdido/urdidoTemporal');
});

//ruta para llegar a la vista dinámica de los telares de jacquard-sulzer*************************************************************
//***********************************************************************************************************************************
Route::get('/tejido/jacquard-sulzer/{telar}', [PlaneacionController::class, 'mostrarTelarSulzer'])->name('tejido.mostrarTelarSulzer');
//el método de arriba sirve para mstrar la informacion de un telar individualmente (telar-informacion-individual)
Route::get('/modulos/tejido/telares/ordenes-programadas/{telar}', [PlaneacionController::class, 'mostrarOrdenesProgramadas'])->name('tejido.mostrarOrdenesProgramadas');
Route::post('/guardar-requerimiento', [RequerimientoController::class, 'store']);
Route::get('/ultimos-requerimientos', [RequerimientoController::class, 'obtenerRequerimientosActivos']);
Route::get('/ordenes-programadas-dinamica/{telar}', [PlaneacionController::class, 'obtenerOrdenesProgramadas'])->name('ordenes.programadas');


//Route::get('/alta-usuarios', function () { return view('alta_usuarios');});//BORRAR UNA VEZ CREADO EL CONTROLLER
Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');

//RUTAS DEL MODULO planeacion
// Ruta de RECURSOS para Planeacion
Route::resource('planeacion', PlaneacionController::class);
//RUTAS de CATALAGOS (3 catalagos), se usaron rutas de recursos para manejar las operaciones CRUD ¡IMPORTANTE!
Route::resource('telares', CatalagoTelarController::class);
Route::resource('eficiencia', CatalagoEficienciaController::class);
Route::resource('velocidad', CatalagoVelocidadController::class);

Route::get('/traspasoDataRedireccion', [TejidoSchedullingController::class, 'envioDeDataPlaneacion']);
Route::get('/Tejido-Scheduling/ultimo-por-telar', [TejidoSchedullingController::class, 'buscarUltimoPorTelar']);
Route::get('/Tejido-Scheduling/fechaFin', [TejidoSchedullingController::class, 'calcularFechaFin']);


// ✅ NUEVAS RUTAS de PLANEACION  PLANEACION  PLANEACION  PLANEACION  PLANEACION  PLANEACION  PLANEACION  PLANEACION  PLANEACION  PLANEACION  PLANEACION  PLANEACION
Route::get('/catalagos/calendarios', [CalendarioController::class, 'CalendarioT1'])->name('calendariot1.index');
Route::get('/aplicaciones', [PlaneacionController::class, 'aplicaciones'])->name('planeacion.aplicaciones');
Route::post('/calendarios/update-inline', [CalendarioController::class, 'updateInline'])->name('calendarios.update.inline');
Route::get('/planeacion/tipo-movimientos/{id}', [PlaneacionController::class, 'obtenerPorTejNum']);
Route::put('/tejido-en-proceso/{num_registro}', [PlaneacionController::class, 'update'])->name('tejido_scheduling.update');
Route::get('/buscar-modelos', [PlaneacionController::class, 'buscarModelos'])->name('modelos.buscar'); //<- Rutas para SELECTS en Planeacion 
Route::get('/modelos-por-clave', [PlaneacionController::class, 'obtenerModelosPorClave'])->name('modelos.porClave');
Route::get('/modelo/detalle', [PlaneacionController::class, 'buscarDetalleModelo'])->name('modelos.detalle'); // ruta pra obtener DETALLES del registro del modelo, de acuerdo con la CLAVE_AX y el NOMBRE_MODELO
Route::get('/telares/datos', [PlaneacionController::class, 'obtenerDatosTelar'])->name('telares.datos');

// Rutas de catálogos
Route::resource('telares', CatalagoTelarController::class);
Route::resource('eficiencia', CatalagoEficienciaController::class);
Route::resource('velocidad', CatalagoVelocidadController::class);

//twilio
// Ruta para mostrar el formulario (GET)
Route::get('/reportar', function () {
    return view('reportar');
})->name('reportar.falla.form');
Route::post('/reportar-falla', [ReporteFallaController::class, 'enviarReporte'])->name('reportar.falla');

//WhatsApp Business
Route::get('/whatsapp', function () {
    return view('whatsapp');
});
Route::post('/send-whatsapp', [WhatsAppController::class, 'sendMessage']);
//Route::get('/whatsapp2', function () {return view('whatsapp2');});
Route::get('/whatsapp2', [WhatsAppController::class, 'mensajeFallas'])->name('telares.falla');
Route::post('/send-whatsapp2', [WhatsAppController::class, 'enviarMensaje']);
Route::post('/send-failSMS', [ReporteFallaController::class, 'enviarSMS']);

// MODELOS ***************************************************************************************************************************
Route::resource('modelos', ModelosController::class);
/* 
Verbo HTTP | URI | Acción del Controller | Nombre de ruta
GET | /modelos | index() | modelos.index
GET | /modelos/create | create() | modelos.create
POST | /modelos | store() | modelos.store
GET | /modelos/{id} | show() | modelos.show
GET | /modelos/{id}/edit | edit() | modelos.edit
PUT/PATCH | /modelos/{id} | update() | modelos.update
DELETE | /modelos/{id} | destroy() | modelos.destroy
*/
Route::get('/flogs/buscar', [App\Http\Controllers\TejidoSchedullingController::class, 'buscarFlogso'])->name('flog.buscar');
