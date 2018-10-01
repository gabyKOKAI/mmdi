@extends('layouts.master')

@push('head')
    <!--link href="/css/cliente.css" type='text/css' rel='stylesheet'-->
@endpush

@section('breadcrumbs', Breadcrumbs::render('pagoCliente', $pago, $cliProvSelected, $proyCotiSelected))

@section('content')
    @include('pago.pago')
@endsection