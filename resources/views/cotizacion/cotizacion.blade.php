@extends('layouts.master')

@push('head')
    <!--link href="/css/cotizacion.css" type='text/css' rel='stylesheet'-->
@endpush

@section('breadcrumbs', Breadcrumbs::render('cotizacion', $cotizacione))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 align-center">
               @if($cotizacione->id != -1)
                    <!--h1 class="center">[{{$cotizacione->id}}] CXP {{$cotizacione->nombre}}</h1-->
                     <form method='GET' action='/cotizacion/guardar/{{$cotizacione->id}}'>
               @else
                    <!--h1 class="center">Nueva CXP</h1-->
                    <form method='GET' action='/cotizacion/guardar/-1'>
               @endif
                       {{ csrf_field() }}
                       <input type="hidden" name="_method" value="PUT">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="container center">
                            <div class="row">
                                <!--div class="col-sm-12" align="left">
                                    <hr>
                                </div-->
                                <div class="col-sm-4" align="left">
                                    <div class="container center col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-12 form-group required control-label" align="left">
                                                    <label for='nombre'>Nombre</label>
                                                    @if($cotizacione->id != -1)
                                                        <input type="hidden" name="nombre" value="{{$cotizacione->nombre}}">
                                                        <textarea name='nombre' id='nombre' maxlength="250" rows="4"  class="form-control" disabled>{{$cotizacione->nombre}}</textarea>
                                                    @else
                                                        <textarea name='nombre' id='nombre' maxlength="250" rows="4"  class="form-control" required>{{$cotizacione->nombre}}</textarea>
                                                    @endif
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-sm-12 form-group required control-label" align="left">
                                                <label for='proveedor_id'>Proveedor</label>
                                                @if($cotizacione->id == -1)
                                                    <a href="{{ URL::to('proveedor/-1/-2')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                                    <select name="proveedor_id"  class="form-control" required>
                                                @else
                                                    @if($proveedorSelected!=-1)
                                                        <a href="{{ URL::to('proveedor/'.$proveedorSelected.'/'.$cotizacione->id)}}" class="glyphicon glyphicon-edit"></a>
                                                    @endif
                                                    <!--a href="{{ URL::to('proveedor/-1/'.$cotizacione->id)}}" class="glyphicon glyphicon glyphicon-plus-sign"></a-->
                                                    <select name="proveedor_id"  class="form-control" disabled>
                                                @endif


                                                    @foreach($proveedoresForDropdown as $proveedor)
                                                        <option value="{{ $proveedor->id }}" {{ $proveedor->id == $proveedorSelected ? 'selected="selected"' : '' }}> {{ $proveedor->nombre }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-sm-12 form-group control-label" align="left">
                                                <label for='proyecto'>Proyecto</label>

                                                @if($proyectoSelected>0)
                                                    <a href="{{ URL::to('proyecto/'.$proyectoSelected)}}" class="glyphicon glyphicon-edit"></a>
                                                    <input type="hidden" name="proyecto_id" value="{{$proyectoSelected}}">
                                                    <select name="proyecto_id"  class="form-control" disabled>
                                                @else
                                                    <a href="{{ URL::to('proyecto/-1')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                                    <select name="proyecto_id"  class="form-control" required>
                                                @endif
                                                    <option value="---" {{ $cotizacione->id == -1 ? 'selected="selected"' : '' }}> {{ "---SIN PROYECTO---" }} </option>
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
                                            <div class="col-sm-12 form-group control-label" align="left">
                                                    <label for='descripcion'>Descripcion</label>
                                                    <input type='text' name='descripcion' id='descripcion' value='{{$cotizacione->descripcion}}'  class="form-control" required>
                                            </div>
                                       </div>
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
                                            <div class="col-sm-8 form-group required control-label" align="left">
                                                    <label for='monto'>Monto</label>
                                                    <input type='number' name='monto' id='monto' value='{{$cotizacione->monto}}'  class="form-control" required>
                                            </div>

                                            <div class="col-sm-4 form-group control-label" align="left">
                                                <br>
                                                <input type="checkbox" class="form-check-input" id="con_iva" name="con_iva" value="1" {{ $cotizacione->con_iva ? 'checked="checked"' : ''}}>Con IVA</input>
                                            </div>
                                       </div>
                                    </div>
                                </div>
                                <div class="col-sm-4" align="left">
                                    <div class="col-sm-12 container center">
                                        @if($cotizacione->id != -1)
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
                                                        <label>Efectivo:</label> $ {{$cotizacione->efectivo}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="left">
                                                        <label>Transferencia:</label> $ {{$cotizacione->transferencias}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="left">
                                                        <label>Cheques:</label> $ {{$cotizacione->cheques}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="center">
                                                        <label>SALDO:</label> $ {{$cotizacione->saldo}}
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
                                    @if($cotizacione)
                                        <input type='submit' value='Guarda CXP' class='btn btn-primary btn-small'>
                                    @else
                                        <input type='submit' value='Crear CXP' class='btn btn-primary btn-small'>
                                    @endif
                                </div>
                            </div>
                        </div>

               </form>
			</div>
		</div>
    </div>
@include('pago.tablaPagos')
@endsection