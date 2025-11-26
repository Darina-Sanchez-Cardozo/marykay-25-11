<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\DashboardController;

Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');



// CRUD Campania

use App\Http\Controllers\CampaniaController;

Route::resource('campania', CampaniaController::class);


use App\Http\Controllers\CategoriaController;

Route::resource('categoria', CategoriaController::class)->except(['show']);



use App\Http\Controllers\ProductoController;

Route::resource('producto', ProductoController::class);


use App\Http\Controllers\ConsultoraDashboardController;

Route::get('/consultora/dashboard', [ConsultoraDashboardController::class, 'index'])
     ->name('consultora.dashboard');


use App\Http\Controllers\EntradaController;

Route::get('/almacen', [EntradaController::class, 'index'])->name('almacen.index');

Route::get('/almacen/create', [EntradaController::class, 'create'])->name('almacen.create');

Route::post('/almacen/store', [EntradaController::class, 'store'])->name('almacen.store');

Route::get('/almacen/{id}/edit', [EntradaController::class, 'edit'])->name('almacen.edit');

Route::put('/almacen/{id}', [EntradaController::class, 'update'])->name('almacen.update');

Route::delete('/almacen/{id}', [EntradaController::class, 'destroy'])->name('almacen.destroy');

Route::get('/almacen/dashboard', [EntradaController::class, 'dashboard'])
     ->name('almacen.dashboard');

     
Route::get('/almacen/create_dash', [EntradaController::class, 'createDash'])
    ->name('almacen.create_dash');


use App\Http\Controllers\TiendaController;

// Página de tienda
Route::get('/tienda', [TiendaController::class, 'index'])->name('tienda.index');


use App\Http\Controllers\CategoriaProductosController;

use App\Http\Controllers\ProductoTiendaController;

// Productos por categoría (id inicia en 2)
Route::get('/categoria/{id}', [CategoriaProductosController::class, 'index'])
     ->name('categoria.productos');

// Todos los productos
Route::get('/productos', [ProductoTiendaController::class, 'index'])
    ->name('productos.lista');


use App\Http\Controllers\ProductoVistaController;

Route::get('/tienda/producto/{id}', [ProductoVistaController::class, 'show'])
    ->name('tienda.producto');



use App\Http\Controllers\CarritoController;

// Carrito
// Carrito - mostrar solo el producto agregado
Route::get('/carrito/producto/{id}', [CarritoController::class, 'carritoUnico'])
    ->name('carrito.unico');

// Agregar al carrito (solo 1 producto y mostrarlo)
Route::get('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])
    ->name('carrito.agregar');

// Actualizar cantidad
Route::post('/carrito/{id}/cantidad', [CarritoController::class, 'actualizarCantidad'])
    ->name('carrito.actualizar');

// Eliminar del carrito
Route::delete('/carrito/{id}', [CarritoController::class, 'destroy'])
    ->name('carrito.eliminar');


Route::get('/metodo-pago', [CarritoController::class, 'metodoPago'])
    ->name('tienda.metodo_pago');


use App\Http\Controllers\CompraExitosaController;

Route::get('/compra-exitosa', [CompraExitosaController::class, 'index'])
     ->name('compra.exitosa');



use App\Http\Controllers\UsuarioController;

// LOGIN
Route::get('/login', [UsuarioController::class, 'loginVista'])->name('usuarios.login');
Route::post('/login', [UsuarioController::class, 'login'])->name('usuarios.login.post');

// LOGOUT
Route::get('/logout', [UsuarioController::class, 'logout'])->name('usuarios.logout');

// REGISTRO
Route::get('/registro', [UsuarioController::class, 'registroVista'])->name('usuarios.registro');
Route::post('/registro', [UsuarioController::class, 'registro'])->name('usuarios.registro.post');



use App\Http\Controllers\MisComprasController;

Route::get('/mis-compras', [MisComprasController::class, 'index'])
    ->name('miscompras.index');

Route::get('/mis-compras/resena/{id}', [MisComprasController::class, 'crearResena'])
    ->name('miscompras.resena');

Route::post('/mis-compras/resena', [MisComprasController::class, 'guardarResena'])
    ->name('miscompras.resena.store');
