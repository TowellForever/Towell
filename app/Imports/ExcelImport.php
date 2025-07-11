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
function safeNumber($value, $default = 0)
{
    return is_numeric($value) ? $value : $default;
}

class ExcelImport implements ToModel
{
    public function model(array $row)
    {
        //guardo los datos de EXCEL en variables
        $cuenta               = $row[0] ?? null;
        $salon                = $row[1] ?? null;
        $telar                = $row[2] ?? null;
        $ultimo               = $row[3] ?? null;
        $cambios_hilo         = $row[4] ?? null;        // Cambios Hilo
        $maquina              = $row[5] ?? null;        // Maq
        $ancho                = $row[6] ?? null;
        $eficiencia_std       = $row[7] ?? null;        // Ef Std
        $velocidad_std        = $row[8] ?? null;        // Vel
        $hilo                 = $row[9] ?? null;
        $calibre_pie          = $row[10] ?? null;
        $calendario           = $row[11] ?? null;       // Jornada → Calendario (asignación sugerida)
        $clave_estilo         = $row[12] ?? null;       // Clave mod. → Clave_Estilo (asignación sugerida) TAMAÑO_AX + CLAVE_AX
        $no_existe            = $row[13] ?? null;       //Usar cuando no existe en base
        $nombre_producto      = $row[14] ?? null;       // Producto → Nombre_Producto
        $saldos               = $row[15] ?? null;
        $fecha_captura        = $row[16] ?? null;       // Day Sheduling → Fecha_Captura (si es fecha, puedes formatearla)
        $orden_prod           = $row[17] ?? null;       // Orden Prod.
        $inn                  = $row[18] ?? null;       // INN → Id_Flog
        $descrip              = $row[19] ?? null;
        $aplic                = $row[20] ?? null;
        $obs                  = $row[21] ?? null;
        $tipo_ped             = $row[22] ?? null;
        $tiras                = $row[23] ?? null;
        $peine                = $row[24] ?? null;       // Pei.
        $largo_crudo          = $row[25] ?? null;       // Lcr
        $peso_crudo           = $row[26] ?? null;       // Pcr
        $luchaje              = $row[27] ?? null;       // Luc
        $calibre_tra          = $row[28] ?? null;       // CALIBRE TRA
        $dobladillo           = $row[29] ?? null;       // Dob
        $pasadas_trama        = $row[30] ?? null;       // PASADAS TRA
        $pasadas_c1           = $row[31] ?? null;       // PASADAS C1
        $pasadas_c2           = $row[32] ?? null;       // PASADAS C2
        $pasadas_c3           = $row[33] ?? null;       // PASADAS C3
        $pasadas_c4           = $row[34] ?? null;       // PASADAS C4
        $pasadas_c5           = $row[35] ?? null;       // PASADAS C5
        $ancho_por_toalla     = $row[36] ?? null;       // ancho por toalla
        $color_trama          = $row[37] ?? null;       // COLOR TRA
        $calibre_c1           = $row[38] ?? null;       // CALIBRE C1
        $color_c1             = $row[39] ?? null;       // COLOR C1
        $calibre_c2           = $row[40] ?? null;       // CALIBRE C2
        $color_c2             = $row[41] ?? null;       // COLOR C2
        $calibre_c3           = $row[42] ?? null;       // CALIBRE C3
        $color_c3             = $row[43] ?? null;       // COLOR C3
        $calibre_c4           = $row[44] ?? null;       // CALIBRE C4
        $color_c4             = $row[45] ?? null;       // COLOR C4
        $calibre_c5           = $row[46] ?? null;       // CALIBRE C5
        $color_c5             = $row[47] ?? null;       // COLOR C5
        $plano                = $row[48] ?? null;
        $cuenta_pie           = $row[49] ?? null;
        $color_pie            = $row[50] ?? null;
        $peso_gr_m2           = $row[51] ?? null;       // Peso (gr / m²)
        $dias_ef              = $row[52] ?? null;       // Dias Ef.
        $prod_kg_dia          = $row[53] ?? null;       // Prod (Kg)/Día
        $std_dia              = $row[54] ?? null;
        $prod_kg_dia1         = $row[55] ?? null;       // Prod (Kg)/Día (columna extra en Excel, corresponde a Prod_Kg_Dia1 en BD)
        $std_toa_hr_100       = $row[56] ?? null;       // Std (Toa/Hr) 100%
        $dias_jornada_completa = $row[57] ?? null;       // Dias jornada completa
        $horas                = $row[58] ?? null;
        $std_hr_efectivo      = $row[59] ?? null;
        $inicio_tejido        = is_numeric($row[60]) ? Date::excelToDateTimeObject($row[60])->format('Y-m-d H:i:s') : $row[60] ?? null;
        $calc4                = $row[61] ?? null;
        $calc5                  = $row[62] ?? null;
        $calc6                = $row[63] ?? null;
        $fin_tejido           = is_numeric($row[64]) ? Date::excelToDateTimeObject($row[64])->format('Y-m-d H:i:s') : $row[64] ?? null;
        $fecha_compromiso     = is_numeric($row[65]) ? Date::excelToDateTimeObject($row[65])->format('Y-m-d H:i:s') : $row[65] ?? null;
        $fecha_compromiso1    = is_numeric($row[66]) ? Date::excelToDateTimeObject($row[66])->format('Y-m-d H:i:s') : $row[66] ?? null;
        $entrega              = is_numeric($row[67]) ? Date::excelToDateTimeObject($row[67])->format('Y-m-d H:i:s') : $row[67] ?? null;
        $dif_vs_compromiso    = $row[68] ?? null;

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
            'Cambios_Hilo'          => $cambios_hilo  ?? null,
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
            'Fecha_Liberacion'      => $orden_prod ?? null,
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
            'PASADAS_TRAMA'         =>  $pasadas_trama ?? null,
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


        // Si no existe el modelo, crea uno "falso"
        if (!$modelo) {
            $modelo = new \stdClass();
            $modelo->PASADAS_1 = 0;
            $modelo->PASADAS_2 = 0;
            $modelo->PASADAS_3 = 0;
            $modelo->PASADAS_4 = 0;
            $modelo->PASADAS_5 = 0;
            $modelo->Med_plano = 0;
            $modelo->TIRAS = 1;
        }

        foreach ($periodo as $index => $dia) {
            $inicioDia = $dia->copy()->startOfDay();
            $finDia = $dia->copy()->endOfDay();
            $PASADAS_1 = safeNumber($modelo->PASADAS_1 ?? 0);

            // Fracción del día y piezas
            if ($index === 0) {
                $inicio = strtotime($fechaInicioCarbon);
                $fin = strtotime($fechaFinCarbon);

                $diaInicio = date('Y-m-d', $inicio);
                $diaFin = date('Y-m-d', $fin);

                if ($diaInicio === $diaFin) {
                    $diferenciaSegundos = $fin - $inicio;
                    $fraccion = safeDivide($diferenciaSegundos, 86400);
                } else {
                    $hora = date('H', $inicio);
                    $minuto = date('i', $inicio);
                    $segundo = date('s', $inicio);
                    $segundosDesdeMedianoche = ($hora * 3600) + ($minuto * 60) + $segundo;
                    $segundosRestantes = 86400 - $segundosDesdeMedianoche;
                    $fraccion = safeDivide($segundosRestantes, 86400);
                }
            } else {
                $fraccion = 1;
            }

            $stdHrEfectivo = safeNumber($nuevoRegistro->Std_Hr_efectivo ?? 1);
            $piezas = ($fraccion * 24) * $stdHrEfectivo;
            $prodKgDia = safeNumber($nuevoRegistro->Prod_Kg_Dia ?? 0);

            $kilos = safeDivide($piezas * $prodKgDia, $stdHrEfectivo * 24);

            $calibre_tra = safeNumber($nuevoRegistro->CALIBRE_TRA ?? 1);

            $TRAMA = safeDivide(
                0.59 * (($PASADAS_1 * 1.001) * $ancho_por_toalla) / 100,
                $calibre_tra
            ) * $piezas / 1000;

            $combinacion1 = safeDivide(
                0.59 * (($modelo->PASADAS_2 ?? 0) * 1.001 * $ancho_por_toalla) / 100,
                safeNumber($nuevoRegistro->CALIBRE_C1 ?? 1)
            ) * $piezas / 1000;

            $combinacion2 = safeDivide(
                0.59 * (($modelo->PASADAS_3 ?? 0) * 1.001 * $ancho_por_toalla) / 100,
                safeNumber($nuevoRegistro->CALIBRE_C2 ?? 1)
            ) * $piezas / 1000;

            $combinacion3 = safeDivide(
                0.59 * (($modelo->PASADAS_4 ?? 0) * 1.001 * $ancho_por_toalla) / 100,
                safeNumber($nuevoRegistro->CALIBRE_C3 ?? 1)
            ) * $piezas / 1000;

            $combinacion4 = safeDivide(
                0.59 * (($modelo->PASADAS_5 ?? 0) * 1.001 * $ancho_por_toalla) / 100,
                safeNumber($nuevoRegistro->CALIBRE_C4 ?? 1)
            ) * $piezas / 1000;

            $med_plano = safeNumber($modelo->Med_plano ?? 0);
            $largo_crudo = safeNumber($nuevoRegistro->Largo_Crudo ?? 0);
            $cuenta_pie = safeNumber($nuevoRegistro->Cuenta_Pie ?? 32);
            $tiras = safeNumber($modelo->TIRAS ?? 1);
            $calibre_pie = safeNumber($nuevoRegistro->Calibre_Pie ?? 1);

            $Piel1 = safeDivide(
                (($largo_crudo + $med_plano) / 100) * 1.055 * 0.00059,
                safeDivide((0.00059 * 1), safeDivide(0.00059, $calibre_pie))
            ) * safeDivide(($cuenta_pie - 32), $tiras) * $piezas;

            // Calcular rizo según "Aplic"
            $multiplicadorRizo = match ($aplic) {
                'RZ' => 1,
                'RZ2' => 2,
                'RZ3' => 3,
                'BOR', 'EST', 'DC' => 1,
                default => 0
            };
            $rizo = $multiplicadorRizo * $kilos;

            $riso = $kilos - ($Piel1 + $combinacion3 + $combinacion2 + $combinacion1 + $TRAMA + $combinacion4);

            $cambio = safeNumber($nuevoRegistro->Cambios_Hilo ?? 0);

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
        }

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
