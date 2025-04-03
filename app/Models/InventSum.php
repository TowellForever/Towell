<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventSum extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv_ti'; // Conexión a la BD TI_PRO
    protected $table = 'TI_PRO.dbo.INVENTSUM'; // Nombre exacto de la tabla
    protected $primaryKey = 'ITEMID'; // Ajusta según la clave primaria real
    public $timestamps = false; // Si la tabla no tiene created_at / updated_at

    protected $fillable = [
        'ITEMID',
        'POSTEDQTY',
        'POSTEDVALUE',
        'DEDUCTED',
        'RECEIVED',
        'RESERVPHYSICAL',
        'RESERVORDERED',
        'ONORDER',
        'ORDERED',
        'QUOTATIONISSUE',
        'QUOTATIONRECEIPT',
        'INVENTDIMID',
        'CLOSED',
        'REGISTERED',
        'PICKED',
        'AVAILORDERED',
        'AVAILPHYSICAL',
        'PHYSICALVALUE',
        'ARRIVED',
        'PHYSICALINVENT',
        'CLOSEDQTY',
        'LASTUPDDATEPHYSICAL',
        'LASTUPDDATEEXPECTED',
        'DATAAREAID',
        'RECVERSION',
        'RECID'
    ];
}
