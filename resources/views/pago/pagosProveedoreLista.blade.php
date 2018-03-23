@extends('layouts.master')

@section('title')
    Pagos Proveedores
@endsection

@push('head')
    <!--link href="/css/proveedore.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    @include('pago.tablaPagos')
@endsection