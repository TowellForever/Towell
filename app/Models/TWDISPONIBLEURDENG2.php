<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TWDISPONIBLEURDENG2 extends Model
{
    protected $table = 'TWDISPONIBLEURDENG2';

    protected $connection = 'sqlsrv_ti';

    public $timestamps = false;

    protected $fillable = [
        'articulo',
        'tipo',
        'cantidad',
        'hilo',
        'cuenta',
        'color',
        'almacen',
        'orden',
        'localidad',
        'no_julio',
        'metros',
        'fecha',
        'twdis_key',
        'telar',
        'fecha_requerida',
        'mccoy',
    ];
}
