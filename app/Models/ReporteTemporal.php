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
        'enviado_telegram',
        'enviado_telegram_at',
        'telegram_message_id'
    ];

    protected $casts = [
        'enviado_telegram' => 'boolean',
        'enviado_telegram_at' => 'datetime',
        'fecha_reporte' => 'date',
    ];
}
