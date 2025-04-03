<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventDim extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv_ti'; // Conexión a la BD TI_PRO
    protected $table = 'TI_PRO.dbo.INVENTDIM';
    protected $primaryKey = 'INVENTDIMID'; // Ajusta si es otra clave
    public $timestamps = false;

    protected $fillable = [
        'INVENTDIMID',
        'INVENTBATCHID',
        'WMSLOCATIONID',
        'INVENTSERIALID',
        'INVENTLOCATIONID',
        'CONFIGID',
        'INVENTSIZEID',
        'INVENTCOLORID',
        'DATAAREAID',
        'RECVERSION',
        'RECID'
    ];
}
