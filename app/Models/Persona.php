<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use SoftDeletes;

    protected $table = 'personas';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'direccion',
        'telefono',
        'fecha_nacimiento',
        'correo_electronico',
        'password',
        'estado',
        'rol',
    ];

    protected $hidden = [
        'password'
    ];
}


