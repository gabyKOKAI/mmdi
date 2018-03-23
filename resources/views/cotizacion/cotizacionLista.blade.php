@extends('layouts.master')

@push('head')
    <link href="/css/cotizacion.css" type='text/css' rel='stylesheet'>
@endpush

@section('content')
    @include('cotizacion.tablaCotizaciones')
@endsection

@push('body')
    <script src="/js/proyectos/lista.js"></script>
@endpush