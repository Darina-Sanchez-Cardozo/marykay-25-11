@extends('layouts.app')

@section('content')
<div class="container mt-5 d-flex justify-content-center">

    <div class="card shadow p-4" style="width: 600px; border-radius: 15px;">

        <h4 class="fw-bold text-danger mb-4 text-center">
            Registrar Nueva Categoría 💄
        </h4>

        <form action="{{ route('categoria.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Nombre de la Categoría</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3" required></textarea>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button class="btn btn-pink text-white px-4 fw-bold">
                    Guardar
                </button>

                <a href="{{ route('categoria.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>

        </form>
    </div>

</div>

<p class="text-center text-muted mt-4">
    © 2025 Mary Kay Digital — Sistema de Venta de Maquillaje
</p>

@endsection
