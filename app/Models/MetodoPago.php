<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    // Nombre exacto de tu tabla en la base de datos
    protected $table = 'metodospago';

    // Campos que se pueden llenar desde formularios
    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}
