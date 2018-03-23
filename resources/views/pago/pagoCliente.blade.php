@extends('layouts.master')

@section('title')
    Pago Clientes
@endsection

@push('head')
    <!--link href="/css/cliente.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    @include('pago.pago')
@endsection