@extends('layouts.master')

@push('head')
    <!--link href="/css/proveedor.css" type='text/css' rel='stylesheet'-->
@endpush

@section('breadcrumbs', Breadcrumbs::render('pagoProveedor', $pago, $cliProvSelected, $proyCotiSelected))

@section('content')
    @include('pago.pago')
@endsection