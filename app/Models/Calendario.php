<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendario extends Model
{
    // Nombre exacto de la tabla
    protected $table = 'calendarios';

    // Clave primaria personalizada
    protected $primaryKey = 'cal_id';

    // No es autoincremental (porque es FK)
    public $incrementing = false;

    // Tipo de la PK
    protected $keyType = 'int';

    // Desactiva created_at y updated_at
    public $timestamps = false;

    // Campos que se pueden asignar en masa
    protected $fillable = [
        'cal_id',
        'fecha_inicio',
        'fecha_fin',
        'total_horas',
    ];

    // Relación con TEJIDO_SCHEDULING
    public function planeacion()
    {
        return $this->belongsTo(Planeacion::class, 'cal_id', 'num_registro');
    }
}
