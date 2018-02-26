@extends('layouts.master')

@section('title')
    Cotizacion
@endsection

@push('head')
    <!--link href="/css/cotizacion.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 align-center">
                @if($cotizacion->id != -1)
                    <h1 class="center">[{{$cotizacion->id}}] Cotizacion {{$cotizacion->nombre}}</h1>
                     <form method='GET' action='/cotizacion/guardar/{{$cotizacion->id}}'>
               @else
                    <h1 class="center">Nueva Cotizacion</h1>
                    <form method='GET' action='/cotizacion/guardar/-1'>
               @endif
                       {{ csrf_field() }}
                       <input type="hidden" name="_method" value="PUT">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="container center">
                            <div class="row">
                                <div class="col-sm-12" align="left">
                                    <hr>
                                </div>
                                <div class="col-sm-4" align="left">
                                    <div class="container center col-sm-12">
                                       <div class="row">
                                            <div class="col-sm-12 form-group required control-label" align="left">
                                                    <label for='descripcion'>Descripcion</label>
                                                    <input type='text' name='descripcion' id='descripcion' value='{{$cotizacion->descripcion}}'  class="form-control" required>
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-sm-12 form-group required control-label" align="left">
                                                <label for='proveedor_id'>Proveedor</label>
                                                <a href="{{ URL::to('proveedor/-1')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                                @if($proveedorSelected!=-1)
                                                    <a href="{{ URL::to('proveedor/'.$proveedorSelected)}}" class="glyphicon glyphicon-edit"></a>
                                                @endif
                                                <select name="proveedor_id"  class="form-control" required>
                                                    @foreach($proveedoresForDropdown as $proveedor)
                                                        <option value="{{ $proveedor->id }}" {{ $proveedor->id == $proveedorSelected ? 'selected="selected"' : '' }}> {{ $proveedor->nombre }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-sm-12 form-group control-label" align="left">
                                                <label for='proyecto'>Proyecto</label>
                                                <a href="{{ URL::to('proyecto/-1')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                                @if($proyectoSelected!=-1)
                                                    <a href="{{ URL::to('proyecto/'.$proyectoSelected)}}" class="glyphicon glyphicon-edit"></a>
                                                @endif
                                                <select name="proyecto_id"  class="form-control">
                                                    <option value="---" {{ $cotizacion->id == -1 ? 'selected="selected"' : '' }}> {{ "---SIN PROYECTO---" }} </option>
                                                    @foreach($proyectosForDropdown as $proyecto)
                                                        <option value="{{ $proyecto->id }}" {{ $proyecto->id == $proyectoSelected ? 'selected="selected"' : '' }}> {{ $proyecto->nombre }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4" align="left">
                                    <div class="container center col-sm-12  ">
                                        <div class="row">
                                            <div class="col-sm-12 form-group required control-label" align="left">
                                                <label for='estatus'>Estatus</label>
                                                <br>
                                                <select name="estatus"  class="form-control" required>
                                                    @foreach($estatusForDropdown as $estatus)
                                                    <option value="{{ $estatus }}" {{ $estatus == $estatusSelected ? 'selected="selected"' : '' }}> {{ $estatus }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-sm-12 form-group required control-label" align="left">
                                                    <label for='monto'>Monto</label>
                                                    <input type='number' name='monto' id='monto' value='{{$cotizacion->monto}}'  class="form-control" required>
                                            </div>

                                       </div>
                                        <div class="row">
                                            <div class="col-sm-12 form-group control-label" align="left">
                                                <br>
                                                <input type="checkbox" class="form-check-input" id="con_iva" name="con_iva" value="1" {{ $cotizacion->con_iva ? 'checked="checked"' : ''}}>Con IVA</input>
                                            </div>
                                       </div>
                                    </div>
                                </div>
                                <div class="col-sm-4" align="left">
                                    <div class="col-sm-12 container center">
                                        @if($cotizacion->id != -1)
                                         <div class="row">
                                            <div class="col-sm-2" align="center">
                                            <br>
                                            </div>
                                            <div class="col-sm-8 divProveedores" align="center">
                                                <div class="row">
                                                    <div class="col-sm-12" align="center">
                                                        <h4 class="glyphicon glyphicon-bookmark">Pagos a Proveedor</h4>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="left">
                                                        <label>Efectivo:</label> $ {{$cotizacion->efectivo}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="left">
                                                        <label>Transferencia:</label> $ {{$cotizacion->transferencias}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="left">
                                                        <label>Cheques:</label> $ {{$cotizacion->cheques}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="center">
                                                        <label>SALDO:</label> $ {{$cotizacion->saldo}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container center">
                            <div class="row">
                                <div class="col-sm-12 align-self-center">
                                    @if($cotizacion)
                                        <input type='submit' value='Guarda Cotizacion' class='btn btn-primary btn-small'>
                                    @else
                                        <input type='submit' value='Crear Cotizacion' class='btn btn-primary btn-small'>
                                    @endif
                                </div>
                            </div>
                        </div>

               </form>
			</div>
		</div>
    </div>

@endsection