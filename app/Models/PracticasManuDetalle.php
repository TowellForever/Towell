<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PracticasManuDetalle extends Model
{
    use HasFactory;
    // Si no tienes campos created_at / updated_at, desactívalo
    public $timestamps = false;

    protected $table = 'practicas_manu_detalles';

    protected $fillable = [
        'practicas_manu_id',
        'criterio',
        'telar',
        'turno',
        'valor',
    ];

    public function practica()
    {
        return $this->belongsTo(Tejedor::class, 'practicas_manu_id');
    }
}
