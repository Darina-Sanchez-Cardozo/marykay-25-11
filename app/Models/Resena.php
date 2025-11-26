<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resena extends Model
{
    protected $table = 'resenas';

    protected $fillable = [
        'persona_id',
        'producto_id',
        'venta_id',
        'calificacion',
        'comentario',
    ]; // ← AQUÍ SE CIERRA EL ARRAY CORRECTO

    // Relación con producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    // Relación con persona (cliente)
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    // Relación con venta
    public function venta()
    {
        return $this->belongsTo(VentaCliente::class, 'venta_id');
    }
}
