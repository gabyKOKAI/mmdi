@extends('layouts.master')

@push('head')
    <link href="/css/proyecto.css" type='text/css' rel='stylesheet'>
@endpush

@section('content')
    @include('proyecto.proyectoFiltros')
    @include('proyecto.tablaProyectos')
@endsection

@push('body')
    <script src="/js/proyectos/lista.js"></script>
@endpush