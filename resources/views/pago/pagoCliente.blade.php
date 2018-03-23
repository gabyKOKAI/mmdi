@extends('layouts.master')

@push('head')
    <!--link href="/css/cliente.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    @include('pago.pago')
@endsection