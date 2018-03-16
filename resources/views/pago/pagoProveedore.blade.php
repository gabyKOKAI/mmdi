@extends('layouts.master')

@section('title')
    Elemento
@endsection

@push('head')
    <!--link href="/css/proveedor.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    @include('pago.pago')
@endsection