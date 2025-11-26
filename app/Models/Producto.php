<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;

    protected $table = 'productos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'codigo_barras',
        'descripcion',
        'precio_mayoreo',
        'precio_menudeo',
        'imagen',
        'existencias',
        'estado_producto',
        'campania_id',
        'categoria_id'
    ];

    protected $casts = [
        'precio_mayoreo' => 'float',
        'precio_menudeo' => 'float',
    ];

    public function campania()
    {
        return $this->belongsTo(Campania::class, 'campania_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}

