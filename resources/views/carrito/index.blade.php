@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="row">
        {{-- Columna izquierda: compras --}}
        <div class="col-md-8">

            <h4 class="fw-bold mb-3">Compras</h4>

            @php
                // Si el controlador manda SOLO $detalle (un registro),
                // lo convertimos en una colección de 1 elemento.
                // Si manda $detalles (varios), los usamos tal cual.
                if (isset($detalle)) {
                    $items = collect([$detalle]);
                } else {
                    $items = $detalles ?? collect();
                }
            @endphp

            @foreach($items as $d)
                <div class="d-flex align-items-center border-bottom py-3">

                    {{-- Imagen --}}
                    <div class="me-3">
                        <img src="{{ asset('img/' . $d->producto->imagen) }}"
                             alt="Producto"
                             style="width:120px; height:120px; object-fit:contain;">
                    </div>

                    {{-- Info producto --}}
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">{{ $d->producto->nombre }}</h6>
                        <p class="mb-1 text-muted">
                            Precio: ${{ number_format($d->producto->precio_menudeo, 2) }} MXN
                        </p>
                        <p class="mb-1">
                            Subtotal:
                            <strong>${{ number_format($d->cantidad * $d->producto->precio_menudeo, 2) }} MXN</strong>
                        </p>

                        {{-- Cantidad (se actualiza al cambiar) --}}
                        <form action="{{ route('carrito.actualizar', $d->id) }}"
                              method="POST"
                              class="d-flex align-items-center mt-2">
                            @csrf
                            <label class="me-2 mb-0">Cantidad:</label>
                            <input type="number"
                                   name="cantidad"
                                   value="{{ $d->cantidad }}"
                                   min="1"
                                   class="form-control form-control-sm"
                                   style="width:70px;"
                                   onchange="this.form.submit();">
                        </form>
                    </div>

                    {{-- Botón eliminar --}}
                    <form action="{{ route('carrito.eliminar', $d->id) }}"
                          method="POST"
                          class="ms-3">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm">
                            Eliminar
                        </button>
                    </form>

                </div>
            @endforeach

{{-- Botones Next / Cancel --}}
<div class="mt-4 d-flex">

    <!-- Siguiente -->
   <a href="{{ route('tienda.metodo_pago') }}" class="btn btn-primary px-4">
   Ir a método de pago
</a>


    <!-- Cancelar -->
    <a href="{{ route('tienda.index') }}" class="btn btn-secondary">
        Cancelar
    </a>

</div>


        {{-- Columna derecha: resumen --}}
        <div class="col-md-4">

            <h4 class="fw-bold mb-3">Resumen</h4>


            <div class="d-flex justify-content-between mb-2">
                <span>Subtotal</span>
                <span>${{ number_format($subtotal, 2) }} MXN</span>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <span>Envío</span>
                @if($envio == 0 && $subtotal > 0)
                    <span>GRATIS</span>
                @else
                    <span>${{ number_format($envio, 2) }} MXN</span>
                @endif
            </div>

            <div class="d-flex justify-content-between fw-bold">
                <span>Total</span>
                <span>${{ number_format($total, 2) }} MXN</span>
            </div>
        </div>
    </div>

</div>

@endsection
