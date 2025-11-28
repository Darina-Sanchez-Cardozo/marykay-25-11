<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleVenta extends Model
{
    use SoftDeletes;

    protected $table = 'detallesventa';

    protected $fillable = [
        'producto_id',
        'cantidad',
        'venta_cliente_id',
        'venta_consultora_id',
    ];

    public function venta()
    {
        return $this->belongsTo(VentaCliente::class, 'venta_cliente_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}

