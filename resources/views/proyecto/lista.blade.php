@extends('layouts.master')


@section('title')
    Show book
@endsection


@push('head')
    <link href="/css/proyectos/lista.css" type='text/css' rel='stylesheet'>
@endpush


@section('content')
    @if(true)
        <h1>Show book: </h1>
    @else
        <h1>No book chosen</h1>
    @endif
@endsection


@push('body')
    <script src="/js/proyectos/lista.js"></script>
@endpush