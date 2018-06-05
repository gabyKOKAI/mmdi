@extends('layouts.master')

@push('head')
    <!--link href="/css/elemento.css" type='text/css' rel='stylesheet'-->
@endpush

@if($idCon == -1)
    @section('breadcrumbs', Breadcrumbs::render('elemento', $elemento))
@else
    @section('breadcrumbs', Breadcrumbs::render('conceptosElemento', $elemento, $idCon))
@endif

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 align-center">
               @if($elemento->id != -1)
                    <!--h1 class="center">[{{$elemento->id}}] Elemento (PU) '{{$elemento->nombre}}' </h1-->
                    <form method='GET' action='/elemento/guardar/{{$elemento->id}}/{{$idCon}}'>
               @else
                    <!--h1 class="center">Nuevo Elemento (PU)</h1-->
                    <form method='GET' action='/elemento/guardar/-1/{{$idCon}}'>
               @endif
                       {{ csrf_field() }}
                       <input type="hidden" name="_method" value="PUT">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="container center">
                            <div class="row">
                                <div class="col-sm-1 container center">
                                </div>
                                <div class="col-sm-6">
                                    <div class="container center">
                                        <div class="row">
                                            <div class="col-sm-4 form-group required control-label" align="left">
                                                <label for='nombre'>Nombre Elemento (PU)</label>
                                                <input type='text' name='nombre' id='nombre' value='{{$elemento->nombre}}'  class="form-control" required>
                                            </div>
                                            <div class="col-sm-2 form-group required control-label" align="left">
                                                <label for='tipo'>Tipo</label>
                                                <select name="tipo"  class="form-control" required>
                                                    @foreach($tiposForDropdown as $tipo)
                                                        <option value="{{ $tipo }}" {{ $tipo == $tipoSelected ? 'selected="selected"' : '' }}> {{ $tipo }} </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 form-group required control-label" align="left">
                                                <label for='proveedor_id'>Proveedor</label>
                                                <input type="hidden" name="proveedor_id" value="{{$proveedorSelected}}" required>
                                                @if($proveedorSelected!=-1)
                                                    <a href="{{ URL::to('proveedor/'.$proveedorSelected)}}" class="glyphicon glyphicon-edit"></a>
                                                    <select name="proveedor_id"  class="form-control" disabled>

                                                @else
                                                    <a href="{{ URL::to('proveedor/-1')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                                    <select name="proveedor_id"  class="form-control">
                                                @endif

                                                    @foreach($proveedoresForDropdown as $proveedor)
                                                        <option value="{{ $proveedor->id }}" {{ $proveedor->id == $proveedorSelected ? 'selected="selected"' : '' }}> {{ $proveedor->nombre }} </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="col-sm-2 form-group required control-label" align="left">
                                                <label for='unidades'>Unidades</label>
                                                <input type='text' name='unidades' id='unidades' value='{{$elemento->unidades}}' class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="col-sm-12 container center">
                                        <div class="row">
                                            <div class="col-sm-12" align="left">
                                                <label for='comentario'>Comentario</label>
                                                <textarea name='comentario' id='comentario' maxlength="250" rows="5"  class="form-control" >{{$elemento->comentario}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-sm-3 container center">
                                    </div>
                                    <div class="col-sm-6 container center divPunteado">
                                        <div class="row">
                                            <div class="col-sm-12" align="center">
                                                <!--h4>Precio</h4-->
                                                <br>
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-sm-4 form-group required control-label" align="left">
                                                <label for='costo'>Costo</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">$</span>
                                                    <input type='number' name='costo' id='costo' step='0.01' value='{{$elemento->costo}}' class='float form-control'>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 form-group required control-label" align="left">
                                                <label for='ganancia'>Ganancia</label>
                                                <div class="input-group">
                                                    @if (str_contains($tipoGananciaSelected, '$'))
                                                        <span class="input-group-addon">$</span>
                                                    @else
                                                        <span class="input-group-addon">%</span>
                                                    @endif
                                                    <input type='number' name='ganancia' id='ganancia' step='0.01' value='{{$elemento->ganancia}}' class='float form-control'>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 form-group required control-label" align="left">
                                                <label for='tipo_ganancia'>Tipo Ganancia</label>
                                                <select name="tipo_ganancia"  class="form-control" required>
                                                    @foreach($tiposGananciasForDropdown as $tipoGanancia)
                                                        <option value="{{ $tipoGanancia }}" {{ $tipoGanancia == $tipoGananciaSelected ? 'selected="selected"' : '' }}> {{ $tipoGanancia }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                       </div>
                                        <div class="row">
                                            <div class="col-sm-12 font200 bold" align="center">
                                                <label>Precio:</label> $ {{$elemento->precio}}
                                            </div>
                                       </div>
                                    </div>
                                </div>

                            </div>
                        </div>
						<div class="container center">
                            <div class="row">
                                <div class="col-sm-12 align-self-center">
                                    <br>
                                    <input type='submit' value='Guarda Elemento' class='btn btn-primary btn-small'>
                                </div>
                            </div>
                        </div>

               </form>
			</div>
		</div>
    </div>

@endsection