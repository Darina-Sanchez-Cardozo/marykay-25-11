<?php

namespace App\Http\Controllers;

use App\Models\MetodoPago;

class MetodoPagoVistaController extends Controller
{
    public function index()
    {
        // Llama los métodos de pago de tu tabla 'metodospago'
        $metodos = MetodoPago::orderBy('id', 'ASC')->get();

        return view('tienda.metodo_pago', compact('metodos'));
    }
}
