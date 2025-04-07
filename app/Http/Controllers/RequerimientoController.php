<?php

namespace App\Http\Controllers;

use App\Models\InventDim;
use App\Models\InventSum;
use Illuminate\Http\Request;
use App\Models\Requerimiento;
use Illuminate\Support\Facades\DB;
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
            'fecha'=>$request->fecha,
            //'metros' => $request->metros,
            //'julio_reserv' => $request->julio_reserv,
            'status' => 'activo', // El nuevo registro será activo
            'orden_prod' => '',
            'valor'=>$request->valor,
            //'metros_pie'=>$request->metros_pie,
            //'julio_reserv_pie'=>$request->julio_reserv_pie,
            'fecha_hora_creacion' => now(), // Fecha actual
            'rizo'=>$request->rizo,
            'pie'=>$request->pie,
        ]);
        
        return response()->json(['message' => 'Requerimiento guardado exitosamente', 'data' => $nuevoRequerimiento]);
    }
    


    public function obtenerRequerimientosActivos()
    {
        $fechaHoy = now()->toDateString() ; // Fecha actual
    
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

    public function requerimientosActivos()
    {
        // Consultar los requerimientos activos
        $requerimientos = DB::table('requerimiento')
            ->where('status', 'activo') // Filtrar solo los registros activos
            ->where('orden_prod','')
            ->orderBy('fecha', 'asc') // Ordena por fecha más cercana
            ->get();
    
        // Obtener los datos de la BD TI_PRO con los joins y filtros correspondientes
        $inventarios = DB::connection('sqlsrv_ti')
            ->table('TI_PRO.dbo.TWDISPONIBLEURDENG')
            ->where('INVENTLOCATIONID', 'A-JUL/TELA')
            ->get();
    
        return view('modulos/tejido/programar-requerimientos', compact('requerimientos', 'inventarios'));
    }
     
    //metodo que regresa 2 objetos a la vista para llenar 2 tablas (amarillas)
    public function requerimientosAProgramar(Request $request)
    {
        // Recuperar los valores enviados desde la vista
        $telar = $request->input('telar');
        $tipo = $request->input('tipo');
    
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
        // Retornar vista con requerimiento y salón
        return view('modulos.tejido.programarUrdidoEngomado', compact('requerimiento', 'datos'));
    }
    
    public function requerimientosAGuardar(Request $request)
    {
        //dd($request);
        // Generar un folio único
        $folio = Str::uuid()->toString();
    
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
    
        // Guardar los datos de Construcción Urdido (recibimos arrays de "no_julios" y "hilos")
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

            //actualizo el campo orden_prod en la tabla REQUERIMIENTO
            // Intentar actualizar directamente
            $updatedRows = DB::table('requerimiento')
                ->where('status', 'activo')
                ->where('telar', (string) $request->input('telar'))
                ->where(function ($query) use ($request) {
                    if ($request->input('tipo') === 'Rizo') {
                        $query->where('rizo', 1);
                    } elseif ($request->input('tipo') === 'Pie') {
                        $query->where('pie', 1);
                    }
                })
                ->update(['orden_prod' => $folio]);

            if ($updatedRows === 0) {
                return redirect()->back()->with('error', 'No se encontró un registro válido en requerimiento para actualizar.');
            }

            //regreso a la pagina de programar reqwuerimientos y tambien envio los 2 objetos para llenar ambas tablas
            // Consultar los requerimientos activos
            $requerimientos = DB::table('requerimiento')
            ->where('status', 'activo') // Filtrar solo los registros activos
            ->where('orden_prod','')
            ->orderBy('fecha', 'asc') // Ordena por fecha más cercana
            ->get();

            // Obtener los datos de la BD TI_PRO con los joins y filtros correspondientes
            $inventarios = DB::connection('sqlsrv_ti')
                ->table('TI_PRO.dbo.TWDISPONIBLEURDENG')
                ->where('INVENTLOCATIONID', 'A-JUL/TELA')
                ->get();
    
        return view('modulos/tejido/programar-requerimientos', compact('requerimientos', 'inventarios'));
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
