@extends('layouts.master')

@push('head')
    <!--link href="/css/proveedore.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 align-center">

               @if($proveedore->id != -1)
                    <h1 class="center">[{{$proveedore->id}}] Proveedor {{$proveedore->nombre}}
                    <!--a href="{{ URL::to('cotizaciones/'.$proveedore->id)}}" class="glyphicon glyphicon-list-alt" title="Lista de Cotizaciones"></a>
                    <a href="{{ URL::to('cotizacion/-1/'.$proveedore->id)}}" class="glyphicon glyphicon glyphicon-plus-sign" title="Nueva Cotizacion"></a-->
                    </h1>
                     <form method='GET' action='/proveedor/guardar/{{$proveedore->id}}'>
               @else
                    <h1 class="center">Nuevo Proveedor</h1>
                    <form method='GET' action='/proveedor/guardar/-1'>
               @endif
                       {{ csrf_field() }}
                       <input type="hidden" name="_method" value="PUT">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="container center">
                            <div class="row">
                                <div class="col-sm-6" align="left">
                                    <div class="container center">
                                        <div class="row">
                                            <div class="col-sm-1">
                                            </div>
                                            <div class="col-sm-5 form-group required control-label" align="left">
                                                <label for='nombre'>Nombre</label>
                                                <input type='text' name='nombre' id='nombre' value='{{$proveedore->nombre}}'  class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-1">
                                            </div>
                                            <div class="col-sm-5 form-group control-label" align="left">
                                                <label for='descripcion'>Descripción</label>
                                                <input type='text' name='descripcion' id='descripcion' value='{{$proveedore->descripcion}}'  class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6" align="left">
                                    <div class="container center">
                                        <div class="row">
                                            <div class="col-sm-4 control-label" align="left">
                                                <label for='comentario'>Comentario</label>
                                                <textarea name='comentario' id='comentario' maxlength="250" rows="5"  class="form-control" >{{$proveedore->comentario}}</textarea>
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
                                    <input type='text' name='rfc' id='rfc' value='{{$proveedore->rfc}}'  class="form-control">
                                </div>
                                <div class="col-sm-4 form-group control-label" align="left">
                                    <label for='razonSocial'>Razón Social</label>
                                    <input type='text' name='razonSocial' id='razonSocial' value='{{$proveedore->razon_social}}'  class="form-control">
                                </div>
                                 <div class="col-sm-3 form-group control-label" align="left">
                                    <label for='calle'>Calle</label>
                                    <input type='text' name='calle' id='calle' value='{{$proveedore->calle}}'  class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1" align="left">
                                </div>
                                <div class="col-sm-2 form-group control-label" align="left">
                                    <label for='delMun'>Delegación/Municipio</label>
                                    <input type='text' name='delMun' id='delMun' value='{{$proveedore->delegacion_municipio}}'  class="form-control">
                                </div>
                                <div class="col-sm-3 form-group control-label" align="left">
                                    <label for='colonia'>Colonia</label>
                                    <input type='text' name='colonia' id='colonia' value='{{$proveedore->colonia}}'  class="form-control">
                                </div>
                                 <div class="col-sm-3 form-group control-label" align="left">
                                    <label for='ciudad'>Ciudad</label>
                                    <input type='text' name='ciudad' id='ciudad' value='{{$proveedore->ciudad}}'  class="form-control">
                                </div>
                                <div class="col-sm-1 form-group control-label" align="left">
                                    <label for='cp'>C.P.</label>
                                    <input type='text' name='cp' id='cp' value='{{$proveedore->cp}}'  class="form-control">
                                </div>
                            </div>
                        </div>

						<div class="container center">
                            <div class="row">
                                <div class="col-sm-12 align-self-center">
                                    <br>
                                    <input type='submit' value='Guarda Proveedor' class='btn btn-primary btn-small'>
                                </div>
                            </div>
                        </div>

               </form>
			</div>
		</div>
		<!--@include('contacto.tablaContactos')-->
		@include('pago.tablaPagos')
		@include('cotizacion.tablaCotizaciones')
    </div>

@endsection