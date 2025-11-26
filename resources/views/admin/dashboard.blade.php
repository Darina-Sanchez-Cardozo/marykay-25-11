@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-2 bg-light p-3 border-end" style="min-height: 100vh;">
            <h4 class="mb-4 text-primary fw-bold">Mary Kay Admin</h4>

            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Inicio</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('campania.index') }}" class="nav-link">Campañas</a>

                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('categoria.index') }}" class="nav-link">Categorías</a>
                </li>

                <li class="nav-item mb-2">
                     <a href="{{ route('producto.index') }}" class="nav-link">Productos</a>
                </li>

                <li class="nav-item mb-2">
                   <a href="{{ route('almacen.index') }}" class="nav-link">Almacén</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="#" class="nav-link text-danger">Validar consultora</a>
                </li>

                <li class="nav-item mt-4">
                    <a href="{{ route('usuarios.login') }}" class="nav-link">Salir</a>
                </li>
            </ul>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-10 p-4">

            <h2 class="fw-bold text-center mb-2">PANEL DE CONTROL ADMINISTRADOR</h2>
            <p class="text-center text-muted mb-4">
                Personas registradas: 132 | Productos disponibles: 16 | Campañas activas: 7
            </p>

            <!-- Tarjetas -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="p-3 bg-success text-white rounded shadow-sm">
                        <h4>Envío Exitoso</h4>
                        <h2>{{ $envio_exitoso }}</h2>
                        <p>Productos entregados satisfactoriamente</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 bg-primary text-white rounded shadow-sm">
                        <h4>En Camino</h4>
                        <h2>{{ $en_camino }}</h2>
                        <p>Productos en tránsito</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 bg-danger text-white rounded shadow-sm">
                        <h4>Envío Pendiente</h4>
                        <h2>{{ $pendiente }}</h2>
                        <p>Productos aún no entregados</p>
                    </div>
                </div>
            </div>

            <!-- Gráfica estática -->
            <div class="card mb-4">
                <div class="card-header fw-bold">Estadísticas de ventas</div>
                <div class="card-body">
                    <img src="https://i.imgur.com/8yVA3Kx.png" 
                         class="img-fluid" alt="gráfica ejemplo">
                </div>
            </div>

            <!-- Tabla de ventas -->
            <div class="card">
                <div class="card-header fw-bold">Ventas por Consultor(a)</div>
                <div class="card-body">

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Consultora</th>
                                <th>Nivel</th>
                                <th>Productos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ventas_consultoras as $i => $v)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $v['consultora'] }}</td>
                                <td>{{ $v['nivel'] }}</td>
                                <td>{{ $v['productos'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

        </div>

    </div>
</div>
@endsection
