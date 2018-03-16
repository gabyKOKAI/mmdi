@extends('layouts.master')

@section('title')
    Lista Proyectos
@endsection

@push('head')
    <link href="/css/proyecto.css" type='text/css' rel='stylesheet'>
@endpush

@section('content')
    @include('proyecto.tablaProyectos')
@endsection

@push('body')
    <script src="/js/proyectos/lista.js"></script>
@endpush