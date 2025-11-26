@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow p-4">

        <!-- Título y botón -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold text-danger">Campañas Mary Kay 💄</h3>

            <a href="{{ route('campania.create') }}" 
               class="btn btn-pink text-white fw-bold" 
               style="background-color:#d63384; border:none; padding:8px 15px; border-radius:6px;">
               + Nueva Campaña
            </a>
        </div>

        <!-- Tabla -->
        <table class="table table-borderless">
            <thead>
                <tr class="text-uppercase text-muted">
                    <th>Nombre</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($campanias as $c)
                <tr>
                    <td>{{ $c->nombre }}</td>
                    <td>{{ \Carbon\Carbon::parse($c->fecha_inicio)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($c->fecha_fin)->format('d/m/Y') }}</td>

                    <td>
                        @if($c->estado == 'Activa')
                        <span class="badge bg-success">Activa</span>
                        @else
                        <span class="badge bg-secondary">Cerrada</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('campania.edit', $c->id) }}" class="btn btn-sm btn-primary">
                            Editar
                        </a>

                        <form action="{{ route('campania.destroy', $c->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Eliminar campaña?')">
                                Eliminar
                            </button>
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Botón Regresar -->
        <a href="{{ route('admin.dashboard') }}" 
           class="btn btn-outline-dark mt-3 w-100 text-center fw-bold">
            Regresar
        </a>

    </div>

</div>

<!-- Footer -->
<p class="text-center text-muted mt-4">
    © 2025 Mary Kay Digital — Sistema de Venta de Maquillaje
</p>

@endsection
