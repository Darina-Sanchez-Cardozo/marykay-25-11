@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h3 class="fw-bold mb-4">Validar Consultoras</h3>

    @if(session('success'))
        <div class="alert alert-success text-center fw-bold">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">

        {{-- LISTA DE CONSULTORAS --}}
        <div class="col-md-4">
            <div class="list-group shadow">

                <div class="list-group-item active fw-bold">
                    Consultoras registradas
                </div>

                @foreach($consultoras as $c)
                    <a href="{{ route('admin.consultoras.panel', $c->id) }}"
                       class="list-group-item list-group-item-action 
                              {{ isset($detalle) && $detalle->id == $c->id ? 'active' : '' }}">
                        {{ $loop->iteration }}. 
                        {{ $c->nombre }} {{ $c->apellido_paterno }}
                    </a>
                @endforeach

            </div>
        </div>

        {{-- DETALLE --}}
        <div class="col-md-8">

            @if(!$detalle)
                <div class="alert alert-secondary text-center">
                    Seleccione una consultora para ver su información.
                </div>
            @else

                <div class="card shadow p-4">

                    <h4 class="fw-bold mb-3">Información de la Consultora</h4>


                    <p><strong>Nombre completo:</strong>
                        {{ $detalle->nombre }} 
                        {{ $detalle->apellido_paterno }} 
                        {{ $detalle->apellido_materno }}
                    </p>

                    <p><strong>Correo:</strong> {{ $detalle->correo_electronico }}</p>

                    <p><strong>Teléfono:</strong> 
                        {{ $detalle->telefono ?? 'No registrado' }}
                    </p>

                    <p><strong>Dirección:</strong> 
                        {{ $detalle->direccion ?? 'Sin dirección registrada' }}
                    </p>

                    <p><strong>Fecha de nacimiento:</strong> 
                        {{ $detalle->fecha_nacimiento }}
                    </p>

                    <hr>

                    {{-- Botón ELIMINAR --}}
                    <form method="POST"
                          action="{{ route('admin.consultoras.destroy', $detalle->id) }}"
                          onsubmit="return confirm('¿Seguro que deseas eliminar esta consultora?')">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger w-100 fw-bold">
                            Eliminar consultora
                        </button>
                    </form>


                </div>
{{-- BOTÓN REGRESAR AL DASHBOARD --}}
<a href="{{ route('admin.dashboard') }}" 
   class="btn btn-secondary w-100 fw-bold mb-3">
    ← Regresar al Panel de Control
</a>

            @endif

        </div>

    </div>

</div>
@endsection
