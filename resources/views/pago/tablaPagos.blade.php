<div class="row">
    <div class="col-sm-12 align-right">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 align-left">
                        <hr>
                    </div>
                    <div class="col-sm-4 align-center">
                         <h3 class="center">Pagos
                             @if($esCliente == 1)
                                Clientes
                                @if($cliente->id != -1)
                                    de {{$cliente->nombre}}
                                @endif
                             @else
                                Proveedores
                                @if($proveedore->id != -1)
                                    de {{$proveedore->nombre}}
                                @endif
                             @endif
                         </h3>
                    </div>
                    <div class="col-sm-4 align-left">
                        <hr>
                    </div>
                </div>
            </div>
            @if(count($pagos)>0)
                <div class="container center">
                    <div class="row">
                        <div class="col-sm-12 align-center">
                            <h1 class="center"></h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1">
                        </div>
                        <div class="col-sm-10 align-self-center">
                            <table class="table table-hover table-striped .table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <!--th class="center">#</th-->
                                        @if($esCliente == 1)
                                            <th class="center">Cliente</th>
                                            <th class="center">Proyecto</th>
                                        @else
                                            <th class="center">Proveedor</th>
                                            <th class="center">Cotización</th>
                                        @endif
                                        <th class="center">Tipo</th>
                                        <th class="center">Cuenta</th>
                                        <th class="center">Fecha</th>
                                        <th class="center">Monto</th>
                                        <th class="center">Con IVA</th>
                                        <th class="center">Factura</th>
                                        <th class="center">Fecha Factura</th>
                                        <th class="center">Estatus</th>
                                        <th class="center">
                                            @if($esCliente == 1)
                                                <a href="{{URL::to('pagoCliente/-1/'.$cliente->id)}}" class="glyphicon glyphicon-plus-sign"></a>
                                            @else
                                                <a href="{{URL::to('pagoProveedor/-1/'.$proveedore->id)}}" class="glyphicon glyphicon-plus-sign"></a>
                                            @endif
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach($pagos as $pago)
                                        <tr>
                                            <!--td>{{$pago->id}}</td-->
                                            <td>{{$pago->cliProv->nombre}}</td>
                                            <td>
                                            @if($pago->proyCoti)
                                                {{$pago->proyCoti->nombre}}
                                            @endif
                                            </td>

                                            <td>{{$pago->tipo}}</td>
                                            <td>{{$pago->cuenta_id}}</td>
                                            <td>{{$pago->fecha_pago}}</td>
                                            <td>{{$pago->monto}}</td>
                                            <td>
                                                <input type="checkbox" class="form-check-input" id="conIva" {{ $pago->con_iva ? 'checked="checked"' : '' }} disabled>
                                            </td>
                                            <td>{{$pago->numero_factura}}</td>
                                            <td>{{$pago->fecha_factura}}</td>
                                            <td>{{$pago->estatus}}</td>
                                            <td>
                                                @if($esCliente == 1)
                                                    <a href="{{URL::to('pagoCliente/'.$pago->id.'/'.$cliente->id)}}" class="glyphicon glyphicon-edit"></a>
                                                @else
                                                    <a href="{{URL::to('pagoProveedor/'.$pago->id.'/'.$proveedore->id)}}" class="glyphicon glyphicon-edit"></a>
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
                            <!-- { {$proyectos->currentPage()} } -->
                            {{$pagos->render()}}

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
                                Sin Pagos
                                @if($esCliente == 1)
                                    de Clientes
                                    <a href="{{ URL::to('pagoCliente/-1/'.$cliente->id)}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                @else
                                    de Proveedores
                                    <a href="{{ URL::to('pagoProveedor/-1/'.$proveedore->id)}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
            @endif
    </div>
</div>