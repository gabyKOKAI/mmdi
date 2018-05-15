<div class="row">
    <div class="col-sm-12 align-right">
            <div>
                <div class="row">
                    <div class="col-sm-4 align-left">
                        <hr>
                    </div>
                    <div class="col-sm-4 align-center">
                        <h3 class="center">Precios Unitarios
                            @if($concepto->id > -1)
                                de Concepto
                            @endif
                         </h3>
                    </div>
                    <div class="col-sm-4 align-left">
                        <hr>
                    </div>
                </div>
            </div>
            @if(count($elementos)>0)
                <div class="center">
                    <div class="row">
                        <div class="col-sm-12 align-self-center">
                              <table class="table table-hover table-striped .table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <!--th class="center">#</th-->
                                        <th class="center">Elemento
                                            @if($concepto->id > -1)
                                                (PU)
                                            @endif
                                        </th>
                                        <th class="center">Tipo </th>
                                        <th class="center">Proveedor</th>
                                        <th class="center">Unidades</th>
                                        <th class="center">Costo</th>
                                        <!--th class="center">Tipo Ganancia</th-->
                                        <th class="center">Ganancia</th>
                                        <th class="center">Precio
                                            @if($concepto->id > -1)
                                                Cliente
                                            @endif
                                        </th>
                                        <th class="center">
                                            @if($concepto->id > -1)
                                                @if($proyectoCon->distribuido == 0 and $concepto->adicional == 0)
                                                    <a href="{{URL::to('conceptoElemento/'.$concepto->id.'/-1/1')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                                @elseif($proyectoCon->adicionalesDistribuido == 0 and $concepto->adicional == 1)
                                                    <a href="{{URL::to('conceptoElemento/'.$concepto->id.'/-1/1')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                                @endif
                                            @else
                                                <a href="{{URL::to('elemento/-1')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                            @endif
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach($elementos as $elemento)
                                        <tr>
                                            <!--td>{{$elemento->id}}</td-->
                                            <td> {{$elemento->nombre}}
                                            @if($concepto->id > -1)
                                                {{'(CGT:'.$elemento->costo.'-'.$elemento->ganancia.'-'.$elemento->tipo_ganancia.')'}}
                                            @endif</td>
                                            <td>{{$elemento->tipo}}</td>
                                            <td>{{$elemento->proveedor->nombre}}</td>
                                            <td>{{$elemento->unidades}}</td>
                                            <td>$ {{$elemento->costo}}</td>
                                            <!--td>{{$elemento->tipo_ganancia}}</td-->
                                            <td>
                                                @if($concepto->id > -1)
                                                    $ {{$elemento->precioCliente - $elemento->costoCliente}}
                                                @else
                                                    {{$elemento->ganancia}} - {{$elemento->tipo_ganancia}}
                                                @endif
                                            </td>
                                            <td>$ {{$elemento->precio}}</td>
                                            <td>
                                                @if($concepto->id > -1)
                                                    @if($proyectoCon->distribuido == 0 and $concepto->adicional == 0)
                                                            <a href="{{ URL::to('conceptoElemento/' . $concepto->id.'/'.$elemento->id).'/1'}}" class="glyphicon glyphicon-edit"></a>
                                                            <a href="{{ URL::to('conceptoElemento/eliminar/'.$concepto->id.'/'.$elemento->id)}}" class="glyphicon glyphicon-trash"></a>
                                                        @elseif($proyectoCon->adicionalesDistribuido == 0 and $concepto->adicional == 1)
                                                            <a href="{{ URL::to('conceptoElemento/' . $concepto->id.'/'.$elemento->id.'/1')}}" class="glyphicon glyphicon-edit"></a>
                                                            <a href="{{ URL::to('conceptoElemento/eliminar/'.$concepto->id.'/'.$elemento->id)}}" class="glyphicon glyphicon-trash"></a>
                                                        @else
                                                            <a href="{{ URL::to('conceptoElemento/' . $concepto->id.'/'.$elemento->id.'/0')}}" class="glyphicon glyphicon-edit"></a>
                                                        @endif
                                                @else
                                                    <a href="{{ URL::to('elemento/'.$elemento->id)}}" class="glyphicon glyphicon-edit"></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-1">
                        </div>
                    </div>
                </div>

                <div class="container center">
                    <div class="row">
                        <div class="col-sm-12 align-self-center">

                            <!-- { {$proyectos->lastPage()} } -->
                            <!-- { {$proyectos->hasMorePages()} } -->
                            <!-- { {$proyectos->url()} } -->
                            <!-- { {$proyectos->nextPageUrl()} } -->
                            <!-- { {$proyectos->lastItem()} } -->
                            <!-- { {$proyectos->firstItem()} } -->
                            <!-- { {$proyectos->count()} } -->
                            <!-- { {$proyectos->perPage()} } -->
                            <!-- { {$proyectos->currentPage()} } -->
                            <!-- { {$elementos->render()} } -->

                        </div>
                    </div>
                </div>
            @else
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 align-center">
                            <h4 class="center">
                                Sin Precios Unitarios <a href="{{URL::to('conceptoElemento/'.$concepto->id.'/-1/1')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>

                            </h4>
                        </div>
                    </div>
                </div>
            @endif
    </div>
</div>