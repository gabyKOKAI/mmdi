<div class="row">
    <div class="col-sm-12 align-right">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 align-left">
                        <hr>
                    </div>
                    <div class="col-sm-4 align-center">
                         <h3 class="center">Proyectos
                         @if($cliente->id > 0)
                            de {{$cliente->nombre}} <!--a href="{{ URL::to('cliente/'.$cliente->id)}}" class="glyphicon glyphicon-edit"></a-->
                            @endif
                         </h3>
                    </div>
                    <div class="col-sm-4 align-left">
                        <hr>
                    </div>
                </div>
            </div>
            @if(count($proyectos)>0)
                <div class="container center">
                    <div class="row">
                        <div class="col-sm-12 align-self-center">

                        <table class="table table-hover table-striped .table-striped table-responsive">
                            <thead>
                                <tr>
                                    <!--th class="center">#</th-->
                                    <th class="center">Nombre</th>
                                    @if($cliente->id == -1)
                                        <th class="center">Cliente</th>
                                    @endif
                                    <th class="center">Costo</th>
                                    <th class="center">Saldo</th>
                                    <th class="center">Estatus</th>
                                    <th class="center">Distribuido</th>
                                    <th class="center">Adicionales Distribuidos</th>
                                    <th class="center">
                                        <a href="{{ URL::to('proyecto/-1/'.$cliente->id)}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                 @foreach($proyectos as $proyecto)
                                    <tr>
                                        <!--td> <a href="{{ URL::to('proyecto/' . $proyecto->id) }}">{{$proyecto->id}}</a></td-->
                                        <td>{{$proyecto->nombre}}</td>
                                        @if($cliente->id == -1)
                                            <td>{{$proyecto->cliente->nombre}}</td>
                                        @endif
                                        <td>{{$proyecto->costo}}</td>
                                        <td>{{$proyecto->saldo}}</td>
                                        <td>{{$proyecto->estatus}}</td>
                                        <td>
                                            <input type="checkbox" class="form-check-input" id="distribuido" {{ $proyecto->distribuido ? 'checked="checked"' : '' }} disabled>
                                        </td>
                                        <td>
                                            <input type="checkbox" class="form-check-input" id="adicionalesDistribuido" {{ $proyecto->adicionalesDistribuido ? 'checked="checked"' : '' }} disabled>
                                        </td>
                                        <td>
                                            <a href="{{ URL::to('proyecto/'.$proyecto->id)}}" class="glyphicon glyphicon-edit"></a>
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
                            {{$proyectos->render()}}
                        </div>
                    </div>
                </div>
            @else
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 align-center">
                            <h4 class="center">
                                Sin Proyectos
                                @if($cliente->id != -1)
                                    <a href="{{ URL::to('proyecto/-1/'.$cliente->id)}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
            @endif
    </div>
</div>