<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tejedor extends Model
{
    // Si el nombre de la tabla no sigue la convención (plural del modelo)
    protected $table = 'practicas_manu';

    // Si no tienes campos created_at / updated_at, desactívalo
    public $timestamps = false;

    // Campos que se pueden asignar en masa
    protected $fillable = [
        'recibe',
        'entrega',
        'fecha',
    ];

    public function detalles()
    {
        return $this->hasMany(PracticasManuDetalle::class);
    }
}
