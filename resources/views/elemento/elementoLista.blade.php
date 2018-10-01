@extends('layouts.master')

@push('head')
    <!--link href="/css/elemento.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    @include('elemento.elementoFiltros')
    @include('elemento.tablaElementos')
@endsection