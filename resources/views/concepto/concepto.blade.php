@extends('layouts.master')

@section('title')
    Concepto
@endsection

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
                                                    <label for='nombre'>Nombre</label>
                                                    <br>
                                                    <input type='text' name='nombre' id='nombre' value='{{$concepto->nombre}}'  class="form-control" required>
                                            </div>
                                       </div>
									   <div class="row">
                                            <div class="col-sm-4 form-group required control-label" align="left">
                                                <label for='proyecto'>Proyecto</label>
                                                {{$proyectoSelected}}
                                                @if($proyectoSelected != -1)
                                                    <a href="{{ URL::to('proyecto/'.$proyectoSelected) }}"  class="glyphicon glyphicon-edit"></a>
                                                    <input type="hidden" name="proyecto" value="{{$proyectoSelected}}" required>
                                                    <select name="proyecto"  class="form-control" disabled>
                                                @else
                                                    <select name="proyecto"  class="form-control">
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
                                                <br>
                                                <input type='number' name='cantidad' id='cantidad' value='{{$concepto->cantidad}}' class='numero form-control' required>
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
                                                <br>
                                                <select name="estatus"  class="form-control" required>
                                                    @foreach($estatusForDropdown as $estatus)
                                                    <option value="{{ $estatus }}" {{ $estatus == $estatusSelected ? 'selected="selected"' : '' }}> {{ $estatus }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 form-group control-label" align="left">
                                                <br>
                                                <input type="checkbox" class="form-check-input" id="adicional" name="adicional" value="1" {{ $concepto->adicional ? 'checked="checked"' : ''}}>Adicional</input>
                                            </div>
                                       </div>
                                    </div>
                                </div>
                                <div class="col-sm-4" align="left">
                                    <div class="container center">
                                       <div class="row">
                                            <div class="col-sm-12" align="left">
                                                <hr>
                                            </div>
										</div>
                                       <div class="row">
                                             <div class="col-sm-4 form-group required control-label" align="left">
                                                <label for='fecha'>Fecha</label>
                                                <input type='date' name='fecha' id='fecha' value='{{$concepto->fecha}}' class="form-control"  placeholder="Type Your Email Address Here" required>
                                             </div>
                                       </div>
                                       <div class="row">
                                             <div class="col-sm-4" align="left">
                                                <label for='comentario'>Comentario</label>
                                                <br>
                                                <textarea name='comentario' id='comentario' maxlength="250" rows="5"  class="form-control" >{{$concepto->comentario}}</textarea>
                                             </div>
                                       </div>
                                    </div>
                                </div>
                                <div class="col-sm-4" align="left">
								    <div class="container center">
								    <div class="row">
                                            <div class="col-sm-12" align="left">
                                                <hr>
                                            </div>
										</div>
                                       <div class="row">
                                            <div class="col-sm-3 divPagos" align="center">
                                                <div class="row">
                                                    <div class="col-sm-12" align="center">
                                                        <h4 class="glyphicon glyphicon-bookmark">Resumen Precios y Ganancias</h4>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="left">
                                                        <label>Precio Cliente:</label> $ {{$concepto->precioCliente}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="left">
                                                        <label>Ganancia:</label> $ {{$concepto->ganancia}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="left">
                                                        <label>Precio Total Conepto:</label> $ {{$concepto->precioTotal}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="center">
                                                        <label>GANANCIA TOTAL:</label> $ {{$concepto->gananciaTotal}}
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
                                        <a href="{{ URL::to('concepto/eliminar/'.$concepto->id)}}" class="glyphicon glyphicon-trash"></a>
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
                                <hr>
                                <div class="col-sm-1 align-left">
                                </div>
                                <div class="col-sm-10 align-center">
                                     <h3 class="center">Elementos</h3>
                                </div>
                                <div class="col-sm-1 align-left">

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
                                                <th class="center">Nombre</th>
                                                <th class="center">Tipo </th>
                                                <th class="center">Proveedor</th>
                                                <th class="center">Unidades</th>
                                                <th class="center">Costo</th>
                                                <th class="center">Ganancia</th>
                                                <th class="center">Precio</th>
                                                <th class="center">Precio Cliente</th>
                                                <th class="center">
                                                    @if($concepto->id != -1)
                                                        <a href="{{URL::to('conceptoElemento/'.$concepto->id.'/-1')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                                    @endif
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             @foreach($elementos as $elemento)
                                                <tr>
                                                    <!--td> <a href="{{ URL::to('conceptoElemento/' . $concepto->id.'/'.$elemento->id) }}">{{$elemento->id}}</a></td-->
                                                    <td> {{$elemento->nombre}}</a></td>
                                                    <td>{{$elemento->tipo}}</td>
                                                    <td>{{$elemento->proveedor->nombre}}</td>
                                                    <td>{{$elemento->unidades}}</td>
                                                    <td>{{$elemento->costo}}</td>
                                                    <td>{{$elemento->ganancia}}</td>
                                                    <td>{{$elemento->precio}}</td>
                                                    <td>{{$elemento->precioCliente}}</td>
                                                    <td>
                                                        <a href="{{ URL::to('conceptoElemento/' . $concepto->id.'/'.$elemento->id)}}" class="glyphicon glyphicon-edit"></a>
                                                        <a href="{{ URL::to('conceptoElemento/eliminar/'.$concepto->id.'/'.$elemento->id)}}" class="glyphicon glyphicon-trash"></a>
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
                         <h4>Sin Elementos
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