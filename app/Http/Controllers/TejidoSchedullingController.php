<?php

namespace App\Http\Controllers;

use App\Models\CatalagoEficiencia;
use App\Models\CatalagoTelar;
use App\Models\CatalagoVelocidad;
use App\Models\Modelos;
use App\Models\Planeacion;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TejidoSchedullingController extends Controller
{
    private function cleanDecimal($value)
    {
        $value = str_replace(',', '.', trim($value));
        return is_numeric($value) ? number_format((float) $value, 2, '.', '') : null;
    }
    private function fecha_a_excel_serial($fecha)
    {
        $excelBase = strtotime('1899-12-30 00:00:00');
        $timestamp = strtotime($fecha);
        return ($timestamp - $excelBase) / 86400;
    }
    public function envioDeDataPlaneacion(Request $request)
    {
        $telares = DB::table('catalago_telares')->get();
        $datos = $request->query(); // datos por URL
        return view('TEJIDO-SCHEDULING.traspaso-create-form', compact('datos', 'telares'));
    }

    public function buscarUltimoPorTelar(Request $request)
    {
        $telar = $request->input('telar');

        // Buscar el registro que tiene ULTIMO en el campo Ultimo
        $registro = DB::table('TEJIDO_SCHEDULING')
            ->where('Telar', $telar)
            ->where('Ultimo', 'ULTIMO')
            ->where('id', '>', 122)
            ->first();

        if ($registro) {
            // Si existe, actualizamos el campo Ultimo a null
            DB::table('TEJIDO_SCHEDULING')
                ->where('id', $registro->id) // usa el id para asegurarte que solo ese registro cambia
                ->update(['Ultimo' => null]);
        }

        return response()->json($registro); // Te regresa el registro (ya sin ULTIMO)
    }

    public function calcularFechaFin(Request $request)
    {
        //dd($request->all()); // ✅ Imprime todos los datos del formulario
        // Crear nuevo registro con datos actuales y dejar los demás como null

        $telar = $request->input('telar'); // Arreglo
        $clave_ax = $request->input('clave_ax');
        $tamano = $request->input('tamano');
        // ¿Cuántos telares llegaron?


        //traigo los datos faltantes para la creacion de un nuevo registro en la tabla TEJIDO_SCHEDULING
        $telar1 = CatalagoTelar::where('telar', $telar)->first();

        $modelo = Modelos::where('CLAVE_AX', $clave_ax) //MAN7028
            ->where('Tamanio_AX', $tamano)
            ->where('Departamento', $telar1->salon)
            ->first();

        if (!$modelo) {
            // Retorna un error, puedes poner un código de error personalizado si quieres
            return response()->json([
                'error' => true,
                'message' => 'No se encontró un modelo con los datos del telar seleccionado.'
            ], 404); // 404 es "Not Found", puedes usar 200 si no quieres que JS lo vea como "error"
        }

        //Validación de que el MODELO exista, puede NO coincidir por el salon

        $hilo = $request->input('hilo');
        $densidad = (int) $modelo->Tra > 40 ? 'Alta' : 'Normal';
        $velocidad = CatalagoVelocidad::where('telar', $telar1->nombre)->where('tipo_hilo', $hilo)->where('densidad', $densidad)->value('velocidad');
        $eficiencia = CatalagoEficiencia::where('telar', $telar1->nombre)->where('tipo_hilo', $hilo)->where('densidad', $densidad)->value('eficiencia');

        $Std_Toa_Hr_100 = (($modelo->TIRAS * 60) / ((($modelo->TOTAL / 1) + (($modelo->Luchaje * 0.5) / 0.0254) / $modelo->Repeticiones_p_corte) / $velocidad)); //LISTOO //velocidad variable pendiente
        $Horas = $request->input('cantidad') / ($Std_Toa_Hr_100 * $eficiencia);
        $fecha_inicio =   $request->input('fecha_inicio'); //$request=>input('fecha_inicio')
        $tipo_calendario = $request->input('calendario');

        function sumarHorasCalendario($fecha_inicio, $horas, $tipo_calendario)
        {
            $dias = floor($horas / 24);
            $horas_restantes = floor($horas % 24);
            $minutos = round(($horas - floor($horas)) * 60);
            $fecha = Carbon::parse($fecha_inicio);

            switch ($tipo_calendario) {
                case 'Calendario Tej1':
                    // Suma directo
                    $fecha->addDays($dias)->addHours($horas_restantes)->addMinutes($minutos);
                    break;

                case 'Calendario Tej2':
                    // Suma solo lunes a sábado (domingo no cuenta)
                    for ($i = 0; $i < $dias; $i++) {
                        $fecha->addDay();
                        // Si es domingo, sumar 1 día más
                        if ($fecha->dayOfWeek == Carbon::SUNDAY) {
                            $fecha->addDay();
                        }
                    }
                    // Suma horas y minutos igual que arriba
                    $fecha = sumarHorasSinDomingo($fecha, $horas_restantes, $minutos);
                    break;

                case 'Calendario Tej3':
                    // Lunes a viernes completos, sábado solo hasta 18:29
                    $fecha = sumarHorasTej3($fecha, $dias, $horas_restantes, $minutos);
                    break;
            }

            return $fecha->format('Y-m-d H:i:s');
        }

        // Suma horas y minutos, saltando domingos si es necesario
        function sumarHorasSinDomingo($fecha, $horas, $minutos)
        {
            for ($i = 0; $i < $horas; $i++) {
                $fecha->addHour();
                if ($fecha->dayOfWeek == Carbon::SUNDAY) {
                    $fecha->addDay();
                    $fecha->setTime(0, 0); // Reinicia a las 00:00
                }
            }
            // Sumar minutos, si pasa de domingo igual salta
            for ($i = 0; $i < $minutos; $i++) {
                $fecha->addMinute();
                if ($fecha->dayOfWeek == Carbon::SUNDAY) {
                    $fecha->addDay();
                    $fecha->setTime(0, 0);
                }
            }
            return $fecha;
        }

        // Tej3: Lunes a viernes completos, sábado solo hasta 18:29
        function sumarHorasTej3($fecha, $dias, $horas, $minutos)
        {
            // Suma días, saltando domingos y controlando sábado
            for ($i = 0; $i < $dias; $i++) {
                $fecha->addDay();
                if ($fecha->dayOfWeek == Carbon::SUNDAY) {
                    $fecha->addDay();
                }
                if (
                    $fecha->dayOfWeek == Carbon::SATURDAY && $fecha->hour > 18 ||
                    ($fecha->hour == 18 && $fecha->minute > 29)
                ) {
                    // Si ya son después de las 18:29 del sábado, ir al lunes 7:00am
                    $fecha->addDays(2)->setTime(7, 0);
                }
            }
            // Suma horas y minutos igual, pero revisa el caso de sábado
            // (Puedes usar una lógica similar a sumarHorasSinDomingo pero adaptando el sábado)
            // — Para hacerlo perfecto habría que controlar cada paso, lo quieres así?
            // ¿O solo una versión básica de ejemplo?
            return $fecha;
        }


        $fecha = sumarHorasCalendario($fecha_inicio, $Horas, $tipo_calendario);
        //dd([
        //    'fecha_inicio' => $fecha_inicio,
        //    'fecha_fin' => $fecha,
        //    'Horas' => $Horas,
        //    'tipo_calendario' => $tipo_calendario,
        //]);


        return response()->json(['fecha' => $fecha]);
    }

    //metodos para FLOGS BUSCAR FLOGSO BUSCAR FLOGSO BUSCAR FLOGSO BUSCAR FLOGSO BUSCAR FLOGSO BUSCAR FLOGSO BUSCAR FLOGSO BUSCAR FLOGSO BUSCAR FLOGSO BUSCAR FLOGSO BUSCAR FLOGSO BUSCAR FLOGSO
    public function buscarFlogso(Request $request)
    {
        $query = $request->input('fingered');

        // 1. Buscar primero en TWFLOGBOMID
        $resultados = DB::connection('sqlsrv_ti')
            ->table('TWFLOGBOMID')
            ->select('INVENTSIZEID', 'ITEMID', 'IDFLOG', 'ITEMNAME')
            ->where('IDFLOG', 'like', '%' . $query . '%')
            ->orderBy('IDFLOG', 'asc')
            ->get();

        // 2.  buscar en TWFLOGSITEMLINE
        $resultados2 = DB::connection('sqlsrv_ti')
            ->table('TWFLOGSITEMLINE')
            ->select('INVENTSIZEID', 'ITEMID', 'IDFLOG', 'ITEMNAME')
            ->where('IDFLOG', 'like', '%' . $query . '%')
            ->orderBy('IDFLOG', 'asc')
            ->distinct()
            ->get();

        return response()->json(
            $resultados->merge($resultados2)->values()
        );
    }

    public function editarRegistro(Request $request)
    {
        //dd($request->all());

        $telares = DB::table('catalago_telares')->get();
        $datos = $request->query(); // datos por URL
        return view('TEJIDO-SCHEDULING.edit', compact('datos', 'telares'));
    }

    public function actualizarRegistro(Request $request)
    {
        // Buscar el registro principal
        $id = $request->input('id');
        $registro = Planeacion::findOrFail($id);
        $telares = $request->input('telar'); // Arreglo, pero aquí normalmente sería solo uno, porque editas por id.
        $i = 0; // Solo primer telar (en edición individual)

        // --- Copia aquí los mismos cálculos que en tu store (modelo, telar, formulas, etc.) ---
        $telar = CatalagoTelar::where('telar', $telares[$i])->first();
        $modelo = Modelos::where('CLAVE_AX', $request->clave_ax)
            ->where('Tamanio_AX', $request->tamano)
            ->where('Departamento', $telar->salon)
            ->first();

        $hilo = $request->input('hilo');
        $densidad = (int) $modelo->Tra > 40 ? 'Alta' : 'Normal';
        $velocidad = CatalagoVelocidad::where('telar', $telar->nombre)->where('tipo_hilo', $hilo)->where('densidad', $densidad)->value('velocidad');
        $eficiencia = CatalagoEficiencia::where('telar', $telar->nombre)->where('tipo_hilo', $hilo)->where('densidad', $densidad)->value('eficiencia');
        $Peso_gr_m2 = ($modelo->P_crudo * 10000) / ($modelo->Largo * $modelo->Ancho);

        // calculo de dias y fracciones de dias para FECHAS INICIO Y FIN
        $inicio = $request->fecha_inicio[$i];
        $fin = $request->fecha_fin[$i];
        $inicioX = $this->fecha_a_excel_serial($inicio);
        $inicioY = $this->fecha_a_excel_serial($fin);
        $DiferenciaZ = round($inicioY - $inicioX, 5);
        $Dias_Ef = round($DiferenciaZ / 24);

        $saldos = $request->input('cantidad');
        $Std_Hr_efectivo = ($saldos[$i] / ($DiferenciaZ)) / 24;
        $Prod_Kg_Dia = ($modelo->P_crudo * $Std_Hr_efectivo) * 24 / 1000;
        $Std_Dia = (($modelo->TIRAS * 60) / ((($modelo->TOTAL) + ((($modelo->Luchaje * 0.5) / 0.0254) / $modelo->Repeticiones_p_corte)) / $velocidad) * $eficiencia) * 24;
        $Prod_Kg_Dia1 = ($Std_Dia * $modelo->P_crudo) / 1000;
        $Std_Toa_Hr_100 = (($modelo->TIRAS * 60) / ((($modelo->TOTAL / 1) + (($modelo->Luchaje * 0.5) / 0.0254) / $modelo->Repeticiones_p_corte) / $velocidad));
        $Horas = $saldos[$i]  / ($Std_Toa_Hr_100 * $eficiencia);
        $Dias_jornada_completa = $Horas / 24;
        $ancho_por_toalla = ((float) $modelo->TRAMA_Ancho_Peine / (float)$modelo->TIRAS) * 1.001;
        $aplic = $request->input('aplicacion');
        $calibre_pie = $request->input('calibre_pie');
        $calibre_rizo = $modelo->Rizo;
        $Cambios_Hilo = 0;

        // --- Fechas inicio y fin ---
        $Fechainicio = Carbon::parse($request->fecha_inicio[$i]);
        $Fechafin = Carbon::parse($request->fecha_fin[$i]);

        if ($Fechafin->lessThanOrEqualTo($Fechainicio)) {
            return response()->json(['error' => 'La fecha fin debe ser posterior a la fecha inicio'], 422);
        }

        // --- Periodo de días ---
        $periodo = CarbonPeriod::create($Fechainicio->copy()->startOfDay(), $Fechafin->copy()->endOfDay());

        $dias = [];
        $totalDias = 0;
        //INICIAMOS LOS CALCULOS DE ACUERDO A LAS FORMULAS DE ARCHIVO EXCEL DE PEPE OWNER
        foreach ($periodo as $index => $dia) {
            $inicioDia = $dia->copy()->startOfDay();
            $finDia = $dia->copy()->endOfDay();

            // Calcular la fracción para el primer y segundo día
            if ($index === 0) {
                $inicio = strtotime($Fechainicio);
                $fin = strtotime($Fechafin);

                // Extraer fechas sin horas para comparar si son el mismo día
                $diaInicio = date('Y-m-d', $inicio);
                $diaFin = date('Y-m-d', $fin);

                if ($diaInicio === $diaFin) {
                    // 🟢 Mismo día: diferencia directa entre horas
                    $diferenciaSegundos = $fin - $inicio;
                    $fraccion = $diferenciaSegundos / 86400; // fracción del día
                } else {
                    // 🔵 Días distintos: desde hora de inicio hasta 12:00 AM del día siguiente
                    $hora = date('H', $inicio);
                    $minuto = date('i', $inicio);
                    $segundo = date('s', $inicio);
                    $segundosDesdeMedianoche = ($hora * 3600) + ($minuto * 60) + $segundo;
                    $segundosRestantes = 86400 - $segundosDesdeMedianoche;
                    $fraccion = $segundosRestantes / 86400;
                }

                // Cálculo de piezas (si aplica)
                $piezas = ($fraccion * 24) * $Std_Hr_efectivo;
                $kilos = ($piezas * $Prod_Kg_Dia) / ($Std_Hr_efectivo * 24);
                $cambio = $Cambios_Hilo; //si Cambios_Hilo = 1, asignamos 1
                $rizo = 0; // Valor por defecto
                if ($aplic === 'RZ') {
                    $rizo = 1 * $kilos;
                } elseif ($aplic === 'RZ2') {
                    $rizo = 2 * $kilos;
                } elseif ($aplic === 'RZ3') {
                    $rizo = 3 * $kilos;
                } elseif ($aplic === 'BOR') {
                    $rizo = 1 * $kilos;
                } elseif ($aplic === 'EST') {
                    $rizo = 1 * $kilos;
                } elseif ($aplic === 'DC') {
                    $rizo = 1 * $kilos;
                }

                $TRAMA = ((((0.59 * ((($modelo->PASADAS_1 * 1.001) * $ancho_por_toalla) / 100)) / (float) $request->input('trama_0')) * $piezas) / 1000);

                $combinacion1 =   ((((0.59 * (((float)$modelo->PASADAS_2 * 1.001) * $ancho_por_toalla)) / 100) / ((float) $request->input('calibre_1') != 0 ? (float) $request->input('calibre_1') : 1)) * $piezas) / 1000;
                $combinacion2 =   ((((0.59 * (((float)$modelo->PASADAS_3 * 1.001) * $ancho_por_toalla)) / 100) / ((float) $request->input('calibre_2') != 0 ? (float) $request->input('calibre_2') : 1)) * $piezas) / 1000;
                $combinacion3 =   ((((0.59 * (((float)$modelo->PASADAS_4 * 1.001) * $ancho_por_toalla)) / 100) / ((float) $request->input('calibre_3') != 0 ? (float) $request->input('calibre_3') : 1)) * $piezas) / 1000;
                $combinacion4 =   ((((0.59 * (((float)$modelo->PASADAS_5 * 1.001) * $ancho_por_toalla)) / 100) / ((float) $request->input('calibre_4') != 0 ? (float) $request->input('calibre_4') : 1)) * $piezas) / 1000;
                $Piel1 = ((((((((float) $modelo->Largo + (float) $modelo->Med_plano) / 100) * 1.055) * 0.00059) / ((0.00059 * 1) / (0.00059 / $calibre_pie))) *
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
            } elseif ($dia->isSameDay($Fechafin)) {
                // Último día: calcular la fracción desde 00:00 hasta la hora fin
                $realInicio = $inicioDia;
                $realFin = $Fechafin;
                $segundos = $realFin->diffInSeconds($realInicio, true);
                $fraccion = $segundos / 86400; //agregamos esta linea de codigo para calcular las piezas
                $piezas = ($fraccion * 24) * $Std_Hr_efectivo;
                $kilos = round(($piezas * $Prod_Kg_Dia) / ($Std_Hr_efectivo * 24), 2);

                $cambio = $Cambios_Hilo; //si Cambios_Hilo = 1, asignamos 1
                $rizo = 0; // Valor por defecto
                if ($aplic === 'RZ') {
                    $rizo = 1 * $kilos;
                } elseif ($aplic === 'RZ2') {
                    $rizo = 2 * $kilos;
                } elseif ($aplic === 'RZ3') {
                    $rizo = 3 * $kilos;
                } elseif ($aplic === 'BOR') {
                    $rizo = 1 * $kilos;
                } elseif ($aplic === 'EST') {
                    $rizo = 1 * $kilos;
                } elseif ($aplic === 'DC') {
                    $rizo = 1 * $kilos;
                }
                $TRAMA = ((((0.59 * ((($modelo->PASADAS_1 * 1.001) * $ancho_por_toalla) / 100)) / (float) $request->input('trama_0')) * $piezas) / 1000);

                $combinacion1 =   ((((0.59 * (((float)$modelo->PASADAS_2 * 1.001) * $ancho_por_toalla)) / 100) / ((float) $request->input('calibre_1') != 0 ? (float) $request->input('calibre_1') : 1)) * $piezas) / 1000;
                $combinacion2 =   ((((0.59 * (((float)$modelo->PASADAS_3 * 1.001) * $ancho_por_toalla)) / 100) / ((float) $request->input('calibre_2') != 0 ? (float) $request->input('calibre_2') : 1)) * $piezas) / 1000;
                $combinacion3 =   ((((0.59 * (((float)$modelo->PASADAS_4 * 1.001) * $ancho_por_toalla)) / 100) / ((float) $request->input('calibre_3') != 0 ? (float) $request->input('calibre_3') : 1)) * $piezas) / 1000;
                $combinacion4 =   ((((0.59 * (((float)$modelo->PASADAS_5 * 1.001) * $ancho_por_toalla)) / 100) / ((float) $request->input('calibre_4') != 0 ? (float) $request->input('calibre_4') : 1)) * $piezas) / 1000;

                $Piel1 = ((((((((float) $modelo->Largo + (float) $modelo->Med_plano) / 100) * 1.055) * 0.00059) / ((0.00059 * 1) / (0.00059 / $calibre_pie))) *
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
            } else {
                $fraccion = 1;
                // Días intermedios: fracción completa (1)
                $piezas = ($fraccion * 24) * $Std_Hr_efectivo;
                $kilos = round(($piezas * $Prod_Kg_Dia) / ($Std_Hr_efectivo * 24), 2);
                $cambio = $Cambios_Hilo; //si Cambios_Hilo = 1, asignamos 1
                $rizo = 0; // Valor por defecto
                if ($aplic === 'RZ') {
                    $rizo = 1 * $kilos;
                } elseif ($aplic === 'RZ2') {
                    $rizo = 2 * $kilos;
                } elseif ($aplic === 'RZ3') {
                    $rizo = 3 * $kilos;
                } elseif ($aplic === 'BOR') {
                    $rizo = 1 * $kilos;
                } elseif ($aplic === 'EST') {
                    $rizo = 1 * $kilos;
                } elseif ($aplic === 'DC') {
                    $rizo = 1 * $kilos;
                }

                $TRAMA = ((((0.59 * ((($modelo->PASADAS_1 * 1.001) * $ancho_por_toalla) / 100)) / (float) $request->input('trama_0')) * $piezas) / 1000);

                $combinacion1 =   ((((0.59 * (((float)$modelo->PASADAS_2 * 1.001) * $ancho_por_toalla)) / 100) / ((float) $request->input('calibre_1') != 0 ? (float) $request->input('calibre_1')   : 1)) * $piezas) / 1000;
                $combinacion2 =   ((((0.59 * (((float)$modelo->PASADAS_3 * 1.001) * $ancho_por_toalla)) / 100) / ((float) $request->input('calibre_2') != 0 ? (float) $request->input('calibre_2') : 1)) * $piezas) / 1000;
                $combinacion3 =   ((((0.59 * (((float)$modelo->PASADAS_4 * 1.001) * $ancho_por_toalla)) / 100) / ((float) $request->input('calibre_3') != 0 ? (float) $request->input('calibre_3') : 1)) * $piezas) / 1000;
                $combinacion4 =   ((((0.59 * (((float)$modelo->PASADAS_5 * 1.001) * $ancho_por_toalla)) / 100) / ((float) $request->input('calibre_4') != 0 ? (float) $request->input('calibre_4') : 1)) * $piezas) / 1000;

                $Piel1 = ((((((((float) $modelo->Largo + (float) $modelo->Med_plano) / 100) * 1.055) * 0.00059) / ((0.00059 * 1) / (0.00059 / $calibre_pie))) *
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
        // AHORA VAMOS CON LAS FORMULAS RESTANTES;
        //dd([
        //    'dias:' => $dias,
        //]);

        // --- Actualizar el registro principal ---
        $registro->Cuenta = (float) $request->input('cuenta_rizo');
        $registro->Salon = $telar ? $telar->salon : null;
        $registro->Telar  = (float) $telares[$i];
        $registro->Ultimo = 'ULTIMO';
        $registro->Cambios_Hilo = null;
        $registro->Maquina = $telar ? $telar->nombre : null;
        $registro->Ancho = $modelo ? (int) $modelo->Ancho : null;
        $registro->Eficiencia_Std = (float) $eficiencia;
        $registro->Velocidad_STD = (float) $velocidad;
        $registro->Hilo = $request->input('hilo');
        $registro->Calibre_Rizo = $calibre_rizo ? (float) $calibre_rizo : null;
        $registro->Calibre_Pie = $calibre_pie ? (float) $calibre_pie : null;
        $registro->Calendario = $request->input('calendario');
        $registro->Clave_AX = $request->input('clave_ax');
        $registro->Clave_Estilo = $request->input('tamano') . $request->input('clave_ax');
        $registro->Tamano_AX = $request->input('tamano');
        $registro->Estilo_Alternativo = null;
        $registro->Nombre_Producto = $modelo ? $modelo->Modelo : null;
        $registro->Saldos = (float) $saldos[$i];
        // NO cambies Fecha_Captura, solo al crear
        $registro->Orden_Prod = null;
        $registro->Fecha_Liberacion = null;
        $registro->Id_Flog = $request->input('no_flog');
        $registro->Descrip = $request->input('descripcion');
        $registro->Aplic = $request->input('aplicacion');
        $registro->Obs = null;
        $registro->Tipo_Ped = explode('-', $request->input('no_flog'))[0];
        $registro->Tiras = $modelo ? (int)$modelo->TIRAS : null;
        $registro->Peine = $modelo ? (int)$modelo->Peine : null;
        $registro->Largo_Crudo = $modelo ? (float) $modelo->Largo : null;
        $registro->Peso_Crudo = $modelo->P_crudo ? (int) $modelo->P_crudo : null;
        $registro->Luchaje = $modelo ? (int)$modelo->Luchaje : null;
        $registro->CALIBRE_TRA = (float) $request->input('trama_0');
        $registro->Dobladillo = $modelo ? $modelo->Tipo_plano : null;
        $registro->PASADAS_TRAMA = $modelo ? (int) $modelo->PASADAS : null;
        $registro->PASADAS_C1 = $modelo ? (int)$modelo->PASADAS_C1 : null;
        $registro->PASADAS_C2 = $modelo ? (int)$modelo->PASADAS_C2 : null;
        $registro->PASADAS_C3 = $modelo ? (int)$modelo->PASADAS_C3 : null;
        $registro->PASADAS_C4 = $modelo ? (int)$modelo->PASADAS_C4 : null;
        $registro->PASADAS_C5 = $modelo ? (int)$modelo->X : null;
        $registro->ancho_por_toalla = $modelo ? (float) $ancho_por_toalla : null;
        $registro->COLOR_TRAMA = $modelo ? $modelo->OBS_R1 : null;
        $registro->CALIBRE_C1 = (float)$request->input('calibre_1');
        $registro->Clave_Color_C1 = null;
        $registro->COLOR_C1 = $request->input('color_1');
        $registro->CALIBRE_C2 = (float)$request->input('calibre_2');
        $registro->Clave_Color_C2 = null;
        $registro->COLOR_C2 = $request->input('color_2');
        $registro->CALIBRE_C3 = (float)$request->input('calibre_3');
        $registro->Clave_Color_C3 = null;
        $registro->COLOR_C3 = $request->input('color_3');
        $registro->CALIBRE_C4 = (float)$request->input('calibre_4');
        $registro->Clave_Color_C4 = null;
        $registro->COLOR_C4 = $request->input('color_4');
        $registro->CALIBRE_C5 = (float)$request->input('calibre_5');
        $registro->Clave_Color_C5 = null;
        $registro->COLOR_C5 = $request->input('color_5');
        $registro->Plano = $modelo ? (int) $modelo->Med_plano : null;
        $registro->Cuenta_Pie = (float) $request->input('cuenta_pie');
        $registro->Clave_Color_Pie = null;
        $registro->Color_Pie = null;
        $registro->Peso_gr_m2 = is_numeric($Peso_gr_m2) ? number_format((float) str_replace(',', '.', $Peso_gr_m2), 2, '.', '') : null;
        $registro->Dias_Ef = is_numeric($Dias_Ef) ? number_format((float) str_replace(',', '.', $Dias_Ef), 2, '.', '') : null;
        $registro->Prod_Kg_Dia = is_numeric(str_replace(',', '.', $Prod_Kg_Dia1)) ? number_format((float) str_replace(',', '.', $Prod_Kg_Dia1), 2, '.', '') : null;
        $registro->Std_Dia = is_numeric($Std_Dia) ? number_format((float) str_replace(',', '.', $Std_Dia), 2, '.', '') : null;
        $registro->Prod_Kg_Dia1 = is_numeric($Prod_Kg_Dia) ? number_format((float) str_replace(',', '.', $Prod_Kg_Dia), 2, '.', '') : null;
        $registro->Std_Toa_Hr_100 = is_numeric(str_replace(',', '.', $Std_Toa_Hr_100)) ? number_format((float) str_replace(',', '.', $Std_Toa_Hr_100), 2, '.', '') : null;
        $registro->Dias_jornada_completa = is_numeric(str_replace(',', '.', $Dias_jornada_completa)) ? number_format((float) str_replace(',', '.', $Dias_jornada_completa), 2, '.', '') : null;
        $registro->Horas = $this->cleanDecimal($Horas);
        $registro->Std_Hr_efectivo = $this->cleanDecimal($Std_Hr_efectivo);
        $registro->Inicio_Tejido = Carbon::parse($inicio)->format('Y-m-d H:i:s');
        $registro->Calc4 = null;
        $registro->Calc5 = null;
        $registro->Calc6 = null;
        $registro->Fin_Tejido = Carbon::parse($fin)->format('Y-m-d H:i:s');
        $registro->Fecha_Compromiso = null;
        $registro->Fecha_Compromiso1 = null;
        $registro->Entrega = null;
        $registro->Dif_vs_Compromiso = null;
        $registro->cantidad = (float) $saldos[$i];

        $registro->save();

        // --- Elimina movimientos anteriores ---
        \App\Models\TipoMovimientos::where('tej_num', $registro->id)->delete();

        // --- Inserta los nuevos movimientos (igual que en store) ---
        foreach ($dias as $registroDia) {
            \App\Models\TipoMovimientos::create([
                'fecha_inicio'   => $Fechainicio,
                'fecha_fin'      => $Fechafin,
                'fecha'          => Carbon::createFromFormat('Y-m-d', $registroDia['fecha'])->toDateString(),
                'fraccion_dia'   => $registroDia['fraccion_dia'],
                'pzas'           => $registroDia['piezas'],
                'kilos'          => $registroDia['kilos'],
                'rizo'           => $registroDia['rizo'],
                'cambio'         => $registroDia['cambio'],
                'trama'          => $registroDia['trama'],
                'combinacion1'   => $registroDia['combinacion1'],
                'combinacion2'   => $registroDia['combinacion2'],
                'combinacion3'   => $registroDia['combinacion3'],
                'combinacion4'   => $registroDia['combinacion4'],
                'piel1'          => $registroDia['piel1'],
                'riso'           => $registroDia['riso'],
                'tej_num'        => $registro->id,
            ]);
        }

        return redirect()->route('planeacion.index')->with('success', 'Registro actualizado correctamente');
    }

    public function moverRegistro(Request $request)
    {
        $id = (int) $request->input('id');
        $telar = (int) $request->input('telar');
        $accion = $request->input('accion'); // 'arriba' o 'abajo'

        $registroActual = Planeacion::findOrFail($id);

        // Obtén todos los registros del mismo telar, ordenados por 'orden'
        $registros = Planeacion::where('Telar', $telar)
            ->orderBy('orden')
            ->get();

        $index = $registros->search(function ($item) use ($id) {
            return $item->id == $id;
        });

        if ($index === false) {
            return response()->json(['ok' => false, 'error' => 'No se encontró el registro.']);
        }

        if ($accion == 'arriba' && $index > 0) {
            $otro = $registros[$index - 1];
        } elseif ($accion == 'abajo' && $index < ($registros->count() - 1)) {
            $otro = $registros[$index + 1];
        } else {
            return response()->json(['ok' => false, 'error' => 'No se puede mover más.']);
        }

        // Intercambiar los valores de 'orden'
        DB::beginTransaction();
        try {
            $tmpOrden = $registroActual->orden;
            $registroActual->orden = $otro->orden;
            $otro->orden = $tmpOrden;

            $registroActual->save();
            $otro->save();

            DB::commit();
            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['ok' => false, 'error' => $e->getMessage()]);
        }
    }

    // MOSTRAMOS VISTA PARA PLAN DE VENTAS, RECUPERAMOS DATA DE LA BD DE TI_PRO
    public function showBlade(Request $request)
    {
        // Si NO hay filtros, limpia la sesión y NO uses filtros para la consulta
        if (!$request->has('column') && !$request->has('value')) {
            session()->forget('filtros_busqueda');
            $columns = [];
            $values = [];
        } else {
            // Si hay filtros en request, guárdalos
            if ($request->has('column') && $request->has('value')) {
                session()->put('filtros_busqueda', [
                    'column' => $request->input('column', []),
                    'value' => $request->input('value', [])
                ]);
            }
            // Usa filtros de request
            $columns = $request->input('column', []);
            $values = $request->input('value', []);
        }

        // Tu consulta aquí, usando SOLO $columns y $values

        try {
            $query = DB::connection('sqlsrv_ti')
                ->table('TI_PRO.dbo.TWFLOGSITEMLINE as l')
                ->join('TI_PRO.dbo.TWFLOGSTABLE as f', 'l.IDFLOG', '=', 'f.IDFLOG')
                ->select(
                    'f.IDFLOG',
                    'f.ESTADOFLOG',
                    'f.NAMEPROYECT',
                    'f.CUSTNAME',
                    DB::raw('MAX(l.ANCHO) as ANCHO'),
                    DB::raw('MAX(l.ITEMID) as ITEMID'),
                    DB::raw('MAX(l.ITEMNAME) as ITEMNAME'),
                    DB::raw('MAX(l.INVENTSIZEID) as INVENTSIZEID'),
                    DB::raw('MAX(l.TIPOHILOID) as TIPOHILOID'),
                    DB::raw('MAX(l.VALORAGREGADO) as VALORAGREGADO'),
                    DB::raw('MAX(l.FECHACANCELACION) as FECHACANCELACION'),
                    DB::raw('SUM(l.PORENTREGAR) as PORENTREGAR'),
                    DB::raw('MAX(l.RASURADOCRUDO) as RASURADOCRUDO')
                )
                ->where('f.ESTADOFLOG', 4)
                ->where('f.TIPOPEDIDO', 1)
                ->where('l.ESTADOLINEA', 0)
                ->where('l.PORENTREGAR', '!=', 0);

            // Aplica filtros si los hay
            foreach ($columns as $i => $col) {
                $val = $values[$i] ?? null;
                if ($col && $val) {
                    $query->where($col, 'LIKE', '%' . $val . '%');
                }
            }

            $lineasConFlog = $query
                ->groupBy('f.IDFLOG', 'f.ESTADOFLOG', 'f.NAMEPROYECT', 'f.CUSTNAME')
                ->orderBy('FECHACANCELACION')
                ->get();


            // 👇 esto es para el modal
            $headers = [
                'f.IDFLOG'          => 'ID FLOG',
                'f.ESTADOFLOG'      => 'Estado FLOG',
                'f.NAMEPROYECT'     => 'Proyecto',
                'f.CUSTNAME'        => 'Nombre del Cliente',
                'l.ANCHO'           => 'Ancho',
                'l.ITEMID'          => 'Artículo',
                'l.ITEMNAME'        => 'Nombre',
                'l.INVENTSIZEID'    => 'Tamaño',
                'l.TIPOHILOID'      => 'Tipo de Hilo',
                'l.VALORAGREGADO'   => 'Valor Agregado',
                'l.FECHACANCELACION' => 'Cancelación',
                'l.PORENTREGAR'     => 'Cantidad',
            ];

            return view('TEJIDO-SCHEDULING.ventas', compact('lineasConFlog', 'headers'));
        } catch (\Exception $e) {
            // Redirige a la misma vista pero con mensaje de error
            return redirect()->back()->with('error', 'Ocurrió un error al cargar los datos: ' . $e->getMessage());
        }
    }
}
