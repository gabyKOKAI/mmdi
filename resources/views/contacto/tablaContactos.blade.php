<div class="row">
    <div class="col-sm-12 align-right">
        @if($cliente->id != -1 or $proveedore->id != -1)
              <div class="container">
                    <div class="row">
                        <div class="col-sm-4 align-left">
                            <hr>
                        </div>
                        <div class="col-sm-4 align-center">
                             <h3 class="center">Contactos</h3>
                        </div>
                        <div class="col-sm-4 align-left">
                            <hr>
                        </div>
                    </div>
                </div>

                @if(count($contactos)>0)
                    <div class="container center">
                        <div class="row">
                            <div class="col-sm-12 align-self-center">

                            <table class="table table-hover table-striped .table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <!--th class="center">#</th-->
                                        <th class="center">Nombre </th>
                                        <th class="center">Oficina </th>
                                        <th class="center">Celular </th>
                                        <th class="center">Correo </th>
                                        <th class="center">
                                            <a href="{{ URL::to('contacto/-1/'.$cliente->id.'/'.$proveedore->id)}}" class="glyphicon glyphicon-plus-sign"></a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach($contactos as $contacto)
                                        <tr>
                                            <!--td> <a href="{{ URL::to('concepto/' . $concepto->id) }}">{{$concepto->id}}</a></td-->
                                            <td>{{$contacto->nombre}}</td>
                                            <td>{{$contacto->oficina}}</td>
                                            <td>{{$contacto->celular}}</td>
                                            <td>{{$contacto->correo}}</td>
                                            <td>
                                                <a href="{{ URL::to('contacto/'.$contacto->id.'/'.$cliente->id.'/'.$proveedore->id)}}" class="glyphicon glyphicon-edit"></a>
                                                <a href="{{ URL::to('contacto/eliminar/'.$contacto->id)}}" class="glyphicon glyphicon-trash"></a>
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
                                {{$contactos->render()}}

                            </div>
                            <div class="col-sm-1 align-self-center">
                            </div>
                        </div>
                    </div>

            @else
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 align-center">
                            <h4 class="center">
                                Sin Contactos
                                @if($cliente->id != -1 or $proveedore->id != -1)
                                    <a href="{{ URL::to('contacto/-1/'.$cliente->id.'/'.$proveedore->id)}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>