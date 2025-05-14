<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarioT2 extends Model
{
    // Nombre de la tabla si no sigue la convención plural
    protected $table = 'CALENDARIOT2';

    // Si no usas timestamps (created_at, updated_at)
    public $timestamps = false;

    // Llave primaria (si no es 'id')
    public $incrementing = false;
    protected $primaryKey = null;


    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'horas',
        'dia',
        'inicio',
        'fin',
        'dias_acum',
    ];
}
