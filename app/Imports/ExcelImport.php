<?php

namespace App\Imports;

use App\Models\Modelos;
use App\Models\Planeacion;
use App\Models\TipoMovimientos;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;


// Función auxiliar para divisiones seguras (no divide entre 0 ni null)
function safeDivide($a, $b, $default = 0)
{
    if (is_numeric($a) && is_numeric($b) && $b != 0) {
        return $a / $b;
    }
    return $default;
}

// Función auxiliar para números seguros
function safeNumber($value, $decimales = 10)
{
    return number_format(floatval($value), $decimales, '.', '');
}
function formatExcelDate($value)
{
    if ($value === '?' || $value === '' || $value === null) {
        return null;
    }
    // Si viene como número (fecha Excel)
    if (is_numeric($value)) {
        try {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }
    // Si viene como string fecha válida
    if (strtotime($value)) {
        return date('Y-m-d H:i:s', strtotime($value));
    }
    // Si no es válido, regresa null
    return null;
}

function formatNumber($value)
{
    if ($value === '?' || $value === '' || $value === null) {
        return null;
    }
    // Quita comas por si vienen de Excel tipo "1,234.56"
    $value = str_replace(',', '', trim($value));
    return is_numeric($value) ? floatval($value) : null;
}

class ExcelImport implements ToModel
{
    public function model(array $row)
    {
        // Asigna todo igual pero limpia fechas y números

        $cuenta               = formatNumber($row[0] ?? null);
        $salon                = $row[1] ?? null;
        $telar                = formatNumber($row[2] ?? null);
        $ultimo               = $row[3] ?? null;
        $cambios_hilo         = $row[4] ?? 0;
        $maquina              = $row[5] ?? null;
        $ancho                = formatNumber($row[6] ?? null);
        $eficiencia_std       = formatNumber($row[7] ?? null);
        $velocidad_std        = formatNumber($row[8] ?? null);
        $hilo                 = $row[9] ?? null;
        $calibre_pie          = formatNumber($row[10] ?? null);
        $calendario           = $row[11] ?? null;
        $clave_estilo         = $row[12] ?? null;
        $no_existe            = $row[13] ?? null;
        $nombre_producto      = $row[14] ?? null;
        $saldos               = formatNumber($row[15] ?? null);
        $fecha_captura        = formatExcelDate($row[16] ?? null);
        $orden_prod           = formatNumber($row[17] ?? null);
        $inn                  = formatExcelDate($row[18] ?? null); // Si es fecha, usa formatExcelDate, pero parece ID, confírmame si es fecha o número
        $descrip              = $row[19] ?? null;
        $aplic                = $row[20] ?? null;
        $obs                  = $row[21] ?? null;
        $tipo_ped             = $row[22] ?? null;
        $tiras                = formatNumber($row[23] ?? null);
        $peine                = formatNumber($row[24] ?? null);
        $largo_crudo          = formatNumber($row[25] ?? null);
        $peso_crudo           = formatNumber($row[26] ?? null);
        $luchaje              = formatNumber($row[27] ?? null);
        $calibre_tra          = formatNumber($row[28] ?? null);
        $dobladillo           = $row[29] ?? null;
        $pasadas_trama        = formatNumber($row[30] ?? null);
        $pasadas_c1           = formatNumber($row[31] ?? null);
        $pasadas_c2           = formatNumber($row[32] ?? null);
        $pasadas_c3           = formatNumber($row[33] ?? null);
        $pasadas_c4           = formatNumber($row[34] ?? null);
        $pasadas_c5           = formatNumber($row[35] ?? null);
        $ancho_por_toalla     = formatNumber($row[36] ?? null);
        $color_trama          = $row[37] ?? null;
        $calibre_c1           = formatNumber($row[38] ?? null);
        $color_c1             = $row[39] ?? null;
        $calibre_c2           = formatNumber($row[40] ?? null);
        $color_c2             = $row[41] ?? null;
        $calibre_c3           = formatNumber($row[42] ?? null);
        $color_c3             = $row[43] ?? null;
        $calibre_c4           = formatNumber($row[44] ?? null);
        $color_c4             = $row[45] ?? null;
        $calibre_c5           = formatNumber($row[46] ?? null);
        $color_c5             = $row[47] ?? null;
        $plano                = formatNumber($row[48] ?? null);
        $cuenta_pie           = formatNumber($row[49] ?? null);
        $color_pie            = formatNumber($row[50] ?? null); // Si es número, si no, quita el formatNumber
        $peso_gr_m2           = formatNumber($row[51] ?? null);
        $dias_ef              = formatNumber($row[52] ?? null);
        $prod_kg_dia          = formatNumber($row[53] ?? null);
        $std_dia              = formatNumber($row[54] ?? null);
        $prod_kg_dia1         = formatNumber($row[55] ?? null);
        $std_toa_hr_100       = formatNumber($row[56] ?? null);
        $dias_jornada_completa = formatNumber($row[57] ?? null);
        $horas                = formatNumber($row[58] ?? null);
        $std_hr_efectivo      = formatNumber($row[59] ?? null);
        $inicio_tejido        = formatExcelDate($row[60] ?? null);
        $calc4                = formatNumber($row[61] ?? null);
        $calc5                = formatNumber($row[62] ?? null);
        $calc6                = formatNumber($row[63] ?? null);
        $fin_tejido           = formatExcelDate($row[64] ?? null);
        $fecha_compromiso     = formatExcelDate($row[65] ?? null);
        $fecha_compromiso1    = formatExcelDate($row[66] ?? null);
        $entrega              = formatExcelDate($row[67] ?? null);
        $dif_vs_compromiso    = formatNumber($row[68] ?? null);

        //Define el array de variables a castear:
        $floatVars = [
            'cuenta',
            'telar',
            'ancho',
            'eficiencia_std',
            'velocidad_std',
            'calibre_pie',
            'saldos',
            'orden_prod',
            'tiras',
            'peine',
            'largo_crudo',
            'peso_crudo',
            'luchaje',
            'calibre_tra',
            'pasadas_trama',
            'pasadas_c1',
            'pasadas_c2',
            'pasadas_c3',
            'pasadas_c4',
            'pasadas_c5',
            'ancho_por_toalla',
            'calibre_c1',
            'calibre_c2',
            'calibre_c3',
            'calibre_c4',
            'calibre_c5',
            'plano',
            'cuenta_pie',
            'color_pie',
            'peso_gr_m2',
            'dias_ef',
            'prod_kg_dia',
            'std_dia',
            'prod_kg_dia1',
            'std_toa_hr_100',
            'dias_jornada_completa',
            'horas',
            'std_hr_efectivo',
            'calc4',
            'calc5',
            'calc6',
            'dif_vs_compromiso'
        ];

        foreach ($floatVars as $var) {
            if (isset($$var) && $$var !== null && $$var !== '') {
                $$var = floatval(str_replace(',', '', $$var)); // Limpia comas por si vienen de excel tipo "1,234.56"
            }
        }

        // Ejemplo: $clave_estilo = "AB1234"
        if (preg_match('/^([A-Za-z]{1,3})[A-Za-z]*(\d+)$/', $clave_estilo, $matches)) {
            $tamanio_ax = (string) $matches[1]; // Solo las 3 primeras letras iniciales
            $clave_ax   = $matches[2];          // Todos los números que sigan
        } else {
            $tamanio_ax = null;
            $clave_ax   = null;
        }

        /*
            "$tamanio_ax" => "PULLMAN"
            "$clave_ax" => "7248"
            "$$salon" => "JACQUARD"
        */

        // Buscar el modelo de forma segura
        $modelo = \App\Models\Modelos::where('CLAVE_AX', $clave_ax)
            ->where('Tamanio_AX', $tamanio_ax)
            ->where('Departamento', $salon)
            ->first();

        // 2. Crear el registro principal de forma segura
        $nuevoRegistro = \App\Models\Planeacion::create([
            'Cuenta'                => $cuenta ?? null,
            'Salon'                 => $salon ?? null,
            'Telar'                 => $telar ?? null,
            'Ultimo'                => $ultimo ?? null,
            'Cambios_Hilo'          => $cambios_hilo ?? null,
            'Maquina'               => $maquina ?? null,
            'Ancho'                 => $ancho ?? null,
            'Eficiencia_Std'        => $eficiencia_std ?? null,
            'Velocidad_STD'         => $velocidad_std ?? null,
            'Hilo'                  => $hilo ?? null,
            'Calibre_Pie'           => $calibre_pie ?? null,
            'Calendario'            => $calendario ?? null,
            'Clave_Estilo'          => $clave_estilo ?? null,
            'Clave_AX'              =>  $clave_ax  ?? null,
            'Tamano_AX'             => $tamanio_ax  ?? null,
            'Estilo_Alternativo'    =>  null,
            'Nombre_Producto'       => $nombre_producto ?? null,
            'Saldos'                => $saldos ?? null,
            'Fecha_Captura'         => $fecha_captura ?? null,
            'Orden_Prod'            => $orden_prod ?? null,
            'Fecha_Liberacion'      =>  null,
            'Id_Flog'               =>  null,
            'Descrip'               => $descrip ?? null,
            'Aplic'                 => $aplic ?? null,
            'Obs'                   => $obs ?? null,
            'Tipo_Ped'              => $tipo_ped ?? null,
            'Tiras'                 => $tiras ?? null,
            'Peine'                 => $peine ?? null,
            'Largo_Crudo'           => $largo_crudo ?? null,
            'Peso_Crudo'            => $peso_crudo ?? null,
            'Luchaje'               => $luchaje ?? null,
            'CALIBRE_TRA'           => $calibre_tra ?? null,
            'Dobladillo'            => $dobladillo ?? null,
            'PASADAS_TRAMA'         => $pasadas_trama ?? null,
            'PASADAS_C1'            => $pasadas_c1 ?? null,
            'PASADAS_C2'            => $pasadas_c2 ?? null,
            'PASADAS_C3'            => $pasadas_c3 ?? null,
            'PASADAS_C4'            => $pasadas_c4 ?? null,
            'PASADAS_C5'            => $pasadas_c5 ?? null,
            'ancho_por_toalla'      => $ancho_por_toalla ?? null,
            'COLOR_TRAMA'           => $color_trama ?? null,
            'CALIBRE_C1'            => $calibre_c1 ?? null,
            'Clave_Color_C1'        =>  null,
            'COLOR_C1'              => $color_c1 ?? null,
            'CALIBRE_C2'            => $calibre_c2 ?? null,
            'Clave_Color_C2'        =>  null,
            'COLOR_C2'              => $color_c2 ?? null,
            'CALIBRE_C3'            => $calibre_c3 ?? null,
            'Clave_Color_C3'        =>   null,
            'COLOR_C3'              => $color_c3 ?? null,
            'CALIBRE_C4'            => $calibre_c4 ?? null,
            'Clave_Color_C4'        =>  null,
            'COLOR_C4'              => $color_c4 ?? null,
            'CALIBRE_C5'            => $calibre_c5 ?? null,
            'Clave_Color_C5'        =>   null,
            'COLOR_C5'              => $color_c5 ?? null,
            'Plano'                 => $plano ?? null,
            'Cuenta_Pie'            => $cuenta_pie ?? null,
            'Clave_Color_Pie'       =>   null,
            'Color_Pie'             => $color_pie ?? null,
            'Peso_gr_m2'            => $peso_gr_m2 ?? null,
            'Dias_Ef'               => $dias_ef ?? null,
            'Prod_Kg_Dia'           => $prod_kg_dia ?? null,
            'Std_Dia'               => $std_dia ?? null,
            'Prod_Kg_Dia1'          => $prod_kg_dia1 ?? null,
            'Std_Toa_Hr_100'        => $std_toa_hr_100 ?? null,
            'Dias_jornada_completa' => $dias_jornada_completa ?? null,
            'Horas'                 => $horas ?? null,
            'Std_Hr_efectivo'       => $std_hr_efectivo ?? null,
            'Inicio_Tejido'         => $inicio_tejido ?? null,
            'Calc4'                 => $calc4 ?? null,
            'Calc5'                 => $calc5 ?? null,
            'Calc6'                 => $calc6 ?? null,
            'Fin_Tejido'            => $fin_tejido ?? null,
            'Fecha_Compromiso'      => $fecha_compromiso ?? null,
            'Fecha_Compromiso1'     => $fecha_compromiso1 ?? null,
            'Entrega'               => $entrega ?? null,
            'Dif_vs_Compromiso'     => $dif_vs_compromiso ?? null,
        ]);

        $tejNum = $nuevoRegistro->id;


        // Fechas protegidas (si alguna es null o inválida, usa now)
        try {
            $fechaInicio = $nuevoRegistro->Inicio_Tejido ?? now();
            $fechaFin = $nuevoRegistro->Fin_Tejido ?? now();
            $fechaInicioCarbon = Carbon::parse($fechaInicio);
            $fechaFinCarbon = Carbon::parse($fechaFin);
        } catch (\Exception $e) {
            $fechaInicioCarbon = now();
            $fechaFinCarbon = now();
        }

        $periodo = CarbonPeriod::create(
            $fechaInicioCarbon->copy()->startOfDay(),
            $fechaFinCarbon->copy()->endOfDay()
        );

        $dias = [];
        $aplic = $nuevoRegistro->Aplic ?? '';
        $ancho_por_toalla = safeNumber($nuevoRegistro->ancho_por_toalla ?? 1);
        $Std_Hr_efectivo = safeNumber($nuevoRegistro->Std_Hr_efectivo ?? 1);
        $Prod_Kg_Dia = safeNumber($nuevoRegistro->Prod_Kg_Dia ?? 1);
        $Cambios_Hilo = safeNumber($nuevoRegistro->Cambios_Hilo ?? 1);

        // Buscar el modelo de forma segura
        $modelo = \App\Models\Modelos::where('CLAVE_AX', (string) $nuevoRegistro->Clave_AX)
            ->where('Tamanio_AX', $nuevoRegistro->Tamano_AX)
            ->where('Departamento', $nuevoRegistro->Salon)
            ->first();

        // Si no existe el modelo, crea uno "falso"
        if (!$modelo) {
            $modelo = new \stdClass();
            $modelo->PASADAS_1 = 1;
            $modelo->PASADAS_2 = 1;
            $modelo->PASADAS_3 = 1;
            $modelo->PASADAS_4 = 1;
            $modelo->PASADAS_5 = 1;
            $modelo->Med_plano = 1;
            $modelo->TIRAS = 1;
            $modelo->Largo = 1;
        }
        if (!$nuevoRegistro->CALIBRE_C1) $nuevoRegistro->CALIBRE_C1 = 1;
        if (!$nuevoRegistro->CALIBRE_C2) $nuevoRegistro->CALIBRE_C2 = 1;
        if (!$nuevoRegistro->CALIBRE_C3) $nuevoRegistro->CALIBRE_C3 = 1;
        if (!$nuevoRegistro->CALIBRE_C4) $nuevoRegistro->CALIBRE_C4 = 1;
        if (!$nuevoRegistro->Cuenta_Pie)  $nuevoRegistro->Cuenta_Pie = 32; // mínimo seguro
        if (!$calibre_tra)                $calibre_tra = 1;
        if (!$calibre_pie)                $calibre_pie = 1;


        $totalDias = 0;

        //INICIAMOS LOS CALCULOS DE ACUERDO A LAS FORMULAS DE ARCHIVO EXCEL DE PEPE OWNER
        foreach ($periodo as $index => $dia) {
            $inicioDia = $dia->copy()->startOfDay();
            $finDia = $dia->copy()->endOfDay();

            // Calcular la fracción para el primer y segundo día
            if ($index === 0) {
                $inicio = strtotime($fechaInicioCarbon);
                $fin = strtotime($fechaFinCarbon);

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

                $TRAMA = ((((0.59 * safeDivide((($modelo->PASADAS_1 * 1.001) * $ancho_por_toalla), 100)) / (float)$calibre_tra) * $piezas) / 1000);

                $combinacion1 = ((((0.59 * safeDivide((((float)$modelo->PASADAS_2 * 1.001) * $ancho_por_toalla), 100)) / safeDivide((float) $nuevoRegistro->CALIBRE_C1, 1)) * $piezas) / 1000);
                $combinacion2 = ((((0.59 * safeDivide((((float)$modelo->PASADAS_3 * 1.001) * $ancho_por_toalla), 100)) / safeDivide((float) $nuevoRegistro->CALIBRE_C2, 1)) * $piezas) / 1000);
                $combinacion3 = ((((0.59 * safeDivide((((float)$modelo->PASADAS_4 * 1.001) * $ancho_por_toalla), 100)) / safeDivide((float) $nuevoRegistro->CALIBRE_C3, 1)) * $piezas) / 1000);
                $combinacion4 = ((((0.59 * safeDivide((((float)$modelo->PASADAS_5 * 1.001) * $ancho_por_toalla), 100)) / safeDivide((float) $nuevoRegistro->CALIBRE_C4, 1)) * $piezas) / 1000);

                $Piel1 = ((((((((float) $modelo->Largo + (float) $modelo->Med_plano) / 100) * 1.055) * 0.00059) /
                    safeDivide((0.00059 * 1), safeDivide(0.00059, $calibre_pie))) *
                    safeDivide(((float) $nuevoRegistro->Cuenta_Pie - 32), (float) $modelo->TIRAS)) * $piezas);

                $riso = ($kilos - ($Piel1 + $combinacion3 + $combinacion2 + $combinacion1 + $TRAMA + $combinacion4));

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
            } elseif ($dia->isSameDay($fechaFinCarbon)) {

                // Último día: calcular la fracción desde 00:00 hasta la hora fin
                $realInicio = $inicioDia;
                $realFin = $fechaFinCarbon;
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
                $TRAMA = ((((0.59 * safeDivide((($modelo->PASADAS_1 * 1.001) * $ancho_por_toalla), 100)) / (float)$calibre_tra) * $piezas) / 1000);

                $combinacion1 = ((((0.59 * safeDivide((((float)$modelo->PASADAS_2 * 1.001) * $ancho_por_toalla), 100)) / safeDivide((float) $nuevoRegistro->CALIBRE_C1, 1)) * $piezas) / 1000);
                $combinacion2 = ((((0.59 * safeDivide((((float)$modelo->PASADAS_3 * 1.001) * $ancho_por_toalla), 100)) / safeDivide((float) $nuevoRegistro->CALIBRE_C2, 1)) * $piezas) / 1000);
                $combinacion3 = ((((0.59 * safeDivide((((float)$modelo->PASADAS_4 * 1.001) * $ancho_por_toalla), 100)) / safeDivide((float) $nuevoRegistro->CALIBRE_C3, 1)) * $piezas) / 1000);
                $combinacion4 = ((((0.59 * safeDivide((((float)$modelo->PASADAS_5 * 1.001) * $ancho_por_toalla), 100)) / safeDivide((float) $nuevoRegistro->CALIBRE_C4, 1)) * $piezas) / 1000);

                $Piel1 = ((((((((float) $modelo->Largo + (float) $modelo->Med_plano) / 100) * 1.055) * 0.00059) /
                    safeDivide((0.00059 * 1), safeDivide(0.00059, $calibre_pie))) *
                    safeDivide(((float) $nuevoRegistro->Cuenta_Pie - 32), (float) $modelo->TIRAS)) * $piezas);

                $riso = ($kilos - ($Piel1 + $combinacion3 + $combinacion2 + $combinacion1 + $TRAMA + $combinacion4));
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

                $TRAMA = ((((0.59 * safeDivide((($modelo->PASADAS_1 * 1.001) * $ancho_por_toalla), 100)) / (float)$calibre_tra) * $piezas) / 1000);

                $combinacion1 = ((((0.59 * safeDivide((((float)$modelo->PASADAS_2 * 1.001) * $ancho_por_toalla), 100)) / safeDivide((float) $nuevoRegistro->CALIBRE_C1, 1)) * $piezas) / 1000);
                $combinacion2 = ((((0.59 * safeDivide((((float)$modelo->PASADAS_3 * 1.001) * $ancho_por_toalla), 100)) / safeDivide((float) $nuevoRegistro->CALIBRE_C2, 1)) * $piezas) / 1000);
                $combinacion3 = ((((0.59 * safeDivide((((float)$modelo->PASADAS_4 * 1.001) * $ancho_por_toalla), 100)) / safeDivide((float) $nuevoRegistro->CALIBRE_C3, 1)) * $piezas) / 1000);
                $combinacion4 = ((((0.59 * safeDivide((((float)$modelo->PASADAS_5 * 1.001) * $ancho_por_toalla), 100)) / safeDivide((float) $nuevoRegistro->CALIBRE_C4, 1)) * $piezas) / 1000);

                $Piel1 = ((((((((float) $modelo->Largo + (float) $modelo->Med_plano) / 100) * 1.055) * 0.00059) /
                    safeDivide((0.00059 * 1), safeDivide(0.00059, $calibre_pie))) *
                    safeDivide(((float) $nuevoRegistro->Cuenta_Pie - 32), (float) $modelo->TIRAS)) * $piezas);

                $riso = ($kilos - ($Piel1 + $combinacion3 + $combinacion2 + $combinacion1 + $TRAMA + $combinacion4));

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

        //dd([
        //  'dias:' => $dias,
        //]);

        foreach ($dias as $registro) {
            \App\Models\TipoMovimientos::create([
                'fecha_inicio'    => $fechaInicioCarbon,
                'fecha_fin'       => $fechaFinCarbon,
                'fecha'           => $registro['fecha'],
                'fraccion_dia'    => safeNumber($registro['fraccion_dia'] ?? 0),
                'pzas'            => safeNumber($registro['piezas'] ?? 0),
                'kilos'           => safeNumber($registro['kilos'] ?? 0),
                'rizo'            => safeNumber($registro['rizo'] ?? 0),
                'cambio'          => safeNumber($registro['cambio'] ?? 0),
                'trama'           => safeNumber($registro['trama'] ?? 0),
                'combinacion1'    => safeNumber($registro['combinacion1'] ?? 0),
                'combinacion2'    => safeNumber($registro['combinacion2'] ?? 0),
                'combinacion3'    => safeNumber($registro['combinacion3'] ?? 0),
                'combinacion4'    => safeNumber($registro['combinacion4'] ?? 0),
                'piel1'           => safeNumber($registro['piel1'] ?? 0),
                'riso'            => safeNumber($registro['riso'] ?? 0),
                'tej_num'         => $tejNum,
            ]);
        }


        return $nuevoRegistro;
    }
}
