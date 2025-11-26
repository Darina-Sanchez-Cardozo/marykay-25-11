@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="text-center fw-bold mb-4">Bienvenido Consultor(a)</h2>

    <!-- TARJETAS -->
    <div class="row mb-4">
<li class="nav-item mt-4"> <a href="{{ route('usuarios.login') }}" class="nav-link">Salir</a></li>
        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center">
                <h6 class="text-muted">Registro de Ventas</h6>
                <h3 class="text-danger fw-bold">{{ number_format($ventas) }}</h3>
                <small>Ventas totales registradas</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center">
                <h6 class="text-muted">Total devoluciones</h6>
                <h3 class="text-danger fw-bold">{{ number_format($devoluciones) }}</h3>
                <small>Productos devueltos</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center">
                <h6 class="text-muted">Catálogo Digital</h6>
                <a href="{{ route('producto.index') }}" class="btn btn-outline-dark mt-2">
                    Ver Tienda Consultora
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center">
                <h6 class="text-muted">Nuevos clientes</h6>
                <h4 class="text-danger fw-bold">+{{ number_format($nuevos_clientes) }} usuarios</h4>
            </div>
        </div>

    </div>

    <!-- GRAFICA Y CATEGORIAS -->
    <div class="row">

        <div class="col-md-8">
            <div class="card shadow-sm p-3">
                <h6 class="mb-3 fw-bold">Desempeño de Ventas</h6>
                <img src="https://i.imgur.com/4yJ8BCT.png" class="img-fluid">
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h6 class="fw-bold mb-3">Categorías Populares</h6>

                @foreach($categorias as $cat)
                <div class="mb-2">
                    <small>{{ $cat['nombre'] }}</small>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar"
                             style="width: {{ $cat['porcentaje'] }}%; background-color:#d63384;">
                        </div>
                    </div>
                    <small class="text-muted">{{ $cat['porcentaje'] }}%</small>
                </div>
                @endforeach

            </div>
        </div>

    </div>

    <!-- ASESORIAS -->
    <div class="card shadow-sm p-4 mt-4">

        <h6 class="fw-bold mb-3">Asesorías Pendientes</h6>

        <table class="table table-borderless">
            <thead>
                <tr class="text-muted text-uppercase">
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Teléfono</th>
                    <th>Ubicación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

                @foreach($asesorias as $a)
                <tr>
                    <td>{{ $a['nombre'] }}</td>
                    <td>{{ $a['fecha'] }}</td>
                    <td>{{ $a['telefono'] }}</td>
                    <td>{{ $a['ubicacion'] }}</td>
                    <td>
                        <a href="#" class="btn btn-outline-dark btn-sm">Detalles</a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

    </div>

</div>

<p class="text-center text-muted mt-4">
    © 2025 Mary Kay Digital — Sistema de Venta de Maquillaje
</p>

@endsection
