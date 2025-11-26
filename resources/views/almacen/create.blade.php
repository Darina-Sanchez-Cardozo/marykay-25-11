@extends('layouts.app')

@section('title', 'Registrar Entrada de Almacén')

@section('content')

<div class="card shadow-sm p-4">

    <h3 class="fw-bold mb-4" style="color:#c71585;">
        ➕ Registrar Nueva Entrada al Almacén
    </h3>

    <form action="{{ route('almacen.store') }}" method="POST">
        @csrf

        <div class="row">
            {{-- PRODUCTO --}}
            <div class="col-md-6 mb-3">
                <label class="fw-bold">Producto</label>
                <select name="producto_id" class="form-control" required>
                    <option value="">Seleccione un producto</option>
                    @foreach ($productos as $p)
                        <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                    @endforeach
                </select>
            </div>

            {{-- CANTIDAD --}}
            <div class="col-md-3 mb-3">
                <label class="fw-bold">Cantidad</label>
                <input type="number" name="cantidad" class="form-control" min="1" required>
            </div>

            {{-- PRECIO --}}
            <div class="col-md-3 mb-3">
                <label class="fw-bold">Precio de Entrada</label>
                <input type="number" step="0.01" name="precio_entrada" class="form-control" required>
            </div>
        </div>

        <div class="row">

            {{-- FECHA --}}
            <div class="col-md-4 mb-3">
                <label class="fw-bold">Fecha de Entrada</label>
                <input type="date" name="fecha_entrada" class="form-control" required>
            </div>

            {{-- ALMACENISTA --}}
            <div class="col-md-4 mb-3">
                <label class="fw-bold">Almacenista Responsable</label>
                <select name="almacenista_id" class="form-control" required>
                    <option value="">Seleccione</option>
                    @foreach ($almacenistas as $a)
                        <option value="{{ $a->id }}">{{ $a->nombre }} {{ $a->apellido_paterno }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- DESCRIPCIÓN --}}
        <div class="mb-3">
            <label class="fw-bold">Descripción</label>
            <textarea name="descripcion" rows="3" class="form-control"></textarea>
        </div>

        <a href="{{ route('almacen.index') }}" class="btn btn-outline-dark mt-3">
            Cancelar
        </a>

        <button class="btn btn-pink mt-3" style="background:#c71585; color:white;">
            Guardar Entrada
        </button>

    </form>

</div>

@endsection
