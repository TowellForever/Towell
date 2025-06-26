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

        function fecha_a_excel_serial($fecha)
        {
            // Fecha base en Excel: 1899-12-30
            $excelBase = strtotime('1899-12-30 00:00:00');
            $timestamp = strtotime($fecha);
            return ($timestamp - $excelBase) / 86400;
        }

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
        $datos = $request->query(); // datos por URL
        return view('TEJIDO-SCHEDULING.edit', compact('datos'));
    }
}
