@extends('layouts.master')

@push('head')
    <!--link href="/css/proveedore.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    @include('pago.pagoFiltros')
    @include('pago.tablaPagos')
@endsection