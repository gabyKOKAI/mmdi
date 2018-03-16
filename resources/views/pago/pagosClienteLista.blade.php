@extends('layouts.master')

@section('title')
    Pagos de Clientes
@endsection

@push('head')
    <!--link href="/css/cliente.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    @include('pago.tablaPagos')
@endsection