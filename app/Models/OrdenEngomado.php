<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenEngomado extends Model
{
    use HasFactory;

    protected $table = 'orden_engomado';
    public $timestamps = false;

    protected $fillable = [
        'id2',
        'folio',
        'fecha',
        'oficial',
        'turno',
        'hora_inicio',
        'hora_fin',
        'tiempo',
        'no_julio',
        'peso_bruto',
        'tara',
        'peso_neto',
        'metros',
        'temp_canoa_1',
        'temp_canoa_2',
        'temp_canoa_3',
        'humedad',
        'roturas',
    ];
}
