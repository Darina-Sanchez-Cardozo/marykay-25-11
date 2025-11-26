<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entrada extends Model
{
    use SoftDeletes;

    protected $table = 'entradas';

    protected $fillable = [
        'producto_id',
        'cantidad',
        'precio_entrada',
        'fecha_entrada',
        'descripcion',
        'almacenista_id',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function almacenista()
    {
        return $this->belongsTo(Persona::class, 'almacenista_id');
    }
}
