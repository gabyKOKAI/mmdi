@extends('layouts.master')

@section('title')
    Nuevo Proyecto
@endsection

@section('content')
    <h1>Nuevo Proyecto</h1>

    <form method='POST' action='/proyecto/guarda'>
	 {{ csrf_field() }}

        <label for='nombre'>Nombre del Proyecto:</label>
		<input type='text' name='nombre' id='nombre' value='{{ old('nombre') }}'>

        <br>
        <input type='submit' value='Agrega Proyecto' class='btn btn-primary btn-small'>
		
    </form>
@endsection