<?php

namespace App\Imports;

use App\Models\Planeacion;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;



class ExcelImport implements ToModel
{
    public function model(array $row)
    {
        //dd($row);
        return new Planeacion([
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
    }
}
