@extends('layouts.app')

@section('content')
<div class="container py-5">

    <h2 class="fw-bold mb-4">Panel del Almacenista</h2>

    {{-- BOTÓN PRINCIPAL --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold">Últimas Entradas</h4>

       <a href="{{ route('almacen.create_dash') }}" class="btn btn-dark">Registrar Nueva Entrada</a>

       <li class="nav-item mt-4"> <a href="{{ route('usuarios.login') }}" class="nav-link">Salir</a></li>

    </div>

    {{-- TABLA DE ENTRADAS --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Entrada</th>
                        <th>Fecha</th>
                        <th>Almacenista</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($entradas as $entrada)
                    <tr>
                        <td>{{ $entrada->id }}</td>
                        <td>{{ $entrada->producto->nombre }}</td>
                        <td>{{ $entrada->cantidad }}</td>
                        <td>${{ number_format($entrada->precio_entrada, 2) }}</td>
                        <td>{{ $entrada->fecha_entrada }}</td>
                        <td>{{ $entrada->almacenista->nombre }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
