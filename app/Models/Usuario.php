<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios'; // Asegura que sea el nombre correcto
    protected $primaryKey = 'numero_empleado'; // Laravel usa 'id' por defecto, cambia esto si es necesario
    public $timestamps = false; // Si tu tabla no tiene timestamps, pon esto


    protected $fillable = [
        'numero_empleado',
        'nombre',
        'contrasenia',
        'area',
        'telefono',
        'turno',
        'enviarMensaje',
        'foto',
        'almacen',
        'urdido',
        'engomado',
        'tejido',
        'atadores',
        'tejedores',
        'mantenimiento',
        'planeacion',
        'configuracion',
        'UrdidoEngomado',
        'remember_token', // <-- importante
    ];

    // Mutador para encriptar la contraseña automáticamente
    public function setContraseniaAttribute($value)
    {
        $this->attributes['contrasenia'] = Hash::make($value);
    }

    public function telares()
    {
        return $this->belongsToMany(CatalagoTelar::class, 'telares_usuario', 'usuario_id', 'telar_id');
    }
}
