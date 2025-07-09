<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteTemporal extends Model
{
    use HasFactory;
    protected $table = 'reportes_temporales';


    protected $fillable = [
        'telar',
        'tipo',
        'clave_falla',
        'descripcion',
        'fecha_reporte',
        'hora_reporte',
        'operador',
        'observaciones',
    ];
}
