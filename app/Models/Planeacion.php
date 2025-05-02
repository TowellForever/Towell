<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planeacion extends Model
{
    public $timestamps = false; // Deshabilitar el manejo automático de created_at y updated_at
    protected $table = 'TEJIDO_SCHEDULING'; // si no lo tienes ya
    protected $primaryKey = 'num_registro'; // pon aquí tu clave real
    public $incrementing = false; // si no es autoincremental
    protected $fillable = [
        'Cuenta', 'Salon', 'Telar', 'Ultimo', 'Cambios_Hilo', 'Maquina', 'Ancho', 'Eficiencia_Std', 'Velocidad_STD', 'Calibre_Rizo', 'Calibre_Pie', 'Calendario',
        'Clave_Estilo', 'Tamano', 'Estilo_Alternativo', 'Nombre_Producto', 'Saldos', 'Fecha_Captura', 'Orden_Prod', 'Fecha_Liberacion', 'Id_Flog', 'Descrip',
        'Aplic', 'Obs', 'Tipo_Ped', 'Tiras', 'Peine', 'Largo_Crudo', 'Peso_Crudo', 'Luchaje', 'CALIBRE_TRA', 'Dobladillo', 'PASADAS_TRAMA', 'PASADAS_C1',
        'PASADAS_C2', 'PASADAS_C3', 'PASADAS_C4', 'PASADAS_C5', 'ancho_por_toalla', 'COLOR_TRAMA', 'CALIBRE_C1', 'Clave_Color_C1', 'COLOR_C1', 'CALIBRE_C2',
        'Clave_Color_C2', 'COLOR_C2', 'CALIBRE_C3', 'Clave_Color_C3', 'COLOR_C3', 'CALIBRE_C4', 'Clave_Color_C4', 'COLOR_C4', 'CALIBRE_C5', 'Clave_Color_C5',
        'COLOR_C5', 'Plano', 'Cuenta_Pie', 'Clave_Color_Pie', 'Color_Pie', 'Peso_gr_m2', 'Dias_Ef', 'Prod_Kg_Dia', 'Std_Dia', 'Prod_Kg_Dia1', 'Std_Toa_Hr_100',
        'Dias_jornada_completa', 'Horas', 'Std_Hr_efectivo', 'Inicio_Tejido', 'Calc4', 'Calc5', 'Calc6', 'Fin_Tejido', 'Fecha_Compromiso', 'Fecha_Compromiso1',
        'Entrega', 'Dif_vs_Compromiso', 'en_proceso', 'num_registro'
    ];
    

    public function calendario()
    {
        return $this->hasOne(Calendario::class, 'cal_id', 'num_registro');
    }
}
