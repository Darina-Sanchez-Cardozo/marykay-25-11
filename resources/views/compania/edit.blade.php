@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <div class="card shadow p-4">

        <h3 class="fw-bold text-danger mb-4">Editar Campaña</h3>

        <form action="{{ route('campania.update', $campania->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nombre de campaña</label>
                <input type="text" name="nombre" class="form-control"
                       value="{{ $campania->nombre }}" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Fecha inicio</label>
                    <input type="date" name="fecha_inicio"
                           value="{{ $campania->fecha_inicio }}"
                           class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Fecha fin</label>
                    <input type="date" name="fecha_fin"
                           value="{{ $campania->fecha_fin }}"
                           class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Estado</label>
                <select name="estado" class="form-control">
                    <option value="Activa" {{ $campania->estado == 'Activa' ? 'selected' : '' }}>Activa</option>
                    <option value="Cerrada" {{ $campania->estado == 'Cerrada' ? 'selected' : '' }}>Cerrada</option>
                </select>
            </div>

            <button class="btn btn-primary">Actualizar</button>
            <a href="{{ route('campania.index') }}" class="btn btn-dark">Cancelar</a>

        </form>
    </div>

</div>
@endsection
