<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atador extends Model
{
    use HasFactory;

    protected $table = 'atadores'; // Laravel está buscando la tabla atadors (con S al final), por convención en ingles, pero no es correcto en español

    protected $fillable = [
        'estatus_atado',
        'fecha_atado',
        'turno',
        'clave_atador',
        'no_julio',
        'orden',
        'r_p',
        'metros',
        'telar',
        'proveedor',
        'merma_kg',
        'hora_paro',
        'hora_arranque',
        'grua_hubtex',
        'atadora_uster',
        'calidad_atado',
        '5_s_orden_limpieza',
        'firma_tejedor',
        'obs',
    ];
}
