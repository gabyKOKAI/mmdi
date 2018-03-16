@extends('layouts.master')

@section('title')
    Elemento
@endsection

@push('head')
    <!--link href="/css/cliente.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 align-center">

               @if($cliente->id != -1)
                    <h1 class="center">[{{$cliente->id}}] Cliente {{$cliente->nombre}}
                    <!--a href="{{ URL::to('proyectos/'.$cliente->id)}}" class="glyphicon glyphicon-list-alt" title="Lista de Proyectos"></a>
                    <a href="{{ URL::to('proyecto/-1/'.$cliente->id)}}" class="glyphicon glyphicon glyphicon-plus-sign" title="Nuevo Proyecto"></a-->
                    </h1>
                     <form method='GET' action='/cliente/guardar/{{$cliente->id}}'>
               @else
                    <h1 class="center">Nuevo Cliente</h1>
                    <form method='GET' action='/cliente/guardar/-1'>
               @endif
                       {{ csrf_field() }}
                       <input type="hidden" name="_method" value="PUT">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="container center">
                            <div class="row">
                                <div class="col-sm-6" align="left">
                                    <div class="container center">
                                        <div class="row">
                                            <div class="col-sm-2">
                                            </div>
                                            <div class="col-sm-4 form-group required control-label" align="left">
                                                <label for='nombre'>Nombre</label>
                                                <input type='text' name='nombre' id='nombre' value='{{$cliente->nombre}}'  class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2">
                                            </div>
                                            <div class="col-sm-4 form-group control-label" align="left">
                                                <label for='descripcion'>Descripción</label>
                                                <input type='text' name='descripcion' id='descripcion' value='{{$cliente->descripcion}}'  class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6" align="left">
                                    <div class="container center">
                                        <div class="row">
                                            <div class="col-sm-4 control-label" align="left">
                                                <label for='comentario'>Comentario</label>
                                                <textarea name='comentario' id='comentario' maxlength="250" rows="5"  class="form-control" >{{$cliente->comentario}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1" align="left">
                                </div>
                                <div class="col-sm-2 form-group control-label" align="left">
                                    <label for='rfc'>RFC</label>
                                    <input type='text' name='rfc' id='rfc' value='{{$cliente->rfc}}'  class="form-control">
                                </div>
                                <div class="col-sm-4 form-group control-label" align="left">
                                    <label for='razonSocial'>Razón Social</label>
                                    <input type='text' name='razonSocial' id='razonSocial' value='{{$cliente->razon_social}}'  class="form-control">
                                </div>
                                 <div class="col-sm-4 form-group control-label" align="left">
                                    <label for='correoFactura'>Correo Factura</label>
                                    <input type='text' name='correoFactura' id='correoFactura' value='{{$cliente->correo_factura}}'  class="form-control">
                                </div>
                            </div>
                        </div>

						<div class="container center">
                            <div class="row">
                                <div class="col-sm-12 align-self-center">
                                    <br>
                                    <input type='submit' value='Guarda Cliente' class='btn btn-primary btn-small'>
                                </div>
                            </div>
                        </div>

               </form>
			</div>
		</div>
		@include('contacto.tablaContactos')
		@include('pago.tablaPagos')
		@include('proyecto.tablaProyectos')
    </div>

@endsection