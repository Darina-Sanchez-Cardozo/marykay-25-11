<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaCliente extends Model
{
    // Laravel por defecto usaría la tabla 'venta_clientes',
    // así que se fuerza el nombre correcto:
protected $table = 'ventasclientes';

    //protected $fillable = [
    //    'cliente_id',
     //   'total',
      //  'estado',
    //];

    protected $fillable = [
    'persona_id',
    'estado',
    'total',
    'fecha'
];


    // Relación con Persona (cliente)
   public function cliente()
{
    return $this->belongsTo(Persona::class, 'persona_id', 'id');
}


    // Relación con DetalleVenta
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'venta_cliente_id');
    }
}
