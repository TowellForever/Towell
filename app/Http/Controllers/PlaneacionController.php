<?php

namespace App\Http\Controllers;

use App\Models\Calendario;
use App\Models\CatalagoEficiencia;
use App\Models\CatalagoTelar;
use App\Models\CatalagoVelocidad;
use App\Models\Modelos;
use App\Models\Planeacion; // Asegúrate de importar el modelo Planeacion
use App\Models\TipoMovimientos;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlaneacionController extends Controller
{
    private function cleanDecimal($value) {
        $value = str_replace(',', '.', trim($value));
        return is_numeric($value) ? number_format((float) $value, 2, '.', '') : null;
    }

    // Método para obtener los datos y pasarlos a la vista
    public function index(Request $request)
    {
        $headers = [
            'en_proceso', 'Cuenta', 'Salon', 'Telar', 'Ultimo', 'Cambios_Hilo', 'Maquina', 'Ancho', 'Eficiencia_Std', 'Velocidad_STD', 
            'Calibre_Rizo', 'Calibre_Pie', 'Calendario', 'Clave_Estilo', 'Tamano', 'Estilo_Alternativo', 'Nombre_Producto', 
            'Saldos', 'Fecha_Captura', 'Orden_Prod', 'Fecha_Liberacion', 'Id_Flog', 'Descrip', 'Aplic', 'Obs', 'Tipo_Ped', 
            'Tiras', 'Peine', 'Largo_Crudo', 'Peso_Crudo', 'Luchaje', 'CALIBRE_TRA', 'Dobladillo', 'PASADAS_TRAMA', 'PASADAS_C1',
            'PASADAS_C2', 'PASADAS_C3', 'PASADAS_C4', 'PASADAS_C5', 'ancho_por_toalla', 'COLOR_TRAMA', 'CALIBRE_C1', 'Clave_Color_C1', 
            'COLOR_C1', 'CALIBRE_C2', 'Clave_Color_C2', 'COLOR_C2', 'CALIBRE_C3', 'Clave_Color_C3', 'COLOR_C3', 'CALIBRE_C4', 
            'Clave_Color_C4', 'COLOR_C4', 'CALIBRE_C5', 'Clave_Color_C5', 'COLOR_C5', 'Plano', 'Cuenta_Pie', 'Clave_Color_Pie', 
            'Color_Pie', 'Peso____(gr_/_m²)', 'Dias_Ef', 'Prod_(Kg)/Día', 'Std/Dia', 'Prod_(Kg)/Día1', 'Std_(Toa/Hr)_100%', 
            'Dias_jornada_completa', 'Horas', 'Std/Hrefectivo', 'Inicio_Tejido', 'Calc4', 'Calc5', 'Calc6', 'Fin_Tejido', 
            'Fecha_Compromiso', 'Fecha_Compromiso1', 'Entrega', 'Dif_vs_Compromiso', 
        ];
        
        $query = DB::table('TEJIDO_SCHEDULING')
            ->orderBy('TELAR'); // Ascendente por defecto
        
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
        ->first();
    
        if (!$modelo) {
            return back()->with('error', 'Modelo no encontrado');
        }

        $hilo = 'O16'  ; //VARIABLE TEMPORAL, ES NECESARIO UN CÁT DE HILOS
        
        $densidad = $modelo->Tra > 40 ? 'Alta' : 'Normal';
        $velocidad = CatalagoVelocidad::where('telar', $telar->nombre) ->where('tipo_hilo', $hilo)->where('densidad', $densidad) ->value('velocidad');

        $eficiencia = CatalagoEficiencia::where('telar', $telar->nombre)->where('tipo_hilo', $hilo)->where('densidad', $densidad) ->value('eficiencia'); 
        
        $Peso_gr_m2 = ($modelo->P_crudo * 10000) / ($modelo->Largo * $modelo->Ancho); 

        // Dias efectivos
        $inicio = Carbon::parse($request->input('fecha_inicio'));
        $fin = Carbon::parse($request->input('fecha_fin'));
        $diferenciaHoras = $inicio->diffInHours($fin);// Diferencia total en horas --> -->  // Convertir a días con decimales (1 día = 24 horas)
        $Dias_Ef = round($diferenciaHoras / 24, 2); // redondeado a 2 decimales BA en EXCEL 
        
        $Std_Hr_efectivo = ($request->input('saldo') / ($diferenciaHoras/24)) / 24;   //=(P21/(BM21-BI21))/24   -->   (Saldos/ (fecha_fin - fecha_inicio) ) / 24  (7000 / 13.9) / 24
        
        //Producción de kilogramos por DIA
        $Prod_Kg_Dia = ($modelo->P_crudo * $Std_Hr_efectivo) * 24 / 1000; //<-- <-- <-- BD en EXCEL -> PEMDAS MINE
        
        $Std_Dia = (($modelo->TIRAS * 60) / (  (  ($modelo->TOTAL) + ((($modelo->Luchaje * 0.5) / 0.0254) / $modelo->Repeticiones_p_corte) )/ $velocidad) * $eficiencia) * 24; //LISTOO

        $Prod_Kg_Dia1 = ($Std_Dia * $modelo->P_crudo)/1000; 

        $Std_Toa_Hr_100 = (($modelo->TIRAS * 60) / (  (  ($modelo->TOTAL/1) + (($modelo->Luchaje * 0.5) / 0.0254) / $modelo->Repeticiones_p_corte) / $velocidad)) ; //LISTOO //velocidad variable pendiente

        $Horas = $request->input('saldo') / ($Std_Toa_Hr_100 * $eficiencia);

        $Dias_jornada_completa = $Horas / 24;

        $ancho_por_toalla = ( (int) $modelo->TRAMA_Ancho_Peine / (int)$modelo->TIRAS) * 1.001; //(AK2 / AK1) * 1.001

            //VARIABLES TEMPORALES - borrar despues de tener catalagos
            $aplic = 'RZ';
            $calibre_pie = 10.1;
            $Cambios_Hilo = 1;

        //Validamos que no existe el registro, en caso de red lenta o de que el user de 2 clics, no se creen multiples registros con la misma informacion.
        $cuenta = $request->input('cuenta_rizo');
        $telarE = $request->input('telar');
        $nombreModelo = $request->input('nombre_modelo');
        $inicio = now()->copy()->subSeconds(5);
        $fin = now()->copy()->addSeconds(5);
        
        $existe = Planeacion::where('Cuenta', $cuenta)
            ->where('Telar', $telarE)
            ->where('Nombre_Producto', $nombreModelo)
            ->whereBetween('Fecha_Captura', [$inicio, $fin])
            ->exists();        
        
        if ($existe) {
            return redirect()->route('planeacion.index')->with('error', 'Este registro de planeación ya existe.');
        }

        //NUEVOS CAMPOS para TEJIDO_SCHEDULING (siguientes tablas en excel en TEJIDO_SCHEDULING)
        //Por ahora tendremos en cuentas las fechas INICIO y FIN CAPTURABLES
        $Fechainicio = Carbon::parse($request->input('fecha_inicio'));
        $Fechafin = Carbon::parse($request->input('fecha_fin'));

        if ($Fechafin->lessThanOrEqualTo($Fechainicio)) {
            return response()->json(['error' => 'La fecha fin debe ser posterior a la fecha inicio'], 422);
        }

       // Crear el periodo de días
      $periodo = CarbonPeriod::create($Fechainicio->copy()->startOfDay(), $Fechafin->copy()->endOfDay());

      $dias = [];
      $totalDias = 0;

      //INICIAMOS LOS CALCULOS DE ACUERDO A LAS FORMULAS DE ARCHIVO EXCEL DE PEPE OWNER
      foreach ($periodo as $index => $dia) {
          $inicioDia = $dia->copy()->startOfDay();
          $finDia = $dia->copy()->endOfDay();

          // Calcular la fracción para el primer y segundo día
          if ($index === 0) {
                  // Primer día: calcular la fracción desde la hora de inicio
                  $horasInicio = $Fechainicio->hour + ($Fechainicio->minute / 60); // Convertir horas y minutos a decimal
                  $horasFin = 24; // El día tiene 24 horas
                  $fraccion = round(($horasFin - $horasInicio) / 24, 3); // Calcular la fracción del día
                  $piezas = round(($fraccion * 24) * $Std_Hr_efectivo, 2);
                  $kilos = round(($piezas * $Prod_Kg_Dia) / ($Std_Hr_efectivo * 24), 2);

                  $cambio = $Cambios_Hilo; //si Cambios_Hilo = 1, asignamos 1
                  $rizo = 1; // Valor por defecto
                    if ($aplic === 'RZ') { $rizo = 1; } elseif ($aplic === 'RZ2') { $rizo = 2; } elseif ($aplic === 'RZ3') { $rizo = 3;} elseif ($aplic === 'BOR') {$rizo = 1;
                    } elseif ($aplic === 'EST') { $rizo = 1; } elseif ($aplic === 'DC') { $rizo = 1; }
                  $TRAMA =((((0.59*((((int)$modelo->PASADAS * 1.001) * $ancho_por_toalla) / 100))/ $request->input('trama_0')) * $piezas)/1000);
                  $combinacion1 =((((0.59 * ((((int)$modelo->PASADAS_C1 * 1.001) * $ancho_por_toalla) / 100)) / $request->input('calibre_1')) * $piezas)/ 1000) ;
                  $combinacion2 = ((((0.59 * ((((int)$modelo->PASADAS_C2 * 1.001) * $ancho_por_toalla) / 100)) / $request->input('calibre_2')) * $piezas) / 1000);
                  $combinacion3 = ((($request->input('calibre_3') != 0 ? (0.59 * (((int)$modelo->PASADAS_C3 * $ancho_por_toalla) / 100)) / $request->input('calibre_3') : 0)) * $piezas) / 1000;
                  $combinacion4 = ((($request->input('calibre_4') != 0 ? (0.59 * (((int)$modelo->PASADAS_C4 * $ancho_por_toalla) / 100)) / $request->input('calibre_3') : 0)) * $piezas) / 1000;
                  
                  $Piel1 =((((((((float) $modelo->Largo + (float) $modelo->Med_plano) /100)* 1.055 ) * 0.00059)/((0.00059 * 1)/(0.00059 / $calibre_pie ))) *
                   (((float) $request->input('cuenta_pie') - 32) / (float) $modelo->TIRAS)) * $piezas);

                  $riso = ($kilos  - ($Piel1 + $combinacion3 + $combinacion2 + $combinacion1 +  $TRAMA + $combinacion4));

                  $dias[] = [
                      'fecha' => $dia->toDateString(),
                      'fraccion_dia' => $fraccion,
                      'piezas' => $piezas,
                      'kilos' => $kilos,
                      'rizo' => $rizo,
                      'cambio' => $cambio,
                      'trama' => $TRAMA,
                      'combinacion1' => $combinacion1,
                      'combinacion2' => $combinacion2,
                      'combinacion3' => $combinacion3,
                      'combinacion4' => $combinacion4,
                      'piel1' => $Piel1,
                      'riso' => $riso,
                  ];
                  $totalDias++;
          }  elseif ($dia->isSameDay($Fechafin)) {
                  // Último día: calcular la fracción desde 00:00 hasta la hora fin
                  $realInicio = $inicioDia;
                  $realFin = $Fechafin;
                  $segundos = $realFin->diffInSeconds($realInicio, true);
                  $fraccion = round($segundos / 86400, 3); //agregamos esta linea de codigo para calcular las piezas
                  $piezas = round(($fraccion * 24) * $Std_Hr_efectivo, 2);
                  $kilos = round(($piezas * $Prod_Kg_Dia) / ($Std_Hr_efectivo * 24), 2);

                  $cambio = $Cambios_Hilo; //si Cambios_Hilo = 1, asignamos 1
                  $rizo = 1; // Valor por defecto
                    if ($aplic === 'RZ') { $rizo = 1; } elseif ($aplic === 'RZ2') { $rizo = 2; } elseif ($aplic === 'RZ3') { $rizo = 3;} elseif ($aplic === 'BOR') {$rizo = 1;
                    } elseif ($aplic === 'EST') { $rizo = 1; } elseif ($aplic === 'DC') { $rizo = 1; }
                  $TRAMA =((((0.59*((((int)$modelo->PASADAS * 1.001) * $ancho_por_toalla) / 100))/ $request->input('trama_0')) * $piezas)/1000);
                  $combinacion1 =((((0.59 * ((((int)$modelo->PASADAS_C1 * 1.001) * $ancho_por_toalla) / 100)) / $request->input('calibre_1')) * $piezas)/ 1000) ;
                  $combinacion2 = ((((0.59 * ((((int)$modelo->PASADAS_C2 * 1.001) * $ancho_por_toalla) / 100)) / $request->input('calibre_2')) * $piezas) / 1000);
                  $combinacion3 = ((($request->input('calibre_3') != 0 ? (0.59 * (((int)$modelo->PASADAS_C3 * $ancho_por_toalla) / 100)) / $request->input('calibre_3') : 0)) * $piezas) / 1000;
                  $combinacion4 = ((($request->input('calibre_4') != 0 ? (0.59 * (((int)$modelo->PASADAS_C4 * $ancho_por_toalla) / 100)) / $request->input('calibre_3') : 0)) * $piezas) / 1000;
                  $Piel1 =((((((((float) $modelo->Largo + (float) $modelo->Med_plano) /100)* 1.055 ) * 0.00059)/((0.00059 * 1)/(0.00059 / $calibre_pie ))) *
                   (((float) $request->input('cuenta_pie') - 32) / (float) $modelo->TIRAS)) * $piezas);

                  $riso = ($kilos  - ($Piel1 + $combinacion3 + $combinacion2 + $combinacion1 +  $TRAMA + $combinacion4));

                  $dias[] = [
                      'fecha' => $dia->toDateString(),
                      'fraccion_dia' => round($segundos / 86400, 3),
                      'piezas' => $piezas,
                      'kilos' => $kilos,
                      'rizo' => $rizo,
                      'cambio' => $cambio,
                      'trama' => $TRAMA,
                      'combinacion1' => $combinacion1,
                      'combinacion2' => $combinacion2,
                      'combinacion3' => $combinacion3,
                      'combinacion4' => $combinacion4,
                      'piel1' => $Piel1,
                      'riso' => $riso,
                  ];
                  $totalDias++;
           }else {
                  $fraccion = 1;
                  // Días intermedios: fracción completa (1)
                  $piezas = round(($fraccion * 24) * $Std_Hr_efectivo, 2);
                  $kilos = round(($piezas * $Prod_Kg_Dia) / ($Std_Hr_efectivo * 24), 2);

                   $cambio = $Cambios_Hilo; //si Cambios_Hilo = 1, asignamos 1
                  $rizo = 1; // Valor por defecto
                    if ($aplic === 'RZ') { $rizo = 1; } elseif ($aplic === 'RZ2') { $rizo = 2; } elseif ($aplic === 'RZ3') { $rizo = 3;} elseif ($aplic === 'BOR') {$rizo = 1;
                    } elseif ($aplic === 'EST') { $rizo = 1; } elseif ($aplic === 'DC') { $rizo = 1; }
                 
                  $TRAMA =((((0.59*((((int)$modelo->PASADAS * 1.001) * $ancho_por_toalla) / 100))/ $request->input('trama_0')) * $piezas)/1000);
                  $combinacion1 =((((0.59 * ((((int)$modelo->PASADAS_C1 * 1.001) * $ancho_por_toalla) / 100)) / $request->input('calibre_1')) * $piezas)/ 1000) ;
                  $combinacion2 = ((((0.59 * ((((int)$modelo->PASADAS_C2 * 1.001) * $ancho_por_toalla) / 100)) / $request->input('calibre_2')) * $piezas) / 1000);
                  $combinacion3 = ((($request->input('calibre_3') != 0 ? (0.59 * (((int)$modelo->PASADAS_C3 * $ancho_por_toalla) / 100)) / $request->input('calibre_3') : 0)) * $piezas) / 1000;
                  $combinacion4 = ((($request->input('calibre_4') != 0 ? (0.59 * (((int)$modelo->PASADAS_C4 * $ancho_por_toalla) / 100)) / $request->input('calibre_3') : 0)) * $piezas) / 1000;
                  $Piel1 =((((((((float) $modelo->Largo + (float) $modelo->Med_plano) /100)* 1.055 ) * 0.00059)/((0.00059 * 1)/(0.00059 / $calibre_pie ))) *
                   (((float) $request->input('cuenta_pie') - 32) / (float) $modelo->TIRAS)) * $piezas);

                  $riso = ($kilos  - ($Piel1 + $combinacion3 + $combinacion2 + $combinacion1 +  $TRAMA + $combinacion4));

                  
                  $dias[] = [
                      'fecha' => $dia->toDateString(),
                      'fraccion_dia' => 1, // Día completo
                      'piezas' => $piezas,
                      'kilos' => $kilos,
                      'rizo' => $rizo,
                      'cambio' => $cambio,
                      'trama' => $TRAMA,
                      'combinacion1' => $combinacion1,
                      'combinacion2' => $combinacion2,
                      'combinacion3' => $combinacion3,
                      'combinacion4' => $combinacion4,
                      'piel1' => $Piel1,
                      'riso' => $riso,
                  ];
                  $totalDias++;
          }
      }

      // Mostrar el resultado con dd()
      // AHORA VAMOS CON LAS FORMULAS RESTANTES
      /*dd([
          'dias_generados' => $dias,
          'total_dias' => $totalDias,
      ]);*/
      //procedemos con las formulas de excel tomando en cuenta las proporciones de los dias de acuerdo a las fechas de inicio y fin



        $nuevoRegistro = Planeacion::create(
            [ 
                'Cuenta' => $request->input('cuenta_rizo'),
                'Salon' => $telar ? $telar->salon : null, //De esta forma se evita lanzar un error de laravel en caso de que $telar->telar sea nulo (no tenga valor) $telar ? $telar->salon :
                'Telar'  => $request->input('telar'),
                'Ultimo' =>  null,
                'Cambios_Hilo' => null,
                'Maquina' => $telar ? $telar->nombre : null,
                'Ancho' => $modelo ? (int) $modelo->Ancho: null,
                'Eficiencia_Std' => $eficiencia,
                'Velocidad_STD' => $velocidad,
                'Calibre_Rizo'=> null,
                'Calibre_Pie' =>  null,
                'Calendario' => null,
                'Clave_Estilo' => $request->input('tamano') . $request->input('clave_ax'),
                'Tamano' => $request->input('tamano'), 
                'Estilo_Alternativo' => null,
                'Nombre_Producto' => $modelo ? $modelo->Modelo : null, 
                'Saldos' =>$request->input('saldo'),
                'Fecha_Captura' =>  Carbon::now(), 
                'Orden_Prod' => null,
                'Fecha_Liberacion' => $request->input('fecha_scheduling'),
                'Id_Flog' => $request->input('no_flog'),
                'Descrip' => $request->input('descripcion'),
                'Aplic' => null,
                'Obs' => $modelo ? $modelo->Observaciones : null,
                'Tipo_Ped' => explode('-', $request->input('no_flog'))[0],
                'Tiras' => $modelo ? (int)$modelo->TIRAS : null,  
                'Peine' => $modelo ? (int)$modelo->Peine : null,
                'Largo_Crudo' => $modelo ? (float) $modelo->Largo:null,
                'Peso_Crudo' => $modelo->P_crudo ? (int) $modelo->P_crudo : null,
                'Luchaje' => $modelo ? (int) $modelo->Luchaje:null,
                'CALIBRE_TRA' => $request->input('trama_0'),
                'Dobladillo' => $modelo ? $modelo->Tipo_plano : null,
                'PASADAS_TRAMA' =>  $modelo ? (int)$modelo->PASADAS : null , 
                'CALIBRE_TRA' => $request->input('trama_0'),
                'PASADAS_C1' => $modelo ? (int)$modelo->PASADAS_C1 : null ,
                'PASADAS_C2' => $modelo ? (int)$modelo->PASADAS_C2 : null ,
                'PASADAS_C3' => $modelo ? (int)$modelo->PASADAS_C3 : null ,
                'PASADAS_C4' => $modelo ? (int)$modelo->PASADAS_C4 : null ,
                'PASADAS_C5' =>  $modelo ? (int)$modelo->X : null,
                'ancho_por_toalla' =>$modelo ? (float) $ancho_por_toalla : null,
                'COLOR_TRAMA' => $modelo ? $modelo->OBS_R1 :null ,
                'CALIBRE_C1' =>  $modelo ? $request->input('calibre_1') :null,
                'Clave_Color_C1' => null ,
                'COLOR_C1' => $request->input('color_1'), 
                'CALIBRE_C2' =>  $request->input('calibre_2'),
                'Clave_Color_C2' =>  null ,
                'COLOR_C2' => $request->input('color_2'),
                'CALIBRE_C3' =>  $request->input('calibre_3'),
                'Clave_Color_C3' =>null ,
                'COLOR_C3' => $request->input('color_3'),
                'CALIBRE_C4' =>  $request->input('calibre_4'),
                'Clave_Color_C4' =>null ,
                'COLOR_C4' => $request->input('color_4'),
                'CALIBRE_C5' =>  $request->input('calibre_5'),
                'Clave_Color_C5' => null ,
                'COLOR_C5' => $request->input('color_5'),
                'Plano' => $modelo ? (int) $modelo->Med_plano :null ,
                'Cuenta_Pie' => $request->input('cuenta_pie'),
                'Clave_Color_Pie' => null,
                'Color_Pie' =>$modelo ? $modelo->OBS : null,
                'Peso_gr_m2' => is_numeric($Peso_gr_m2) ? number_format((float) str_replace(',', '.', $Peso_gr_m2), 2, '.', '') : null,
                'Dias_Ef' => is_numeric($Dias_Ef) ? number_format((float) str_replace(',', '.', $Dias_Ef), 2, '.', '') : null,
                'Prod_Kg_Dia' => is_numeric(str_replace(',', '.', $Prod_Kg_Dia1)) ? number_format((float) str_replace(',', '.', $Prod_Kg_Dia1), 2, '.', '') : null,
                'Std_Dia' => is_numeric($Std_Dia) ? number_format((float) str_replace(',', '.', $Std_Dia), 2, '.', '') : null,
                'Prod_Kg_Dia1' => is_numeric($Prod_Kg_Dia) ? number_format((float) str_replace(',', '.', $Prod_Kg_Dia), 2, '.', '') : nullf,
                'Std_Toa_Hr_100' => is_numeric(str_replace(',', '.', $Std_Toa_Hr_100)) ? number_format((float) str_replace(',', '.', $Std_Toa_Hr_100), 2, '.', '') : null,
                'Dias_jornada_completa' => is_numeric(str_replace(',', '.', $Dias_jornada_completa)) ? number_format((float) str_replace(',', '.', $Dias_jornada_completa), 2, '.', '') : null,
                'Horas' => $this->cleanDecimal($Horas), // aqui estoy utilizando una funcion privada, para omitir el escribir todo el codigo en cada parametro
                'Std_Hr_efectivo' => $this->cleanDecimal($Std_Hr_efectivo),
                'Inicio_Tejido' => Carbon::parse($request->input('fecha_inicio'))->format('Y-m-d H:i:s'),
                'Calc4' => null,
                'Calc5' => null,
                'Calc6' => null,
                'Fin_Tejido' => Carbon::parse($request->input('fecha_fin'))->format('Y-m-d H:i:s'),
                'Fecha_Compromiso' => Carbon::parse($request->input('fecha_compromiso_tejido'))->format('Y-m-d'),
                'Fecha_Compromiso1' => Carbon::parse($request->input('fecha_cliente'))->format('Y-m-d'),
                'Entrega' => Carbon::parse($request->input('fecha_entrega'))->format('Y-m-d'),
                'Dif_vs_Compromiso' => null,

            // Aquí pueden ir más campos en el futuro
        ]);


        //una vez creado el nuevo registro, la info se almacena en la variable $nuevoRegistro, y con esa informacion obtenemos el num_registro (una vez ya generado el nuevo registro en TEJIDO_SCHEDULING)
         // Ahora puedes acceder al ID o cualquier otro valor generado automáticamente
        $tejNum = $nuevoRegistro->num_registro; // si se genera automáticamente
        // o, si lo necesitas crear tú:
         foreach ($dias as $registro) {
          \App\Models\TipoMovimientos::create([
              'fecha_inicio'   => $Fechainicio, //no son necesarias
              'fecha_fin'      => $Fechafin, //no son necesaria
              'fecha' => Carbon::createFromFormat('Y-m-d', $registro['fecha'])->toDateString(),
              'fraccion_dia'   => $registro['fraccion_dia'],
              'pzas'           => $registro['piezas'],
              'kilos'          => $registro['kilos'],
              'rizo'           => $registro['rizo'],
              'cambio'         => $registro['cambio'],
              'trama'          => $registro['trama'],
              'combinacion1'   => $registro['combinacion1'],
              'combinacion2'   => $registro['combinacion2'],
              'combinacion3'   => $registro['combinacion3'],
              'combinacion4'   => $registro['combinacion4'],
              'piel1'          => $registro['piel1'],
              'riso'           => $registro['riso'], 
              'tej_num'        => $tejNum, // Asegúrate de que este valor venga del formulario
          ]);
      }

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
    //El siguiente método obtiene un objeto con la informacion completa de la tabla TEJIDO_SCHEDULING, en lo sucesivo, se mostrará la informacon del telar en la vista dinámica individual
    public function mostrarTelarSulzer($telar)
    {
         // Buscar el registro en proceso para este telar
         $datos = DB::table('TEJIDO_SCHEDULING')
         ->where('en_proceso', true)
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
        $claveAx = $request->input('clave_ax');
        $departamento = $request->input('departamento'); // 'Salon'
    
        $modelos = Modelos::where('CLAVE_AX', $claveAx)
            ->where('Departamento', $departamento)
            ->select('Modelo', 'Departamento')
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

    // metodo para recuperar datos para tabla tipo_Movimientos
        public function obtenerPorTejNum($tej_num){
        $movimientos = DB::connection('sqlsrv') // Asegúrate que esta conexión apunte a `Produccion`
            ->table('Produccion.dbo.tipo_movimientos')
            ->where('tej_num', $tej_num)
            ->select('*')
            ->get();

        return response()->json($movimientos);
    }

}
