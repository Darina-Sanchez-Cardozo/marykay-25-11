<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    public $timestamps = false; // Quitar si tu tabla tiene created_at / updated_at

    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    }
}

