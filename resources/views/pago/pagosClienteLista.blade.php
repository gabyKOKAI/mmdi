@extends('layouts.master')

@push('head')
    <!--link href="/css/cliente.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    @include('pago.pagoFiltros')
    <div class="divPagosCliente">
        @include('pago.tablaPagos')
    </div>
@endsection