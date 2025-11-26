@extends('layouts.app')

@section('title', 'Editar Entrada de Almacén')

@section('content')

<div class="card shadow-sm p-4">

    <h3 class="fw-bold mb-4" style="color:#c71585;">
        ✏️ Editar Entrada #{{ $entrada->id }}
    </h3>

    <form action="{{ route('almacen.update', $entrada->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- PRODUCTO --}}
            <div class="col-md-6 mb-3">
                <label class="fw-bold">Producto</label>
                <select name="producto_id" class="form-control" required>
                    @foreach ($productos as $p)
                        <option value="{{ $p->id }}" {{ $entrada->producto_id == $p->id ? 'selected' : '' }}>
                            {{ $p->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- CANTIDAD --}}
            <div class="col-md-3 mb-3">
                <label class="fw-bold">Cantidad</label>
                <input type="number" name="cantidad" class="form-control"
                       value="{{ $entrada->cantidad }}" min="1" required>
            </div>

            {{-- PRECIO --}}
            <div class="col-md-3 mb-3">
                <label class="fw-bold">Precio Entrada</label>
                <input type="number" step="0.01" name="precio_entrada" class="form-control"
                       value="{{ $entrada->precio_entrada }}" required>
            </div>
        </div>

        <div class="row">

            {{-- FECHA --}}
            <div class="col-md-4 mb-3">
                <label class="fw-bold">Fecha de Entrada</label>
                <input type="date" name="fecha_entrada" class="form-control"
                       value="{{ $entrada->fecha_entrada }}" required>
            </div>

            {{-- ALMACENISTA --}}
            <div class="col-md-4 mb-3">
                <label class="fw-bold">Almacenista Responsable</label>
                <select name="almacenista_id" class="form-control" required>
                    @foreach ($almacenistas as $a)
                        <option value="{{ $a->id }}"
                            {{ $entrada->almacenista_id == $a->id ? 'selected' : '' }}>
                            {{ $a->nombre }} {{ $a->apellido_paterno }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- DESCRIPCIÓN --}}
        <div class="mb-3">
            <label class="fw-bold">Descripción</label>
            <textarea name="descripcion" rows="3" class="form-control">{{ $entrada->descripcion }}</textarea>
        </div>

        <a href="{{ route('almacen.index') }}" class="btn btn-outline-dark mt-3">
            Cancelar
        </a>

        <button class="btn btn-pink mt-3" style="background:#c71585; color:white;">
            Actualizar Entrada
        </button>

    </form>

</div>

@endsection
