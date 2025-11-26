<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campania extends Model
{
    use SoftDeletes;

    protected $table = 'campanias';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    protected $dates = [
        'fecha_inicio',
        'fecha_fin',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
