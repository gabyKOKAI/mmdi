@extends('layouts.master')

@push('head')
    <!--link href="/css/concepto.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 align-center">

                @if($concepto->id != -1)
                    <h1 class="center">Concepto '{{$concepto->nombre}}' de proyecto  '{{$concepto->proyecto->nombre}}' </h1>
                     <form method='GET' action='/concepto/guardar/{{$concepto->id}}'>
               @else
                    <h1 class="center">Nuevo Concepto</h1>
                    <form method='GET' action='/concepto/guardar/-1'>
               @endif
                       {{ csrf_field() }}
                       <input type="hidden" name="_method" value="PUT">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="container center">
                            <div class="row">
                                <div class="col-sm-4" align="left">
                                    <div class="container center">
                                       <div class="row">	
                                            <div class="col-sm-12" align="left">
                                                <hr>
                                            </div>
									    </div>
                                       <div class="row">
                                            <div class="col-sm-4 form-group required control-label" align="left">
                                                    <label for='nombre'>Concepto</label>
                                                    <br>
                                                    <input type='text' name='nombre' id='nombre' value='{{$concepto->nombre}}'  class="form-control" required>
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
                                       </div>
                                       <div class="row">
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
                                       </div>
                                    </div>
                                </div>
                                <div class="col-sm-4" align="left">
                                    <div class="col-sm-12 container center">
                                       <div class="row">
                                            <div class="col-sm-4" align="left">
                                                <hr>
                                            </div>
										</div>
                                       <div class="row">
                                             <div class="col-sm-12 form-group required control-label" align="left">
                                                <label for='fecha'>Fecha</label>
                                                <input type="hidden" name="fecha" value="{{$concepto->fecha}}">
                                                @if($concepto->id == -1)
                                                    <input type='date' name='fecha' id='fecha' value='{{$concepto->fecha}}' class="form-control"  disabled>
                                                @else
                                                    <input type='date' name='fecha' id='fecha' value='{{$concepto->fecha}}' class="form-control" disabled>
                                                @endif

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
								    <div class="row">
                                            <div class="col-sm-4" align="left">
                                                <hr>
                                            </div>
										</div>
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
                                                        $ {{$concepto->costo}}
                                                    </div>
                                                    <div class="col-sm-3 " align="left">
                                                        $ {{$concepto->costoTotal}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-5 " align="right">
                                                        <label>Ganancia:</label>
                                                    </div>
                                                    <div class="col-sm-3 " align="left">
                                                        $ {{$concepto->ganancia}}
                                                    </div>
                                                    <div class="col-sm-3 " align="left">
                                                        $ {{$concepto->gananciaTotal}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-5 " align="right">
                                                        <label>Precio</label>
                                                    </div>
                                                    <div class="col-sm-3 " align="left">
                                                        $ {{$concepto->precioCliente}}
                                                    </div>
                                                    <div class="col-sm-3 fontBold" align="left">
                                                        $ {{$concepto->precioTotal}}
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

        <div class="row">
			<div class="col-sm-12 align-right">
                @if($concepto)
                      <div class="container">
                            <div class="row">
                                <div class="col-sm-4 align-left">
                                    <hr>
                                </div>
                                <div class="col-sm-4 align-center">
                                     <h3 class="center">Elementos (Precios Unitarios)   </h3>
                                </div>
                                <div class="col-sm-4 align-left">
                                    <hr>
                                </div>
                            </div>
                        </div>

                        @if(count($elementos)>0)
                            <div class="container center">
                                <div class="row">
                                    <div class="col-sm-12 align-self-center">

                                    <table class="table table-hover table-striped .table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <!--th class="center">#</th-->
                                                <th class="center">Elemento (PU)</th>
                                                <th class="center">Tipo </th>
                                                <th class="center">Proveedor</th>
                                                <th class="center">Unidades</th>
                                                <th class="center">Costo</th>
                                                <th class="center">Ganancia</th>
                                                <!--th class="center">Precio</th-->
                                                <th class="center">Precio Cliente</th>
                                                <th class="center">
                                                    @if($concepto->id != -1)
                                                        @if($proyectoCon->distribuido == 0 and $concepto->adicional == 0)
                                                            <a href="{{URL::to('conceptoElemento/'.$concepto->id.'/-1/1')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                                        @elseif($proyectoCon->adicionalesDistribuido == 0 and $concepto->adicional == 1)
                                                            <a href="{{URL::to('conceptoElemento/'.$concepto->id.'/-1/1')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                                        @endif
                                                    @endif
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             @foreach($elementos as $elemento)
                                                <tr>
                                                    <!--td> <a href="{{ URL::to('conceptoElemento/' . $concepto->id.'/'.$elemento->id) }}">{{$elemento->id}}</a></td-->
                                                    <td> {{$elemento->nombre.'(CGT:'.$elemento->costo.'-'.$elemento->ganancia.'-'.$elemento->tipo_ganancia.')'}}</a></td>
                                                    <td>{{$elemento->tipo}}</td>
                                                    <td>{{$elemento->proveedor->nombre}}</td>
                                                    <td>{{$elemento->unidades}}</td>
                                                    <td>$ {{$elemento->costoCliente}}</td>
                                                    <td>$ {{$elemento->precioCliente - $elemento->costoCliente}}</td>
                                                    <!--td>{{$elemento->precio}}</td-->
                                                    <td>$ {{$elemento->precioCliente}}</td>
                                                    <td>

                                                        @if($proyectoCon->distribuido == 0 and $concepto->adicional == 0)
                                                            <a href="{{ URL::to('conceptoElemento/' . $concepto->id.'/'.$elemento->id).'/1'}}" class="glyphicon glyphicon-edit"></a>
                                                            <a href="{{ URL::to('conceptoElemento/eliminar/'.$concepto->id.'/'.$elemento->id)}}" class="glyphicon glyphicon-trash"></a>
                                                        @elseif($proyectoCon->adicionalesDistribuido == 0 and $concepto->adicional == 1)
                                                            <a href="{{ URL::to('conceptoElemento/' . $concepto->id.'/'.$elemento->id.'/1')}}" class="glyphicon glyphicon-edit"></a>
                                                            <a href="{{ URL::to('conceptoElemento/eliminar/'.$concepto->id.'/'.$elemento->id)}}" class="glyphicon glyphicon-trash"></a>
                                                        @else
                                                            <a href="{{ URL::to('conceptoElemento/' . $concepto->id.'/'.$elemento->id.'/0')}}" class="glyphicon glyphicon-edit"></a>
                                                        @endif

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    </div>
                                </div>
                            </div>

							<div class="container center">
								<div class="row">
									<div class="col-sm-1 align-self-center">
									</div>
									<div class="col-sm-10 align-self-center">

										<!-- { {$proyectos->lastPage()} } -->
										<!-- { {$proyectos->hasMorePages()} } -->
										<!-- { {$proyectos->url()} } -->
										<!-- { {$proyectos->nextPageUrl()} } -->
										<!-- { {$proyectos->lastItem()} } -->
										<!-- { {$proyectos->firstItem()} } -->
										<!-- { {$proyectos->count()} } -->
										<!-- { {$proyectos->perPage()} } -->
										<!-- { {$proyectos->currentPage()} }-->
										{{--$elementos->render()--}}

									</div>
									<div class="col-sm-1 align-self-center">
									</div>
								</div>
							</div>

                    @else
                         <h4>Sin Elementos (Precios Unitarios)
                            @if($concepto->id != -1)
                                <a href="{{URL::to('conceptoElemento/'.$concepto->id.'/-1')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                            @endif
                        </h4>
                    @endif
                @endif
            </div>
        </div>
    </div>

@endsection