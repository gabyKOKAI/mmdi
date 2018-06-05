@extends('layouts.master')

@push('head')
    <!--link href="/css/concepto.css" type='text/css' rel='stylesheet'-->
@endpush

@section('breadcrumbs', Breadcrumbs::render('concepto', $concepto, $idProy))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 align-center">
                @if($concepto->id != -1)
                    <!--h1 class="center">Concepto '{{$concepto->nombre}}' de proyecto  '{{$concepto->proyecto->nombre}}' </h1-->
                     <form method='GET' action='/concepto/guardar/{{$concepto->id}}'>
               @else
                    <!--h1 class="center">Nuevo Concepto</h1-->
                    <form method='GET' action='/concepto/guardar/-1'>
               @endif
                       {{ csrf_field() }}
                       <input type="hidden" name="_method" value="PUT">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="container center">
                            <div class="row">
                                <div class="col-sm-4" align="left">
                                    <div class="container center">
                                       <!--div class="row">
                                            <div class="col-sm-12" align="left">
                                                <hr>
                                            </div>
									    </div-->
                                       <div class="row">
                                            <div class="col-sm-4 form-group required control-label" align="left">
                                                    <label for='nombre'>Concepto</label>
                                                    <br>
                                                    <textarea name='nombre' id='nombre' maxlength="250" rows="2"  class="form-control" required>{{$concepto->nombre}}</textarea>
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-sm-1  form-group required control-label"" align="left">
                                                <label for='cantidad'>Cantidad</label>
                                                @if($proyectoCon->distribuido == 0 and $concepto->adicional == 0)
                                                    <input type='number' name='cantidad' id='cantidad' min="0" value='{{$concepto->cantidad}}' class='numero form-control' required>
                                                @elseif($proyectoCon->adicionalesDistribuido == 0 and $concepto->adicional == 1)
                                                    <input type='number' name='cantidad' id='cantidad' min="0" value='{{$concepto->cantidad}}' class='numero form-control' required>
                                                @else
                                                    <input type="hidden" name="cantidad" value="{{$concepto->cantidad}}">
                                                    <input type='number' name='cantidad' id='cantidad' min="0" value='{{$concepto->cantidad}}' class='numero form-control' disabled>
                                                @endif


                                            </div>
                                            <div class="col-sm-2 form-group required control-label" align="left">
                                                <label for='unidades'>Unidades</label>
                                                <br>
                                                <input type='text' name='unidades' id='unidades' value='{{$concepto->unidades}}' class="form-control" required>
                                            </div>
                                            <div class="col-sm-2 form-group control-label" align="left">
                                                @if($proyectoCon->distribuido == 0)
                                                        <input type="checkbox" class="form-check-input" id="adicional" name="adicional" value="1" {{ $concepto->adicional ? 'checked="checked"' : ''}}>Adicional</input>
                                                @else
                                                    <input type="hidden" name="adicional" value="{{$concepto->adicional}}">
                                                    <input type="checkbox" class="form-check-input" id="adicional" name="adicional" value="1" {{ $concepto->adicional ? 'checked="checked"' : ''}} disabled>Adicional</input>
                                                @endif
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-sm-4 form-group required control-label" align="left">
                                                <label for='proyecto_id'>Proyecto</label>

                                                @if($proyectoSelected != -1)
                                                    <a href="{{ URL::to('proyecto/'.$proyectoSelected) }}"  class="glyphicon glyphicon-edit"></a>
                                                    <input type="hidden" name="proyecto_id" value="{{$proyectoSelected}}" required>
                                                    <select name="proyecto_id"  class="form-control" disabled>
                                                @else
                                                    <select name="proyecto_id"  class="form-control">
                                                @endif
                                                    @foreach($proyectosForDropdown as $proyecto)
                                                    <option value="{{ $proyecto->id }}" {{ $proyecto->id == $proyectoSelected ? 'selected="selected"' : '' }}> {{ $proyecto->nombre }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                       <!--div class="row">
                                            <div class="col-sm-2 form-group required control-label" align="left">
                                                <label for='estatus'>Estatus</label>
                                                <select name="estatus"  class="form-control" required>
                                                    @foreach($estatusForDropdown as $estatus)
                                                    <option value="{{ $estatus }}" {{ $estatus == $estatusSelected ? 'selected="selected"' : '' }}> {{ $estatus }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 form-group control-label" align="left">
                                                @if($proyectoCon->distribuido == 0)
                                                        <input type="checkbox" class="form-check-input" id="adicional" name="adicional" value="1" {{ $concepto->adicional ? 'checked="checked"' : ''}}>Adicional</input>
                                                @else
                                                    <input type="hidden" name="adicional" value="{{$concepto->adicional}}">
                                                    <input type="checkbox" class="form-check-input" id="adicional" name="adicional" value="1" {{ $concepto->adicional ? 'checked="checked"' : ''}} disabled>Adicional</input>
                                                @endif
                                            </div>
                                       </div-->
                                    </div>
                                </div>
                                <div class="col-sm-4" align="left">
                                    <div class="col-sm-12 container center">
                                       <!--div class="row">
                                            <div class="col-sm-4" align="left">
                                                <hr>
                                            </div>
									    </div-->
										<div class="row">
                                             <div class="col-sm-5 form-group required control-label" align="left">
                                                <label for='fecha'>Fecha</label>
                                                <input type="hidden" name="fecha" value="{{$concepto->fecha}}">
                                                <label for='fecha' class="form-control" disabled>{{$concepto->fecha}}</label>
                                             </div>
                                       </div>
                                       <div class="row">
                                             <div class="col-sm-12" align="left">
                                                <label for='comentario'>Comentario</label>
                                                <br>
                                                <textarea name='comentario' id='comentario' maxlength="250" rows="5"  class="form-control" >{{$concepto->comentario}}</textarea>
                                             </div>
                                       </div>
                                    </div>
                                </div>
                                <div class="col-sm-4" align="left">
								    <div class="col-sm-12 container center">
								        <!--div class="row">
                                            <div class="col-sm-4" align="left">
                                                <hr>
                                            </div>
										</div-->
                                       <div class="row">
                                            <div class="col-sm-10 divPagos" align="center">
                                                <div class="row">
                                                    <div class="col-sm-12" align="center">
                                                        <h4 class="glyphicon glyphicon-bookmark">Resumen Total Cliente</h4>
                                                    </div>
                                                </div>
                                                 <div class="row">
                                                    <div class="col-sm-5 " align="right">

                                                    </div>
                                                    <div class="col-sm-3 " align="center">
                                                       <label>P/U</label>
                                                    </div>
                                                    <div class="col-sm-3 " align="center">
                                                        <label>Total</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-5 " align="right">
                                                        <label>Costo:</label>
                                                    </div>
                                                    <div class="col-sm-3 " align="left">
                                                        ${{$concepto->costo}}
                                                    </div>
                                                    <div class="col-sm-3 " align="left">
                                                        ${{$concepto->costoTotal}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-5 " align="right">
                                                        <label>Ganancia:</label>
                                                    </div>
                                                    <div class="col-sm-3 " align="left">
                                                        ${{$concepto->ganancia}}
                                                    </div>
                                                    <div class="col-sm-3 " align="left">
                                                        ${{$concepto->gananciaTotal}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-5 " align="right">
                                                        <label>Precio</label>
                                                    </div>
                                                    <div class="col-sm-3 " align="left">
                                                        ${{$concepto->precioCliente}}
                                                    </div>
                                                    <div class="col-sm-3 fontBold" align="left">
                                                        ${{$concepto->precioTotal}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


						<div class="container center">
                            <div class="row">
                                <div class="col-sm-12 align-self-center">
                                    @if($concepto)
                                        <input type='submit' value='Guarda Concepto' class='btn btn-primary btn-small'>
                                        @if($proyectoCon->distribuido == 0 and $concepto->adicional == 0)
                                            <a href="{{ URL::to('concepto/eliminar/'.$concepto->id)}}" class="glyphicon glyphicon-trash"></a>
                                        @elseif($proyectoCon->adicionalesDistribuido == 0 and $concepto->adicional == 1)
                                            <a href="{{ URL::to('concepto/eliminar/'.$concepto->id)}}" class="glyphicon glyphicon-trash"></a>
                                        @endif
                                    @else
                                        <input type='submit' value='Crear Concepto' class='btn btn-primary btn-small'>
                                    @endif
                                </div>
                            </div>
                        </div>

               </form>
			</div>
		</div>
        @include('elemento.tablaElementos')
    </div>

@endsection