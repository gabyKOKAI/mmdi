@extends('layouts.master')

@section('title')
    Proyecto
@endsection

@push('head')
    <!--link href="/css/proyecto.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 align-center">
                @if($proyecto->id != -1)
                    <h1 class="center">[{{$proyecto->id}}] Proyecto {{$proyecto->nombre}}</h1>
                     <form method='GET' action='/proyecto/guardar/{{$proyecto->id}}'>
               @else
                    <h1 class="center">Nuevo Proyecto</h1>
                    <form method='GET' action='/proyecto/guardar/-1'>
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
                                            <div class="col-sm-4" align="center">
                                                <h4>Informacion General</h4>
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-sm-4 form-group required control-label" align="left">
                                                    <label for='nombre'>Nombre</label>
                                                    <input type='text' name='nombre' id='nombre' value='{{$proyecto->nombre}}'  class="form-control" required>
                                            </div>

                                       </div>
                                       <div class="row">
                                            <div class="col-sm-4 form-group required control-label" align="left">
                                                <label for='cliente'>Cliente</label>
                                                <a href="{{ URL::to('cliente/-1')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                                @if($clienteSelected!=-1)
                                                    <a href="{{ URL::to('cliente/'.$clienteSelected)}}" class="glyphicon glyphicon-edit"></a>
                                                @endif
                                                @if($proyecto->id == -1)
                                                    <select name="cliente_id"  class="form-control" required>
                                                @else
                                                    <input type="hidden" name="cliente_id" value="{{$clienteSelected}}">
                                                    <select name="cliente_id"  class="form-control" disabled>
                                                @endif
                                                    @foreach($clientesForDropdown as $cliente)
                                                        <option value="{{ $cliente->id }}" {{ $cliente->id == $clienteSelected ? 'selected="selected"' : '' }}> {{ $cliente->nombre }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-sm-4 form-group required control-label" align="left">
                                                <label for='estatus'>Estatus</label>
                                                @if($proyecto->adicionalesDistribuido == 0)
                                                    <select name="estatus"  class="form-control" required>
                                                @else
                                                    <input type="hidden" name="estatus" value="{{$estatusSelected}}">
                                                    <select name="estatus"  class="form-control" disabled>
                                                @endif

                                                    @foreach($estatusForDropdown as $estatus)
                                                    <option value="{{ $estatus }}" {{ $estatus == $estatusSelected ? 'selected="selected"' : '' }}> {{ $estatus }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-sm-4 text" align="left">
                                                <label for='descripcion'>Descripcion</label>
                                                <br>
                                                <textarea name='descripcion' id='descripcion' maxlength="190" rows="4"  class="form-control" >{{$proyecto->descripcion}}</textarea>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-4" align="left">
                                                <label for='direccion'>Direccion</label>
                                                <br>
                                                <textarea name='direccion' id='direccion' maxlength="190" rows="4"  class="form-control" >{{$proyecto->direccion}}</textarea>
                                             </div>
                                       </div>
                                       <div class="row">
                                             <div class="col-sm-4" align="left">
                                                <label for='comentario'>Comentario</label>
                                                <br>
                                                <textarea name='comentario' id='comentario' maxlength="250" rows="5"  class="form-control" >{{$proyecto->comentario}}</textarea>
                                             </div>
                                       </div>
                                    </div>
                                </div>
                                <div class="col-sm-4" align="left">
                                    <div class="col-sm-12 container center">
                                       <div class="row">
                                            <div class="col-sm-12" align="left">
                                                <hr>
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-sm-12" align="center">
                                                <h4>Gastos & Ganancias MMDI</h4>
                                            </div>
                                       </div>
                                       <div class="row">
                                             <div class="col-sm-6 form-group required control-label" align="left">
                                                <label for='gasto_viaticos'>Viaticos</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">$</span>
                                                    @if($proyecto->distribuido == 0)
                                                        <input type='number' name='gasto_viaticos' id='gasto_viaticos' step='0.01' value='{{$proyecto->gasto_viaticos}}' class='float form-control' required>
                                                    @else
                                                        <input type="hidden" name="gasto_viaticos" value="{{$proyecto->gasto_viaticos}}">
                                                        <input type='number' name='gasto_viaticos' id='gasto_viaticos' step='0.01' value='{{$proyecto->gasto_viaticos}}' class='float form-control' disabled>
                                                    @endif

                                                </div>
                                            </div>
                                             <div class="col-sm-6 form-group required control-label" align="left">
                                                <label for='gasto_IMSS'>IMSS</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">$</span>
                                                    @if($proyecto->distribuido == 0)
                                                        <input type='number' name='gasto_IMSS' id='gasto_IMSS' step='0.01' value='{{$proyecto->gasto_IMSS}}' class='float form-control'required>
                                                    @else
                                                        <input type="hidden" name="gasto_IMSS" value="{{$proyecto->gasto_IMSS}}">
                                                        <input type='number' name='gasto_IMSS' id='gasto_IMSS' step='0.01' value='{{$proyecto->gasto_IMSS}}' class='float form-control'disabled>
                                                    @endif

                                                </div>
                                             </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-sm-3" align="left">
                                            </div>
                                            <div class="col-sm-6 form-group required control-label" align="left">
                                                <label for='gasto_porc_errores'>Errores</label>
                                                <div class="input-group">
                                                    @if($proyecto->distribuido == 0)
                                                        <input type='number' name='gasto_porc_errores' id='gasto_porc_errores' value='{{$proyecto->gasto_porc_errores}}' class='form-control' required>
                                                    @else
                                                        <input type="hidden" name="gasto_porc_errores" value="{{$proyecto->gasto_porc_errores}}">
                                                        <input type='number' name='gasto_porc_errores' id='gasto_porc_errores' value='{{$proyecto->gasto_porc_errores}}' class='form-control' disabled>
                                                    @endif

                                                    <span class="input-group-addon">%</span>
                                                </div>
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-sm-6 form-group required control-label" align="left">
                                                <label for='gasto_porc_ganancias_MMDI'>Gananacias MMDI</label>
                                                <div class="input-group">
                                                    @if($proyecto->distribuido == 0)
                                                        <input type='number' name='gasto_porc_ganancias_MMDI' id='gasto_porc_ganancias_MMDI' value='{{$proyecto->gasto_porc_ganancias_MMDI}}' class='form-control' required>
                                                    @else
                                                        <input type="hidden" name="gasto_porc_ganancias_MMDI" value="{{$proyecto->gasto_porc_ganancias_MMDI}}">
                                                        <input type='number' name='gasto_porc_ganancias_MMDI' id='gasto_porc_ganancias_MMDI' value='{{$proyecto->gasto_porc_ganancias_MMDI}}' class='form-control' disabled>
                                                    @endif

                                                    <span class="input-group-addon">%</span>
                                                </div>

                                            </div>
                                            <div class="col-sm-6 form-group required control-label" align="left">
                                                <label for='gasto_porc_honorarios'>Honorarios</label>
                                                <div class="input-group">
                                                    @if($proyecto->distribuido == 0)
                                                        <input type='number' name='gasto_porc_honorarios' id='gasto_porc_honorarios' value='{{$proyecto->gasto_porc_honorarios}}' class='form-control' required>
                                                    @else
                                                        <input type="hidden" name="gasto_porc_honorarios" value="{{$proyecto->gasto_porc_honorarios}}">
                                                        <input type='number' name='gasto_porc_honorarios' id='gasto_porc_honorarios' value='{{$proyecto->gasto_porc_honorarios}}' class='form-control' disabled>
                                                    @endif

                                                    <span class="input-group-addon">%</span>
                                                </div>

                                            </div>
                                       </div>

                                       <div class="row">
                                            <div class="col-sm-12" align="left">
                                                <hr>
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-sm-12" align="center">
                                                <h4>Porcentaje Ganancia</h4>
                                            </div>
                                       </div>

                                       <div class="row">
                                            <div class="col-sm-6 form-group required control-label" align="left">
                                                <label for='ganancia_MEG'>MEG</label>
                                                <div class="input-group">
                                                    @if($proyecto->distribuido == 0)
                                                        <input type='number' name='ganancia_MEG' id='ganancia_MEG' value='{{$proyecto->ganancia_MEG}}'  class='form-control' required>
                                                    @else
                                                        <input type="hidden" name="ganancia_MEG" value="{{$proyecto->ganancia_MEG}}">
                                                        <input type='number' name='ganancia_MEG' id='ganancia_MEG' value='{{$proyecto->ganancia_MEG}}'  class='form-control' disabled>
                                                    @endif
                                                    <span class="input-group-addon">%</span>
                                                </div>

                                            </div>
                                            <div class="col-sm-6 form-group required control-label" align="left">
                                                <label for='ganancia_AMM'>AMM</label>
                                                <div class="input-group">
                                                    @if($proyecto->distribuido == 0)
                                                        <input type='number' name='ganancia_AMM' id='ganancia_AMM' value='{{$proyecto->ganancia_AMM}}' class='form-control' required>
                                                    @else
                                                        <input type="hidden" name="ganancia_AMM" value="{{$proyecto->ganancia_AMM}}">
                                                        <input type='number' name='ganancia_AMM' id='ganancia_AMM' value='{{$proyecto->ganancia_AMM}}' class='form-control' disabled>
                                                    @endif
                                                    <span class="input-group-addon">%</span>
                                                </div>
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-sm-6 form-group required control-label" align="left">
                                                <label for='ganancia_MME'>MME</label>
                                                <div class="input-group">
                                                    @if($proyecto->distribuido == 0)
                                                        <input type='number' name='ganancia_MME' id='ganancia_MME' value='{{$proyecto->ganancia_MME}}'  class='form-control' required>
                                                    @else
                                                        <input type="hidden" name="ganancia_MME" value="{{$proyecto->ganancia_MME}}">
                                                        <input type='number' name='ganancia_MME' id='ganancia_MME' value='{{$proyecto->ganancia_MME}}'  class='form-control' disabled>
                                                    @endif
                                                    <span class="input-group-addon">%</span>
                                                </div>

                                            </div>
                                            <div class="col-sm-6 form-group required control-label" align="left">
                                                <label for='ganancia_AME'>AME</label>
                                                <div class="input-group">
                                                    @if($proyecto->distribuido == 0)
                                                        <input type='number' name='ganancia_AME' id='ganancia_AME' value='{{$proyecto->ganancia_AME}}'  class='form-control' required>
                                                    @else
                                                        <input type="hidden" name="ganancia_AME" value="{{$proyecto->ganancia_AME}}">
                                                        <input type='number' name='ganancia_AME' id='ganancia_AME' value='{{$proyecto->ganancia_AME}}'  class='form-control' disabled>
                                                    @endif

                                                    <span class="input-group-addon">%</span>
                                                </div>

                                            </div>
                                         </div>
                                         <div class="row">
                                            <div class="col-sm-12" align="center">
                                            <hr>
                                            </div>
                                        </div>
                                           <div class="row">
                                                <div class="col-sm-2" align="center">
                                                <br>
                                                </div>
                                                <div class="col-sm-10 divPunteado" align="center">
                                                    <div class="row">
                                                        <div class="col-sm-12" align="center">
                                                            <h4 class="glyphicon glyphicon-bookmark">Presupuesto Cliente</h4>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-1 " align="right">
                                                        </div>
                                                        <div class="col-sm-5 " align="left">
                                                            <label>Inicial:</label>
                                                        </div>
                                                        <div class="col-sm-5 " align="left">
                                                            $ {{$proyecto->inicial}}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-1 " align="right">
                                                        </div>
                                                        <div class="col-sm-5 " align="left">
                                                            <label>Honorarios:</label>
                                                        </div>
                                                        <div class="col-sm-5 " align="left">
                                                            $ {{$proyecto->honorarios}}
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-1 " align="right">
                                                        </div>
                                                        <div class="col-sm-5 " align="left">
                                                            <label>TOTAL:</label>
                                                        </div>
                                                        <div class="col-sm-5 " align="left">
                                                            $ {{$proyecto->costo}}
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-1 " align="right">
                                                        </div>
                                                        <div class="col-sm-10 " align="left">
                                                          <hr>
                                                        </div>
                                                        <div class="col-sm-1 " align="left">
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-1 " align="right">
                                                        </div>
                                                        <div class="col-sm-5 " align="left">
                                                            <label>Adicionales:</label>
                                                        </div>
                                                        <div class="col-sm-5 " align="left">
                                                            $ {{$proyecto->adicional}}
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12" align="center">
                                                            @if($estatusSelected == "Terminado" and !$proyecto->adicionalesDistribuido)
                                                                <a href="{{ URL::to('distribuirAdicionales')}}/{{$proyecto->id}}" class="glyphicon glyphicon glyphicon-list btn btn-primary"> Distribuir</a>
                                                            @else
                                                                @if($estatusSelected != "Terminado")
                                                                    <label class="alert-info form-control">El proyecto no ha terminado</label>
                                                                @else
                                                                    <label class="alert-info form-control">Distribuido</label>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-7 " align="right">
                                                           <br>
                                                        </div>
                                                        <!--div class="col-sm-7 " align="right">
                                                            <label>CON ADICIONALES:</label>
                                                        </div>
                                                        <div class="col-sm-5 " align="left">
                                                             $ {{$proyecto->totAdicionales}}
                                                        </div-->
                                                    </div>
                                                </div>
                                           </div>
                                        </div>
                                    </div>
								<div class="col-sm-4" align="left">
								    <div class="col-sm-12 container center">
								        <div class="row">
                                            <div class="col-sm-12" align="left">
                                                <hr>
                                            </div>
										</div>
                                       <div class="row">
                                            <div class="col-sm-2" align="center">
                                            <br>
                                            </div>
                                            <div class="col-sm-8 divPagosCliente" align="center">
                                                <div class="row">
                                                    <div class="col-sm-12" align="center">
                                                        <h4 class="glyphicon glyphicon-bookmark">Pagos Cliente</h4>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 " align="left">
                                                        <label>Efectivo:</label>
                                                    </div>
                                                    <div class="col-sm-6 " align="left">
                                                        $ {{$proyecto->efectivo}}
                                                   </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 " align="left">
                                                        <label>Transfer:</label>
                                                    </div>
                                                    <div class="col-sm-6 " align="left">
                                                        $ {{$proyecto->transferencias}}
                                                   </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 " align="left">
                                                        <label>Cheque:</label>
                                                    </div>
                                                    <div class="col-sm-6 " align="left">
                                                        $ {{$proyecto->cheques}}
                                                   </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 " align="left">
                                                        <label>SALDO:</label>
                                                    </div>
                                                    <div class="col-sm-6 " align="left">
                                                        $ {{$proyecto->saldo}}
                                                   </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12" align="center">
                                            <hr>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2" align="center">
                                            <br>
                                            </div>
                                            <div class="col-sm-8 divPagos" align="center">
                                                <div class="row">
                                                    <div class="col-sm-12" align="center">
                                                        <h4 class="glyphicon glyphicon-bookmark">Utilidades</h4>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="left">
                                                        <label>Indirectos:</label> $ {{$proyecto->indirectos}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="left">
                                                        <label>Honorarios:</label> $ {{$proyecto->honorarios}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="center">
                                                        <label>TOTAL:</label> $ {{$proyecto->utilidades}}
                                                    </div>
                                                </div>
                                            </div>
                                       </div>
                                        <div class="row">
                                            <div class="col-sm-12" align="center">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12" align="center">
                                            <hr>
                                            </div>
                                        </div>
                                       <div class="row">
                                            <div class="col-sm-2" align="center">
                                            <br>
                                            </div>
                                            <div class="col-sm-8 divPagos" align="center">
                                                <div class="row">
                                                    <div class="col-sm-12" align="center">
                                                        <h4 class="glyphicon glyphicon-bookmark">Gastos</h4>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="left">
                                                        <label>MMDI:</label> $ {{$proyecto->mmdi}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="left">
                                                        <label>Viaticos:</label> $ {{$proyecto->gasto_viaticos}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="left">
                                                        <label>IMSS:</label> $ {{$proyecto->gasto_IMSS}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="left">
                                                        <label>Errores:</label> $ {{$proyecto->errores}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="center">
                                                        <label>DESPUES DE GASTOS:</label> $ {{$proyecto->ddg}}
                                                    </div>
                                                </div>
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-sm-12" align="center">
                                            <hr>
                                            </div>
                                        </div>
                                       <div class="row">
                                            <div class="col-sm-2" align="center">
                                            <br>
                                            </div>
                                            <div class="col-sm-8 divPagos" align="center">
                                                <div class="row">
                                                    <div class="col-sm-12" align="center">
                                                        <h4 class="glyphicon glyphicon-bookmark">Division de Ganancias</h4>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="left">
                                                        <label>MMDI:</label> $ {{$proyecto->recMmdi}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="left">
                                                        <label>MEG:</label> $ {{$proyecto->meg}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="left">
                                                        <label>AMM:</label> $ {{$proyecto->amm}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="left">
                                                        <label>MME:</label> $ {{$proyecto->mme}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 " align="left">
                                                        <label>AME:</label> $ {{$proyecto->ame}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12" align="center">
                                                        @if($proyecto->ganancia_AME+$proyecto->ganancia_MME+$proyecto->ganancia_AMM+$proyecto->ganancia_MEG != 100)
                                                            <label class="alert-info form-control">No suma 100%</label>
                                                        @else
                                                            @if($proyecto->distribuido)
                                                                <label class="alert-info form-control">Distribuido</label>
                                                            @else
                                                                <a href="{{ URL::to('distribuir')}}/{{$proyecto->id}}" class="glyphicon glyphicon glyphicon-list btn btn-primary"> Distribuir</a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                        <div class="col-sm-7 " align="right">
                                                           <br>
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
                                    @if($proyecto)
                                        <input type='submit' value='Guarda Proyecto' class='btn btn-primary btn-small'>
                                    @else
                                        <input type='submit' value='Crear Proyecto' class='btn btn-primary btn-small'>
                                    @endif
                                </div>
                            </div>
                        </div>

               </form>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 align-right">
                @if($proyecto)
                      <div class="container">
                            <div class="row">
                                <hr>
                                <div class="col-sm-1 align-left">
                                </div>
                                <div class="col-sm-10 align-center">
                                     <h3 class="center">Conceptos</h3>
                                </div>
                                <div class="col-sm-1 align-left">

                                </div>
                            </div>
                        </div>

                        @if(count($conceptos)>0)
                            <div class="container center">
                                <div class="row">
                                    <div class="col-sm-12 align-self-center">

                                    <table class="table table-hover table-striped .table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <!--th class="center">#</th-->
                                                <th class="center">Nombre </th>
                                                <th class="center">Cantidad </th>
                                                <th class="center">Unidades </th>
                                                <th class="center">Precio </th>
                                                <th class="center">Fecha</th>
                                                <th class="center">Estatus </th>
                                                <th class="center">Total </th>
                                                <th class="center">Adicinal </th>
                                                <th class="center">
                                                    @if($proyecto->id != -1 and  $proyecto->adicionalesDistribuido == 0)
                                                        <a href="{{ URL::to('concepto/-1/'.$proyecto->id)}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                                    @endif

                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             @foreach($conceptos as $concepto)
                                                <tr>
                                                    <!--td> <a href="{{ URL::to('concepto/' . $concepto->id) }}">{{$concepto->id}}</a></td-->
                                                    <td> {{$concepto->nombre}}</td>
                                                    <td>{{$concepto->cantidad}}</td>
                                                    <td>{{$concepto->unidades}}</td>
                                                    <td>{{$concepto->precio}}</td>
                                                    <td>{{$concepto->fecha}}</td>
                                                    <td>{{$concepto->estatus}}</td>
                                                    <td>{{$concepto->total}}</td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input" id="adicional" {{ $concepto->adicional ? 'checked="checked"' : '' }} disabled>
                                                    </td>
                                                    <td>
                                                        <a href="{{ URL::to('concepto/' . $concepto->id)}}/{{$proyecto->id}}" class="glyphicon glyphicon-edit"></a>
                                                         @if($concepto->adicional == 0 and  $proyecto->distribuido == 0)
                                                            <a href="{{ URL::to('concepto/eliminar/'.$concepto->id)}}" class="glyphicon glyphicon-trash"></a>
                                                        @endif
                                                        @if($concepto->adicional == 1 and  $proyecto->adicionalesDistribuido == 0)
                                                            <a href="{{ URL::to('concepto/eliminar/'.$concepto->id)}}" class="glyphicon glyphicon-trash"></a>
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
										{{$conceptos->render()}}

									</div>
									<div class="col-sm-1 align-self-center">
									</div>
								</div>
							</div>

                    @else
                        <h4>Sin Conceptos
                            @if($proyecto->id != -1)
                                <a href="{{ URL::to('concepto/-1/'.$proyecto->id)}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                            @endif
                        </h4>
                    @endif
                @endif
            </div>
        </div>
    </div>

@endsection