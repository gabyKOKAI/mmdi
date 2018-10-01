<div class="row divCXP">
    <div class="col-sm-12 align-right">
            <div>
                <div class="row">
                    <div class="col-sm-4 align-left">
                        <hr>
                    </div>
                    <div class="col-sm-4 align-center">
                         <h3 class="center">CXP
                         @if($proyecto->id > -1)
                            de {{$proyecto->nombre}}
                            @endif
                         </h3>
                    </div>
                    <div class="col-sm-4 align-left">
                        <hr>
                    </div>
                </div>
            </div>
            @if(count($cotizaciones)>0)
                <div class="center">
                    <div class="row">
                        <div class="col-sm-12 align-self-center">
                              <table class="table table-hover table-striped .table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <!--th class="center">#</th-->
                                        <th class="center">Nombre</th>
                                        <!--th class="center">Descripcion</th-->
                                        <th class="center">Proyecto</th>
                                        <th class="center">Proveedor</th>
                                        <th class="center">Total</th>
                                        <th class="center">Saldo</th>
                                        <th class="center">Con IVA</th>
                                        <th class="center">Estatus</th>
                                        <th class="center">
                                            <a href="{{ URL::to('cotizacion/-1/'.$proyecto->id)}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach($cotizaciones as $cotizacion)
                                        <tr>
                                            <!--td> <a href="{{ URL::to('proyecto/' . $cotizacion->id) }}">{{$cotizacion->id}}</a></td-->
                                            <td>{{$cotizacion->nombre}}</td>
                                            <!--td>{{$cotizacion->descripcion}}</td-->
                                            @if($cotizacion->proyecto)
                                                <td>{{$cotizacion->proyecto->nombre}}</td>
                                            @else
                                                <td>---SIN PROYECTO---</td>
                                            @endif
                                            <td>{{$cotizacion->proveedor->nombre}}</td>
                                            <td>$ {{number_format($cotizacion->monto,2)}}</td>
                                            <td>$ {{number_format($cotizacion->saldo,2)}}</td>
                                            <td>
                                                <input type="checkbox" class="form-check-input" id="con_iva" {{ $cotizacion->con_iva ? 'checked="checked"' : '' }} disabled>
                                            </td>
                                            <td>{{$cotizacion->estatus}}</td>
                                            <td>
                                                <a href="{{ URL::to('cotizacion/'.$cotizacion->id)}}" class="glyphicon glyphicon-edit"></a>
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
                            {{$cotizaciones->render()}}

                        </div>
                    </div>
                </div>
            @else
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 align-center">
                            <h4 class="center">
                                Sin CXP
                                @if($proyecto->id != -1 or $proveedore->id !=-1)
                                    <a href="{{ URL::to('cotizacion/-1/')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
            @endif
    </div>
</div>