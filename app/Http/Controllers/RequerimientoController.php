<?php

namespace App\Http\Controllers;

use App\Models\InventDim;
use App\Models\InventSum;
use Illuminate\Http\Request;
use App\Models\Requerimiento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RequerimientoController extends Controller
{
    public function index()
    {
        $requerimientos = Requerimiento::all();
        return view('requerimiento.index', compact('requerimientos'));
    }

    public function store(Request $request)
    {
        $fechaHoy = now()->toDateString(); // Fecha actual

        // Si el registro es de tipo 'rizo'
        if ($request->rizo == 1) {
            // Verificar si ya existe un registro activo de tipo 'rizo' para este telar
            $ultimoRequerimientoRizo = Requerimiento::where('rizo', 1)
                ->where('status', 'activo')
                ->where('telar', $request->telar)  // Verificar por telar
                ->orderBy('fecha_hora_creacion', 'desc')
                ->first();

            if ($ultimoRequerimientoRizo) {
                // Si ya existe un activo, lo marcamos como 'cancelado'
                Requerimiento::where('id', $ultimoRequerimientoRizo->id)
                    ->update(['status' => 'cancelado']);
            }
        }

        // Si el registro es de tipo 'pie'
        if ($request->pie == 1) {
            // Verificar si ya existe un registro activo de tipo 'pie' para este telar
            $ultimoRequerimientoPie = Requerimiento::where('pie', 1)
                ->where('status', 'activo')
                ->where('telar', $request->telar)  // Verificar por telar
                ->orderBy('fecha_hora_creacion', 'desc')
                ->first();

            if ($ultimoRequerimientoPie) {
                // Si ya existe un activo, lo marcamos como 'cancelado'
                Requerimiento::where('id', $ultimoRequerimientoPie->id)
                    ->update(['status' => 'cancelado']);
            }
        }

        // Insertar el nuevo registro
        $nuevoRequerimiento = Requerimiento::create([
            'telar' => $request->telar,
            'cuenta_rizo' => $request->cuenta_rizo,
            'cuenta_pie' => $request->cuenta_pie,
            'fecha' => $request->fecha,
            //'metros' => $request->metros,
            //'julio_reserv' => $request->julio_reserv,
            'status' => 'activo', // El nuevo registro será activo
            'orden_prod' => '',
            'valor' => $request->valor,
            //'metros_pie'=>$request->metros_pie,
            //'julio_reserv_pie'=>$request->julio_reserv_pie,
            'fecha_hora_creacion' => now(), // Fecha actual
            'rizo' => $request->rizo,
            'pie' => $request->pie,
        ]);

        return response()->json(['message' => 'Requerimiento guardado exitosamente', 'data' => $nuevoRequerimiento]);
    }



    public function obtenerRequerimientosActivos()
    {
        $fechaHoy = now()->toDateString(); // Fecha actual

        // Filtrar por el valor de 'rizo' o 'pie'
        $requerimientos = Requerimiento::where('status', 'activo')
            //->whereDate('fecha_hora_creacion', $fechaHoy) // Filtrar por la fecha actual
            ->where(function ($query) {
                $query->where('rizo', 1) // Si 'rizo' es 1
                    ->orWhere('pie', 1); // O si 'pie' es 1
            })
            ->get();

        return response()->json($requerimientos);
    }

    // metodo del modulo de TEJIDO - TEJIDO - TEJIDO - TEJIDO - TEJIDO - TEJIDO
    public function requerimientosActivos()
    {
        // Obtener los IDs de requerimientos ya seleccionados
        $requerimientosSeleccionados = DB::table('Produccion.dbo.TWDISPONIBLEURDENG2')
            ->pluck('reqid')
            ->toArray();

        $InventariosSeleccionados = DB::table('Produccion.dbo.TWDISPONIBLEURDENG2')
            ->pluck('dis_id')
            ->toArray();

        // Consultar solo los requerimientos activos que NO están en TWDISPONIBLEURDENG2
        $requerimientos = DB::table('requerimiento')
            ->where('status', 'activo')
            ->where('orden_prod', '')
            ->whereNotIn('id', $requerimientosSeleccionados)
            ->orderByRaw("CONVERT(DATETIME, fecha, 103) ASC")
            ->get();

        // Obtener inventarios desde la conexión SQL Server secundaria
        $inventarios = DB::connection('sqlsrv_ti')
            ->table('TI_PRO.dbo.TWDISPONIBLEURDENGO')
            ->where('INVENTLOCATIONID', 'A-JUL/TELA')
            ->get();

        //Convierte $vinculados en un array asociativo en el backend para facilitar el acceso por dis_id
        $vinculados = DB::table('Produccion.dbo.TWDISPONIBLEURDENG2 as d')
            ->join('Produccion.dbo.requerimiento as r', 'd.reqid', '=', 'r.id')
            ->select('d.dis_id', 'r.telar')
            ->get()
            ->keyBy('dis_id'); // Agrupa por dis_id como índice


        //Log::info((array) $InventariosSeleccionados);

        return view('modulos.programar_requerimientos.programar-requerimientos', compact('requerimientos', 'inventarios', 'InventariosSeleccionados', 'vinculados'));
    }

    //metodo que implementa el guardado de Inventario Disponible en Programacion-Requerimientos PROGRAMACION-REQUERIMIENTOS-INVENTARIOS PROGRAMACION-REQUERIMIENTOS-INVENTARIOS PROGRAMACION-REQUERIMIENTOS-INVENTARIOS
    public function BTNreservar(Request $request)
    {
        //Si el string puede traer puntos o comas como separadores de miles o decimales, primero hay que normalizarlo:
        function parse_metros($str)
        {
            // Elimina comas (,) que se usan como separador de miles
            $str = str_replace(',', '', $str);

            // Ahora convertir a float
            return is_numeric($str) ? floatval($str) : 0;
        }
        $inventario = $request->input('inventario');
        $requerimiento = $request->input('requerimiento');

        // VERIFICACION, si ya existe esa combinación
        $existe = DB::table('TWDISPONIBLEURDENG2')
            ->where('reqid', $requerimiento['id'])
            ->where('dis_id', $inventario['recid'])
            ->exists();

        if ($existe) {
            return response()->json([
                'success' => false,
                'message' => 'YA SE HA RESERVADO PREVIAMENTE, INTENTE CON OTRAS FILAS POR FAVOR.',
            ]);
        }

        DB::connection('sqlsrv')->table('TWDISPONIBLEURDENG2')->insert([
            'articulo' => $inventario['articulo'],
            'tipo' => $inventario['tipo'],
            'cantidad' => $inventario['cantidad'],
            'hilo' => $inventario['hilo'],
            'cuenta' => $inventario['cuenta'],
            'color' => $inventario['color'],
            'almacen' => $inventario['almacen'],
            'orden' => $inventario['orden'],
            'localidad' => $inventario['localidad'],
            'no_julio' => $inventario['no_julio'],
            'metros' => parse_metros($inventario['metros']),
            'fecha' => Carbon::createFromFormat('d-m-y', $inventario['fecha'])->format('Y-m-d'),
            'reqid' => $requerimiento['id'],
            'dis_id' => ($inventario['recid']),

        ]);

        $nuevoValorMetros = parse_metros($inventario['metros']);
        $nuevoValorMccoy = 3; //PENDIENTE, aún necesitamos saber qué datos irán aquí 
        $nuevoTelar = DB::table('Produccion.dbo.requerimiento')->where('id', $requerimiento['id'])->first();
        $orden = $inventario['orden'];

        //Log::info((array) $nuevoTelar);

        return response()->json([
            'success' => true,
            'message' => 'RESERVADO CORRECTAMENTE',
            'nuevos_valores' => [
                'metros' => $nuevoValorMetros,
                'mccoy' => $nuevoValorMccoy,
                'telar' => $nuevoTelar->telar,
                'orden' => $orden,
            ]
        ]);
    }

    //metodo que regresa 2 objetos a la vista para llenar 2 tablas (amarillas)
    //PROGRAMAR-REQUERIMIENTO en programar_requerimiento //PROGRAMAR-REQUERIMIENTO en programar_requerimiento //PROGRAMAR-REQUERIMIENTO en programar_requerimiento
    public function requerimientosAProgramar(Request $request)
    {
        //dd($request);
        // Recuperar los valores enviados desde la vista
        $telar = $request->input('telar');
        $tipo = $request->input('tipo');
        $idsSeleccionados = json_decode($request->input('idsSeleccionados'), true);
        if (!is_array($idsSeleccionados)) {
            return back()->withErrors(['idsSeleccionados' => 'Error al procesar la selección.']);
        }

        // Buscar los registros en Produccion.dbo.requerimiento SQLSERVER
        $requerimientos = DB::connection('sqlsrv') // si estás usando SQL Server
            ->table('Produccion.dbo.requerimiento')
            ->whereIn('id', $idsSeleccionados)
            ->get();


        //    dd($requerimientos);



        // Buscar el requerimiento activo con coincidencia de telar y tipo (rizo o pie)
        $requerimiento = DB::table('requerimiento')
            ->where('telar', $telar)
            ->where('status', 'activo')
            ->where(function ($query) use ($tipo) {
                if ($tipo === 'Rizo') {
                    $query->where('rizo', 1);
                } elseif ($tipo === 'Pie') {
                    $query->where('pie', 1);
                }
            })
            ->first();

        // Si no hay requerimiento, mandar mensaje de error
        if (!$requerimiento) {
            return redirect()->back()->with('error', 'No se encontró un requerimiento activo con los criterios indicados.');
        }

        // 👉 Buscar el valor del salón desde la tabla TEJIDO_SCHEDULING según el telar
        $datos = DB::table('TEJIDO_SCHEDULING')
            ->where('telar', $telar)
            ->select('salon', 'telar')
            ->first();

        //MANDAMOS los datos provenientes de TI_PRO para LMAT de URDIDO y ENGOMADO


        // Retornar vista con requerimiento y salón
        return view('modulos.programar_requerimientos.programarUrdidoEngomado', compact('requerimiento', 'datos', 'requerimientos'));
    }

    /* metodo que realiza funciones de vista PROGRAMARURDIDOENGOMADO**********************************************************************************
    ***********************************************************************************************************************************************
     */
    public function requerimientosAGuardar(Request $request)
    {
        $folioBase = $this->generarFolioUnico(); // base para distinguirlos si lo deseas
        //dd($request);
        try {
            // Validación básica: puedes hacerlo con reglas o de forma manual
            $request->validate([
                'urdido' => 'required',
                'proveedor' => 'required',
                'destino' => 'required',
                'metros' => 'required|numeric',
                'nucleo' => 'required',
                'no_telas' => 'required|integer',
                'lmaturdido' => 'required',
                'maquinaEngomado' => 'required',
                'lmatengomado' => 'required',
                // puedes agregar más campos si necesitas
            ], [
                'urdido.required' => 'El campo urdido es obligatorio.',
                'proveedor.required' => 'El campo proveedor es obligatorio.',
                'destino.required' => 'El campo destino es obligatorio.',
                'metros.required' => 'El campo metros es obligatorio.',
                'metros.numeric' => 'El campo metros debe ser un número.',
                'nucleo.required' => 'El campo núcleo es obligatorio.',
                'no_telas.required' => 'El campo número de telas es obligatorio.',
                'no_telas.integer' => 'El campo número de telas debe ser un número entero.',
                'lmaturdido.required' => 'El campo L. Mat. Urdido es obligatorio.',
                'maquinaEngomado.required' => 'El campo maquinaEngomado es obligatorio.',
                'lmatengomado.required' => 'El campo L. Mat. Engomado es obligatorio.',
            ]);


            // Validar que los arrays existan y tengan la misma longitud
            if (!is_array($request->no_julios) || !is_array($request->hilos)) {
                return redirect()->back()->withInput()->with('error', 'Datos de construcción inválidos.');
            }


            $registros = $request->input('registros');
            $telares = array_column($registros, 'telar');
            //dd($telares);

            foreach ($telares as $i => $telar) {
                $folio = $folioBase . '-' . ($i + 1); // Ejemplo: FOLIO-1, FOLIO-2...

                // Actualizar requerimiento por telar específico
                DB::table('requerimiento')
                    ->where('status', 'activo')
                    ->where('telar', $telar)
                    ->where(function ($query) use ($request) {
                        if ($request->input('tipo') === 'Rizo') {
                            $query->where('rizo', 1);
                        } elseif ($request->input('tipo') === 'Pie') {
                            $query->where('pie', 1);
                        }
                    })
                    ->update(['orden_prod' => $folio]);
            }
            // Insertar en urdido_engomado
            DB::table('urdido_engomado')->insert([
                'folio' => $folioBase,
                'cuenta' => $request->input('cuenta'),
                'urdido' => $request->input('urdido'),
                'proveedor' => $request->input('proveedor'),
                'tipo' => $request->input('tipo'),
                'destino' => $request->input('destino'),
                'metros' => $request->input('metros'),
                'nucleo' => $request->input('nucleo'),
                'no_telas' => $request->input('no_telas'),
                'balonas' => $request->input('balonas'),
                'metros_tela' => $request->input('metros_tela'),
                'cuendados_mini' => $request->input('cuendados_mini'),
                'observaciones' => $request->input('observaciones'),
                'created_at' => now(),
                'updated_at' => now(),
                'estatus_urdido' => 'en_proceso',
                'estatus_engomado' => 'en_proceso',
                'engomado' => '',
                'color' => '',
                'solidos' => '',
                'lmaturdido' => $request->input('lmaturdido'),
                'maquinaEngomado' => $request->input('maquinaEngomado'),
                'lmatengomado' => $request->input('lmatengomado'),
            ]);

            // Insertar detalles de construcción
            $no_julios = $request->input('no_julios');
            $hilos = $request->input('hilos');

            for ($j = 0; $j < count($no_julios); $j++) {
                if (!empty($no_julios[$j]) && !empty($hilos[$j])) {
                    DB::table('construccion_urdido')->insert([
                        'folio' => $folioBase,
                        'no_julios' => $no_julios[$j],
                        'hilos' => $hilos[$j],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            return view('modulos.programar_requerimientos.lanzador')->with('folio', $folioBase);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validación fallida
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            // Otro tipo de error: DB, lógica, etc.
            Log::error('Error al guardar requerimientos: ' . $e->getMessage()); // opcional: log para debug
            return redirect()->back()->with('error', 'Ocurrió un error inesperado al guardar los datos. Intenta nuevamente.');
        }
    }


    private function generarFolioUnico()
    {
        // Obtener el último folio base (A001, A002, ..., B001, etc.), ignorando el sufijo -N
        $ultimoFolioBase = DB::table('requerimiento')
            ->selectRaw("LEFT(orden_prod, CHARINDEX('-', orden_prod + '-') - 1) as folio_base")
            ->whereRaw("orden_prod LIKE '[A-Z][0-9][0-9][0-9]-%'")
            ->orderByDesc('folio_base')
            ->value('folio_base');

        if ($ultimoFolioBase) {
            $letra = substr($ultimoFolioBase, 0, 1);           // "A"
            $numero = (int) substr($ultimoFolioBase, 1);       // 1, 2, ..., 999

            if ($numero >= 999) {
                $letra = chr(ord($letra) + 1); // Avanza a la siguiente letra
                $numero = 1;
            } else {
                $numero += 1;
            }
        } else {
            $letra = 'A';
            $numero = 1;
        }

        return $letra . str_pad($numero, 3, '0', STR_PAD_LEFT); // Devuelve "A001", "A002", etc.
    }


    /*

    Nueva consulta:
    // Intentar actualizar directamente
    $updatedRows = DB::table('requerimiento')
        ->where('status', 'activo')
        ->where('telar', $request->input('telar'))
        ->where(function ($query) use ($request) {
            if ($request->input('tipo') === 'Rizo') {
                $query->where('cuenta_rizo', $request->input('cuenta'));
            } elseif ($request->input('tipo') === 'Pie') {
                $query->where('cuenta_pie', $request->input('cuenta'));
            }
        })
        ->update(['orden_prod' => $folio]);

    if ($updatedRows === 0) {
        return redirect()->back()->with('error', 'No se encontró un registro válido en requerimiento para actualizar.');
    }

************************************************************************************************************************
    REVISAR EL FUNCIONAMIENTO

        public function requerimientosAGuardar(Request $request)
    {
        // Validación de los datos recibidos
        $validator = Validator::make($request->all(), [
            'cuenta' => 'required|string|max:255',
            'urdido' => 'required|string|max:255',
            'proveedor' => 'required|string|max:255',
            'tipo' => 'required|string|in:rizo,pie', // Asegurarse de que el tipo sea válido
            'destino' => 'required|string|max:255',
            'metros' => 'required|numeric',
            'nucleo' => 'required|string|max:255',
            'no_telas' => 'required|integer',
            'balonas' => 'required|integer',
            'metros_tela' => 'required|numeric',
            'cuendados_mini' => 'required|numeric',
            'observaciones' => 'nullable|string',
            'no_julios' => 'required|array', // Debe ser un array de valores
            'hilos' => 'required|array', // Debe ser un array de valores
            'telar' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Generar un folio único
        $folio = Str::uuid()->toString();
    
        // Iniciar transacción para asegurar que todas las operaciones se realicen correctamente
        DB::beginTransaction();
    
        try {
            // Guardar los datos en la tabla urdido_engomado
            DB::table('urdido_engomado')->insert([
                'folio' => $folio,
                'cuenta' => $request->input('cuenta'),
                'urdido' => $request->input('urdido'),
                'proveedor' => $request->input('proveedor'),
                'tipo' => $request->input('tipo'),
                'destino' => $request->input('destino'),
                'metros' => $request->input('metros'),
                'nucleo' => $request->input('nucleo'),
                'no_telas' => $request->input('no_telas'),
                'balonas' => $request->input('balonas'),
                'metros_tela' => $request->input('metros_tela'),
                'cuendados_mini' => $request->input('cuendados_mini'),
                'observaciones' => $request->input('observaciones'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            // Guardar los datos de Construcción Urdido
            $no_julios = $request->input('no_julios');
            $hilos = $request->input('hilos');
    
            for ($i = 0; $i < count($no_julios); $i++) {
                DB::table('construccion_urdido')->insert([
                    'folio' => $folio,
                    'no_julios' => $no_julios[$i],
                    'hilos' => $hilos[$i],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
    
            // Buscar el registro en la tabla requerimiento
            $registro = DB::table('requerimiento')
                ->where('status', 'activo')
                ->where(function ($query) use ($request) {
                    // Condición para el tipo 'rizo' o 'pie'
                    if ($request->input('tipo') === 'rizo') {
                        $query->where('cuenta_rizo', $request->input('cuenta'));
                    } elseif ($request->input('tipo') === 'pie') {
                        $query->where('cuenta_pie', $request->input('cuenta'));
                    }
                })
                ->where('telar', $request->input('telar')) // Asegurarse que coincida el telar
                ->first();
    
            // Si se encuentra el registro, se actualiza el campo orden_prod
            if ($registro) {
                DB::table('requerimiento')
                    ->where('telar', $request->input('telar'))
                    ->where(function ($query) use ($request) {
                        if ($request->input('tipo') === 'rizo') {
                            $query->where('cuenta_rizo', $request->input('cuenta'));
                        } elseif ($request->input('tipo') === 'pie') {
                            $query->where('cuenta_pie', $request->input('cuenta'));
                        }
                    })
                    ->where('status', 'activo')
                    ->update(['orden_prod' => $folio]);
            } else {
                return redirect()->back()->with('error', 'No se encontró un registro válido en requerimiento.');
            }
    
            // Confirmar la transacción
            DB::commit();
    
            // Retornar a la vista con un mensaje de éxito
            return view('modulos/tejido/programarUrdidoEngomado')->with('success', 'Orden de producción creada con éxito.');
    
        } catch (\Exception $e) {
            // Si ocurre un error, revertir la transacción
            DB::rollBack();
    
            // Puedes agregar un mensaje de error o simplemente devolver un error genérico
            return redirect()->back()->with('error', 'Hubo un error al guardar la orden de producción: ' . $e->getMessage());
        }
    }
    */
}
