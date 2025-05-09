<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalagoTelar extends Model
{
    use HasFactory;

    // Si el nombre de la tabla no sigue la convención (en plural), se especifica
    protected $table = 'catalago_telares';

    // Si la tabla no tiene timestamps, puedes deshabilitarlos:
    public $timestamps = false;

    // Si quieres proteger ciertas columnas de la asignación masiva:
    protected $fillable = ['salon', 'telar', 'nombre', 'rizo', 'pie', 'ancho', 'calibre_rizo','calibre_pie'];

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'telares_usuario', 'telar_id', 'usuario_id');
    }

}
