@extends('layouts.app')

@section('content')

<div class="container py-5">

    <h2 class="fw-bold mb-4">
        Categoría: {{ $categoria->nombre }}
    </h2>

    <div class="row">

        @foreach ($productos as $p)
        <div class="col-md-3 text-center mb-4">
            
            <img src="{{ asset('img/' . $p->imagen) }}"
                 class="img-fluid"
                 style="height: 180px; object-fit: contain;">
            
            <p class="fw-semibold mt-2">{{ $p->nombre }}</p>

        </div>
        @endforeach

    </div>
            <a href="{{ route('tienda.index') }}" 
           class="btn btn-outline-dark mt-3 w-100 fw-bold">
            Regresar
        </a>

</div>

@endsection
