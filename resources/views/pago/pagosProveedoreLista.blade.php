@extends('layouts.master')

@section('title')
    Pagos de Proveedores
@endsection

@push('head')
    <!--link href="/css/proveedore.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    @include('pago.tablaPagos')
@endsection