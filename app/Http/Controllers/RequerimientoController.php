<?php

namespace App\Http\Controllers;

use App\Models\InventDim;
use App\Models\InventSum;
use Illuminate\Http\Request;
use App\Models\Requerimiento;
use Illuminate\Support\Facades\DB;

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
            'orden_prod' => $request->orden_prod,
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
            ->orderBy('fecha', 'asc') // Ordena por fecha más cercana
            ->get();
    
        // Obtener los datos de la BD TI_PRO con los joins y filtros correspondientes
        $inventarios = DB::connection('sqlsrv_ti')
            ->table('TI_PRO.dbo.INVENTSUM as INVENTSUM')
            ->join('TI_PRO.dbo.INVENTDIM as INVENTDIM', 'INVENTSUM.INVENTDIMID', '=', 'INVENTDIM.INVENTDIMID')
            ->join('TI_PRO.dbo.PRODTABLE as PRODTABLE', function ($join) {
                $join->on('PRODTABLE.INVENTDIMID', '=', 'INVENTDIM.INVENTDIMID')
                     ->where('PRODTABLE.PRODSTATUS', 7)
                     ->where('PRODTABLE.DATAAREAID', 'PRO');
            })
            ->join('TI_PRO.dbo.INVENTDIM as INVENTDIM1', function ($join) {
                $join->on('INVENTDIM.INVENTBATCHID', '=', 'INVENTDIM1.INVENTBATCHID')
                     ->on('INVENTDIM.INVENTSERIALID', '=', 'INVENTDIM1.INVENTSERIALID');
            })
            ->where('INVENTSUM.POSTEDQTY', '>', 0)
            ->where('INVENTSUM.DATAAREAID', 'PRO')
            ->where('INVENTDIM.INVENTLOCATIONID', 'A-JUL/TELA')
            ->select([
                'INVENTSUM.ITEMID',
                'INVENTSUM.POSTEDQTY',
                'INVENTDIM.CONFIGID',
                'INVENTDIM.INVENTSIZEID',
                'INVENTDIM.INVENTCOLORID',
                'INVENTDIM.INVENTLOCATIONID',
                'INVENTDIM.INVENTBATCHID',
                'INVENTDIM.WMSLOCATIONID',
                'INVENTDIM.INVENTSERIALID',
                'PRODTABLE.MTS',
                'PRODTABLE.REALDATE'
            ])
            ->get();
    
        return view('modulos/tejido/programar-requerimientos', compact('requerimientos', 'inventarios'));
    }
     

}
