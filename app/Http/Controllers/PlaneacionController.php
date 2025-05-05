<?php

namespace App\Http\Controllers;

use App\Models\Calendario;
use App\Models\CatalagoTelar;
use App\Models\Modelos;
use App\Models\Planeacion; // Asegúrate de importar el modelo Planeacion
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlaneacionController extends Controller
{
    // Método para obtener los datos y pasarlos a la vista
    public function index(Request $request)
    {
        $headers = [
            'Cuenta', 'Salon', 'Telar', 'Ultimo', 'Cambios_Hilo', 'Maquina', 'Ancho', 'Eficiencia_Std', 'Velocidad_STD', 
            'Calibre_Rizo', 'Calibre_Pie', 'Calendario', 'Clave_Estilo', 'Tamano', 'Estilo_Alternativo', 'Nombre_Producto', 
            'Saldos', 'Fecha_Captura', 'Orden_Prod', 'Fecha_Liberacion', 'Id_Flog', 'Descrip', 'Aplic', 'Obs', 'Tipo_Ped', 
            'Tiras', 'Peine', 'Largo_Crudo', 'Peso_Crudo', 'Luchaje', 'CALIBRE_TRA', 'Dobladillo', 'PASADAS_TRAMA', 'PASADAS_C1',
            'PASADAS_C2', 'PASADAS_C3', 'PASADAS_C4', 'PASADAS_C5', 'ancho_por_toalla', 'COLOR_TRAMA', 'CALIBRE_C1', 'Clave_Color_C1', 
            'COLOR_C1', 'CALIBRE_C2', 'Clave_Color_C2', 'COLOR_C2', 'CALIBRE_C3', 'Clave_Color_C3', 'COLOR_C3', 'CALIBRE_C4', 
            'Clave_Color_C4', 'COLOR_C4', 'CALIBRE_C5', 'Clave_Color_C5', 'COLOR_C5', 'Plano', 'Cuenta_Pie', 'Clave_Color_Pie', 
            'Color_Pie', 'Peso____(gr_/_m²)', 'Dias_Ef', 'Prod_(Kg)/Día', 'Std/Dia', 'Prod_(Kg)/Día1', 'Std_(Toa/Hr)_100%', 
            'Dias_jornada_completa', 'Horas', 'Std/Hrefectivo', 'Inicio_Tejido', 'Calc4', 'Calc5', 'Calc6', 'Fin_Tejido', 
            'Fecha_Compromiso', 'Fecha_Compromiso1', 'Entrega', 'Dif_vs_Compromiso', 'en_proceso'
        ];
        
        $query = DB::table('TEJIDO_SCHEDULING');
        
        // Filtrar registros de acuerdo a los filtros recibidos
        if ($request->has('column') && $request->has('value')) {
            $columns = $request->input('column');
            $values = $request->input('value');
    
            foreach ($columns as $index => $column) {
                if (in_array($column, $headers) && isset($values[$index])) {
                    $query->where($column, 'like', '%' . $values[$index] . '%');
                }
            }
        }
        
        // Obtener los registros filtrados
        $datos = $query->get();
        
        return view('modulos/planeacion', compact('datos', 'headers'));
    }   

    //MODELOS MODELOS MODELOS para la creacion de este registro, no fue necesario hacer que se digitaran todos los datos, dado que la mayoria son calculos
    public function create(){
        //$flogs = DB::table('TEJIDO_SCHEDULING')->select('Id_Flog', 'Descrip')->get();
        $telares = DB::table('catalago_telares')->get();


        return view('TEJIDO-SCHEDULING.create-form',compact('telares'));
    }


    public function store(Request $request)
    {
        //dd($request->all()); // ✅ Imprime todos los datos del formulario
        // Crear nuevo registro con datos actuales y dejar los demás como null

        //traigo los datos faltantes para la creacion de un nuevo registro en la tabla TEJIDO_SCHEDULING
        $telar = CatalagoTelar::where('telar', $request->telar)->first();

        $modelo = Modelos::where('CLAVE_AX', $request->clave_ax)
        ->where('Departamento', $telar->salon)
        //->where('Nombre_de_Formato_Logistico',$request->nombre_modelo)
        ->first();

        //dd($modelo);

        Planeacion::create(

            [
                'Cuenta' => $request->input('cuenta_rizo'),
                'Salon' => $telar ? $telar->salon : null, //De esta forma se evita lanzar un error de laravel en caso de que $telar->telar sea nulo (no tenga valor) $telar ? $telar->salon :
                'Telar'  => $request->input('telar'),
                'Ultimo' => $modelo->RASEMA,
                'Cambios_Hilo' => $modelo->CODIGO_DE_DIBUJO,
                'Maquina' => null,
                'Ancho' =>(int) $modelo->Ancho,
                'Eficiencia_Std' => null,
                'Velocidad_STD' =>(int) null,
                'Calibre_Rizo'=> $request->input('calibre_rizo'),
                'Calibre_Pie' => $request->input('calibre_pie'),
                'Calendario' => null,
                'Clave_Estilo' => $modelo->Clave,
                'Tamano' => $request->input('tamano'), 
                'Estilo_Alternativo' => null,
                'Nombre_Producto' => $request->input('nombre_modelo'), 
                'Saldos' =>(int) $request->input('saldo'),
                'Fecha_Captura' => null,
                'Orden_Prod' => null,
                'Fecha_Liberacion' => null,
                'Id_Flog' =>(int) $request->input('no_flog'),
                'Descrip' => $request->input('descripcion'),
                'Aplic' => null,
                'Obs' => $modelo->Observaciones,
                'Tipo_Ped' => null,
                'Tiras' => (int) $modelo->TIRAS,
                'Peine' => (int) $modelo->Peine,
                'Largo_Crudo' => (int) $modelo->Largo,
                'Peso_Crudo' => null,
                'Luchaje' => (int) $modelo->Luchaje,
                'CALIBRE_TRA' => $request->input('trama_0'),
                'Dobladillo' => $modelo->Tipo_plano,
                'PASADAS_TRAMA' => (int) $modelo->PASADAS,
                'PASADAS_C1' => (int) $modelo->PASADAS_C1,
                'PASADAS_C2' => (int) $modelo->PASADAS_C2,
                'PASADAS_C3' => (int) $modelo->PASADAS_C3,
                'PASADAS_C4' => (int) $modelo->PASADAS_C4,
                'PASADAS_C5' => (int) $modelo->X,
                'ancho_por_toalla' => null, //CONCATENACION (int) $modelo->TIRAS . $modelo->TRAMA_Ancho_Peine,
                'COLOR_TRAMA' => $modelo->OBS_R1,
                'CALIBRE_C1' => (float) $request->input('calibre_1'),
                'Clave_Color_C1' => (float) $modelo->C1_R,
                'COLOR_C1' => $request->input('color_1'),
                'CALIBRE_C2' => (float) $request->input('calibre_2'),
                'Clave_Color_C2' => $modelo->C2_R,
                'COLOR_C2' => $request->input('color_2'),
                'CALIBRE_C3' => (float) $request->input('calibre_3'),
                'Clave_Color_C3' => $modelo->C3_R,
                'COLOR_C3' => $request->input('color_3'),
                'CALIBRE_C4' => (float) $request->input('calibre_4'),
                'Clave_Color_C4' => $modelo->C4_R,
                'COLOR_C4' => $request->input('color_4'),
                'CALIBRE_C5' => (float) $request->input('calibre_5'),
                'Clave_Color_C5' => $modelo->C5_R,
                'COLOR_C5' => $request->input('color_5'),
                'Plano' =>(int) $modelo->Med_plano,
                'Cuenta_Pie' => $request->input('cuenta_pie'),
                'Clave_Color_Pie' => null,
                'Color_Pie' => $modelo->OBS,
                'Peso_gr_m2' => null,//CONCATENACION? (int) $modelo->Ancho . $modelo->Largo,
                'Dias_Ef' => null,
                'Prod_Kg_Dia' =>(int) $modelo->KG_Dia,
                'Std_Dia' => null,
                'Prod_Kg_Dia1' => null,
                'Std_Toa_Hr_100' => null,
                'Dias_jornada_completa' => null,
                'Horas' => null,
                'Std_Hr_efectivo' => null,
                'Inicio_Tejido' => null,
                'Calc4' => null,
                'Calc5' => null,
                'Calc6' => null,
                'Fin_Tejido' => Carbon::parse($request->input('fecha_fin'))->format('Y-m-d'),
                'Fecha_Compromiso' => Carbon::parse($request->input('fecha_compromiso_tejido'))->format('Y-m-d'),
                'Fecha_Compromiso1' => Carbon::parse($request->input('fecha_cliente'))->format('Y-m-d'),
                'Entrega' => Carbon::parse($request->input('fecha_entrega'))->format('Y-m-d'),
                'Dif_vs_Compromiso' => null,

            // Aquí pueden ir más campos en el futuro
        ]);

        return redirect()->route('planeacion.index')->with('success', 'Registro guardado correctamente');
    }

    public function calendarios()
    {
        $calendarios = Calendario::all();
        return view('/catalagos/calendarios', compact('calendarios'));
    }
    
    public function aplicaciones()
    {
        return view('/catalagos/aplicaciones');
    }
    
    public function update(Request $request, $num_registro)
    {
        // Buscar el registro por Id
        $registro = Planeacion::where('num_registro', $num_registro)->first();
    
        if (!$registro) {
            return redirect()->route('planeacion.index')->with('error', 'Registro no encontrado');
        }
    
        // Verificar si se marca el checkbox 'en_proceso'
        if ($request->has('en_proceso') && $request->en_proceso == '1') {
            // Desmarcar todos los registros con el mismo telar
            Planeacion::where('Telar', $registro->Telar)
                ->update(['en_proceso' => false]); // Desmarcar todos los registros del mismo telar
    
            // Luego marcar solo el registro actual
            $registro->update(['en_proceso' => true]);
        } else {
            // Si no se marca, simplemente desmarcar el registro actual
            $registro->update(['en_proceso' => false]);
        }
    
        // Redirigir con mensaje
        return redirect()->route('planeacion.index') // Asegúrate de redirigir a la ruta correcta
            ->with('success', 'Estado actualizado correctamente');
    }

    //metodos de TELARES (tablas de datos de tejido)********************************************************************************************************
    public function mostrarTelarSulzer($telar)
    {
         // Buscar el registro en proceso para este telar
         $datos = DB::table('TEJIDO_SCHEDULING')
         ->where('en_proceso', 1)
         ->where('telar', $telar)
         ->get();
     
        if ($datos->isEmpty()) {
            return redirect()->back()->with('warning', 
            "Selecciona un registro en planeación para poner en proceso y ver los datos del telar {$telar}.");

        }     


        return view('modulos/tejido/telares/telar-informacion-individual', compact('telar', 'datos'));
    }

    public function obtenerOrdenesProgramadas($telar)
    {
            // Traemos solo los registros en_proceso = 0 para este telar
            $ordenes = Planeacion::where('telar', $telar)
                        ->where('en_proceso', 0)
                        ->get();


            // retornamos la vista correcta (no 'login')
            return view('modulos/tejido/telares/ordenes-programadas', compact('ordenes', 'telar'));

    }

    public function obtenerPorTejNum($tej_num){
        $movimientos = DB::connection('sqlsrv') // Asegúrate que esta conexión apunte a `Produccion`
            ->table('Produccion.dbo.tipo_movimientos')
            ->where('tej_num', $tej_num)
            ->select('tej_num', 'fecha', 'tipo_mov', 'cantidad')
            ->get();

        return response()->json($movimientos);
    }

    // funcionando?
    public function buscarModelos(Request $request)
    {
        $search = $request->input('q');

        $resultados = DB::table('MODELOS')
            ->select('CLAVE_AX')
            ->where('CLAVE_AX', 'like', "%{$search}%")
            ->distinct()
            ->limit(20)
            ->get();

        return response()->json($resultados);
    }

    // Nuevo método para obtener modelos por CLAVE_AX
    public function obtenerModelosPorClave(Request $request)
    {
        $clave = $request->input('clave_ax');

        $modelos = DB::table('MODELOS')
            ->select('Modelo')
            ->where('CLAVE_AX', $clave)
            ->get();

        return response()->json($modelos);
    }

    public function buscarDetalleModelo(Request $request)
    {
        $clave = $request->input('clave_ax');
        $modelo = $request->input('nombre_modelo');
    
        $detalle = DB::table('MODELOS')
            ->where('CLAVE_AX', $clave)
            ->where('Modelo', $modelo)
            ->first();
    
        return response()->json($detalle);
    }
    


}
