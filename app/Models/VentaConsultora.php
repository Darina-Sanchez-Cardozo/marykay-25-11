<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VentaConsultora extends Model
{
    use SoftDeletes;

    protected $table = 'ventasconsultoras';

    protected $fillable = [
        'persona_id',
        'fecha_venta',
        'estado',
        'total'
    ];

    // Laravel sí usa timestamps porque tu tabla los tiene
    public $timestamps = true;

    // Relación con persona (consultora)
    public function persona()
{
    return $this->belongsTo(Persona::class, 'persona_id');
}


    // Relación con detalles
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'venta_consultora_id');
    }
}
