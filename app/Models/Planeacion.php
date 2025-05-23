<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planeacion extends Model
{
    public $timestamps = false; // Deshabilitar el manejo automático de created_at y updated_at
    protected $table = 'TEJIDO_SCHEDULING'; // Asegúrate de usar el nombre correcto de tu tabla
    protected $fillable = [
        'Cuenta', 'Salon', 'Telar', 'Ultimo', 'Cambios_Hilo', 'Maquina', 'Ancho', 'Eficiencia_Std', 'Velocidad_STD', 'Calibre_Rizo', 'Calibre_Pie', 'Calendario',
        'Clave_Estilo', 'Tamano', 'Estilo_Alternativo', 'Nombre_Producto', 'Saldos', 'Fecha_Captura', 'Orden_Prod', 'Fecha_Liberacion', 'Id_Flog', 'Descrip',
        'Aplic', 'Obs', 'Tipo_Ped', 'Tiras', 'Peine', 'Largo_Crudo', 'Peso_Crudo', 'Luchaje', 'CALIBRE_TRA', 'Dobladillo', 'PASADAS_TRAMA', 'PASADAS_C1',
        'PASADAS_C2', 'PASADAS_C3', 'PASADAS_C4', 'PASADAS_C5', 'ancho_por_toalla', 'COLOR_TRAMA', 'CALIBRE_C1', 'Clave_Color_C1', 'COLOR_C1', 'CALIBRE_C2',
        'Clave_Color_C2', 'COLOR_C2', 'CALIBRE_C3', 'Clave_Color_C3', 'COLOR_C3', 'CALIBRE_C4', 'Clave_Color_C4', 'COLOR_C4', 'CALIBRE_C5', 'Clave_Color_C5',
        'COLOR_C5', 'Plano', 'Cuenta_Pie', 'Clave_Color_Pie', 'Color_Pie', 'Peso____(gr_/_m²)', 'Dias_Ef', 'Prod_(Kg)/Día', 'Std/Dia', 'Prod_(Kg)/Día1',
        'Std_(Toa/Hr)_100%', 'Dias_jornada_completa', 'Horas', 'Std/Hrefectivo', 'Inicio_Tejido', 'Calc4', 'Calc5', 'Calc6', 'Fin_Tejido', 'Fecha_Compromiso',
        'Fecha_Compromiso1', 'Entrega', 'Dif_vs_Compromiso', 'en_proceso'
    ];
}
