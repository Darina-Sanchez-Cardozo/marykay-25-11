@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <!-- TITULO -->
    <h2 class="text-center fw-bold mb-4" style="letter-spacing:1px;">
        SU COMPRA SE COMPLETÓ EXITOSAMENTE.
    </h2>

    <div class="row justify-content-center">

        <div class="col-md-6">

            <!-- MENSAJE PRINCIPAL -->
            <p class="fs-5">
                Su paquete está en proceso. Podrá monitorear el recorrido de hasta llegar a su destino.
            </p>

            <p class="fs-5 fw-semibold mt-4">
                Muchas gracias por su compra.
            </p>

            <p class="mt-4 fw-bold">Satisfacción Garantizada</p>

            <p class="text-muted" style="font-size:14px;">
                Todos los productos Mary Kay cuentan con la Garantía de Satisfacción Garantizada.
            </p>

        </div>


    </div>
</div>
<a href="{{ route('tienda.index') }}" class="btn btn-light mt-3">
    ← Volver al inicio
</a>


@endsection
