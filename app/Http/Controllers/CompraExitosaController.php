<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompraExitosaController extends Controller
{
    public function index()
    {
        return view('compra.exitosa');
    }
}
