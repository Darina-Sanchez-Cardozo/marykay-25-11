@extends('layouts.app')

@section('content')

<div class="container py-5">
    <h2 class="text-center mb-4 fw-bold">Método de pago</h2>

    <div class="card shadow p-4 mx-auto" style="max-width: 700px;">

        <h5 class="mb-4 fw-bold">Tarjeta de Crédito/Débito</h5>

        <form>

            {{-- Número de tarjeta --}}
            <input type="text" 
                   class="form-control mb-3"
                   maxlength="16"
                   placeholder="0000 0000 0000 0000"
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">

            {{-- Fecha + CVV --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <input type="text"
                           class="form-control"
                           placeholder="MM/YY"
                           maxlength="5"
                           oninput="formatFecha(this)">
                </div>

                <div class="col-md-6 mb-3">
                    <input type="text"
                           class="form-control"
                           placeholder="CVV"
                           maxlength="3"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
            </div>

            {{-- Nombre --}}
            <input type="text" 
                   class="form-control mb-3"
                   placeholder="Nombre del titular de la tarjeta">

            {{-- TOTAL --}}
            <input type="text" 
       class="form-control mb-4"
       value="{{ number_format($total, 2) }}"
       readonly>


            {{-- Botones --}}
            <div class="text-center">
                <a href="{{ route('compra.exitosa') }}" class="btn btn-dark px-4"> Paga ahora.</a>


<a href="javascript:history.back();" 
   class="btn btn-secondary ms-2 px-4">Cancelar</a>

            </div>

        </form>
    </div>
</div>

{{-- SCRIPT PARA FORMATEAR LA FECHA --}}
<script>
function formatFecha(input) {
    let valor = input.value.replace(/[^0-9]/g, '');

    if (valor.length >= 3) {
        input.value = valor.substring(0,2) + '/' + valor.substring(2,4);
    } else {
        input.value = valor;
    }
}
</script>

@endsection
