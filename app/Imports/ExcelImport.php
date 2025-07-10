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
        // 1. Saltar filas completamente vacías
        if (empty(array_filter($row))) {
            return null;
        }

        // 2. Crear el registro principal de forma segura
        $nuevoRegistro = \App\Models\Planeacion::create([
            'Cuenta'                => $row[0] ?? null,
            'Salon'                 => $row[1] ?? null,
            'Telar'                 => $row[2] ?? null,
            'Ultimo'                => $row[3] ?? null,
            'Cambios_Hilo'          => $row[4] ?? null,
            'Maquina'               => $row[5] ?? null,
            'Ancho'                 => $row[6] ?? null,
            'Eficiencia_Std'        => $row[7] ?? null,
            'Velocidad_STD'         => $row[8] ?? null,
            'Hilo'                  => $row[9] ?? null,
            'Calibre_Pie'           => $row[10] ?? null,
            'Calendario'            => $row[11] ?? null,
            'Clave_Estilo'          => $row[12] ?? null,
            'Clave_AX'              => $row[13] ?? null,
            'Tamano_AX'             => $row[14] ?? null,
            'Estilo_Alternativo'    => $row[15] ?? null,
            'Nombre_Producto'       => $row[16] ?? null,
            'Saldos'                => $row[17] ?? null,
            'Fecha_Captura'         => is_numeric($row[18]) ? Date::excelToDateTimeObject($row[18])->format('Y-m-d H:i:s') : $row[18] ?? null,
            'Orden_Prod'            => $row[19] ?? null,
            'Fecha_Liberacion'      => is_numeric($row[20]) ? Date::excelToDateTimeObject($row[20])->format('Y-m-d H:i:s') : $row[20] ?? null,
            'Id_Flog'               => $row[21] ?? null,
            'Descrip'               => $row[22] ?? null,
            'Aplic'                 => $row[23] ?? null,
            'Obs'                   => $row[24] ?? null,
            'Tipo_Ped'              => $row[25] ?? null,
            'Tiras'                 => $row[26] ?? null,
            'Peine'                 => $row[27] ?? null,
            'Largo_Crudo'           => $row[28] ?? null,
            'Peso_Crudo'            => $row[29] ?? null,
            'Luchaje'               => $row[30] ?? null,
            'CALIBRE_TRA'           => $row[31] ?? null,
            'Dobladillo'            => $row[32] ?? null,
            'PASADAS_TRAMA'         => $row[33] ?? null,
            'PASADAS_C1'            => $row[34] ?? null,
            'PASADAS_C2'            => $row[35] ?? null,
            'PASADAS_C3'            => $row[36] ?? null,
            'PASADAS_C4'            => $row[37] ?? null,
            'PASADAS_C5'            => $row[38] ?? null,
            'ancho_por_toalla'      => $row[39] ?? null,
            'COLOR_TRAMA'           => $row[40] ?? null,
            'CALIBRE_C1'            => $row[41] ?? null,
            'Clave_Color_C1'        => $row[42] ?? null,
            'COLOR_C1'              => $row[43] ?? null,
            'CALIBRE_C2'            => $row[44] ?? null,
            'Clave_Color_C2'        => $row[45] ?? null,
            'COLOR_C2'              => $row[46] ?? null,
            'CALIBRE_C3'            => $row[47] ?? null,
            'Clave_Color_C3'        => $row[48] ?? null,
            'COLOR_C3'              => $row[49] ?? null,
            'CALIBRE_C4'            => $row[50] ?? null,
            'Clave_Color_C4'        => $row[51] ?? null,
            'COLOR_C4'              => $row[52] ?? null,
            'CALIBRE_C5'            => $row[53] ?? null,
            'Clave_Color_C5'        => $row[54] ?? null,
            'COLOR_C5'              => $row[55] ?? null,
            'Plano'                 => $row[56] ?? null,
            'Cuenta_Pie'            => $row[57] ?? null,
            'Clave_Color_Pie'       => $row[58] ?? null,
            'Color_Pie'             => $row[59] ?? null,
            'Peso_gr_m2'            => $row[60] ?? null,
            'Dias_Ef'               => $row[61] ?? null,
            'Prod_Kg_Dia'           => $row[62] ?? null,
            'Std_Dia'               => $row[63] ?? null,
            'Prod_Kg_Dia1'          => $row[64] ?? null,
            'Std_Toa_Hr_100'        => $row[65] ?? null,
            'Dias_jornada_completa' => $row[66] ?? null,
            'Horas'                 => $row[67] ?? null,
            'Std_Hr_efectivo'       => $row[68] ?? null,
            'Inicio_Tejido'         => is_numeric($row[69]) ? Date::excelToDateTimeObject($row[69])->format('Y-m-d H:i:s') : $row[69] ?? null,
            'Calc4'                 => $row[70] ?? null,
            'Calc5'                 => $row[71] ?? null,
            'Calc6'                 => $row[72] ?? null,
            'Fin_Tejido'            => is_numeric($row[73]) ? Date::excelToDateTimeObject($row[73])->format('Y-m-d H:i:s') : $row[73] ?? null,
            'Fecha_Compromiso'      => is_numeric($row[74]) ? Date::excelToDateTimeObject($row[74])->format('Y-m-d H:i:s') : $row[74] ?? null,
            'Fecha_Compromiso1'     => is_numeric($row[75]) ? Date::excelToDateTimeObject($row[75])->format('Y-m-d H:i:s') : $row[75] ?? null,
            'Entrega'               => is_numeric($row[76]) ? Date::excelToDateTimeObject($row[76])->format('Y-m-d H:i:s') : $row[73] ?? null,
            'Dif_vs_Compromiso'     => $row[77] ?? null,
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

        // Buscar el modelo de forma segura
        $modelo = \App\Models\Modelos::where('CLAVE_AX', (string) $nuevoRegistro->Clave_AX)
            ->where('Tamanio_AX', $nuevoRegistro->Tamano_AX)
            ->where('Departamento', $nuevoRegistro->Salon)
            ->first();

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
