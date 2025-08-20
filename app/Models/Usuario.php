<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios'; // Asegura que sea el nombre correcto
    protected $primaryKey = 'numero_empleado'; // Laravel usa 'id' por defecto, cambia esto si es necesario, PRIMARY KEY
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true; // Si tu tabla no tiene timestamps, pon esto


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
        'remember_token', // <-- importante, si se omite este campo/atributo, no se guardará el token hasheado
    ];

    // Mutador para encriptar la contraseña automáticamente
    public function setContraseniaAttribute($value)
    {
        $this->attributes['contrasenia'] = Hash::make($value);
    }

    public function telares() //recuerda asignar los telares insertando los registros adecuadamente, aun no hay vista automatizada.
    {
        return $this->belongsToMany(CatalagoTelar::class, 'telares_usuario', 'usuario_id', 'telar_id');
    }

    // Para que {usuario} en la ruta resuelva por numero_empleado - 20-08-2025
    public function getRouteKeyName()
    {
        return 'numero_empleado';
    }

    // Que los módulos se manejen como boolean en PHP
    protected $casts = [
        'enviarMensaje'   => 'boolean',
        'almacen'         => 'boolean',
        'urdido'          => 'boolean',
        'engomado'        => 'boolean',
        'tejido'          => 'boolean',
        'atadores'        => 'boolean',
        'tejedores'       => 'boolean',
        'mantenimiento'   => 'boolean',
        'planeacion'      => 'boolean',
        'configuracion'   => 'boolean',
        'UrdidoEngomado'  => 'boolean',
    ];
}
