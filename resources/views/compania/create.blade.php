@extends('layouts.app')

@section('content')
<div class="container mt-5 d-flex justify-content-center">

    <div class="card shadow p-4" style="width: 450px; border-radius: 15px;">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-danger">
                Añadir Campaña <i class="fa-solid fa-briefcase text-secondary"></i>
            </h4>

            <span class="text-muted">Administrador</span>
        </div>

        <form action="{{ route('campania.store') }}" method="POST">
            @csrf

            <!-- Nombre -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Nombre de la campaña *</label>
                <input type="text" name="nombre" class="form-control"
                       placeholder="Ej. Primavera 2025" required>
            </div>

            <!-- Fechas -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Fecha de inicio *</label>
                    <input type="date" name="fecha_inicio" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Fecha de fin *</label>
                    <input type="date" name="fecha_fin" class="form-control" required>
                </div>
            </div>

            <!-- Estado -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Estado *</label>
                <select name="estado" class="form-control" required>
                    <option value="">Seleccione</option>
                    <option value="Activa">Activa</option>
                    <option value="Cerrada">Cerrada</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-between mt-4">

                <button class="btn btn-pink text-white px-4">
                    --Agregar--
                </button>

                <a href="{{ route('campania.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>

            </div>

        </form>

    </div>

</div>

<!-- Footer -->
<p class="text-center text-muted mt-4">
    © 2025 Mary Kay Digital — Sistema de Venta de Maquillaje
</p>

@endsection
