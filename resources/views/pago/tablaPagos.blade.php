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
                                Cliente(s)
                                <!--@if($cliente->id != -1)
                                    de {{$cliente->nombre}}
                                @endif-->
                             @else
                                Proveedore(s)
                                <!--@if($proveedore->id != -1)
                                    de {{$proveedore->nombre}}
                                @endif-->
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
                        <div class="col-sm-12 align-self-center">
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
                                        <!--th class="center">Fecha Factura</th>
                                        <th class="center">Estatus</th-->
                                        <!--th class="center">Registro</th-->
                                        <th class="center">
                                            @if($esCliente == 1)
                                                @if($cliente->id != -1)
                                                    <a href="{{URL::to('pagoCliente/-1/'.$cliente->id.'/'.$proyecto->id)}}" class="glyphicon glyphicon-plus-sign"></a>
                                                @endif
                                            @else
                                                @if($proveedore->id != -1)
                                                    <a href="{{URL::to('pagoProveedor/-1/'.$proveedore->id.'/'.$cotizacione->id)}}" class="glyphicon glyphicon-plus-sign"></a>
                                                @endif
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
                                            @else
                                                ---
                                            @endif
                                            </td>

                                            <td>{{$pago->tipo}}</td>
                                            <td>{{$pago->cuenta->nombre}}</td>
                                            <td>{{$pago->fecha_pago}}</td>
                                            <td>$ {{$pago->monto}}</td>
                                            <td>
                                                <input type="checkbox" class="form-check-input" id="conIva" {{ $pago->con_iva ? 'checked="checked"' : '' }} disabled>
                                            </td>
                                            <td>{{$pago->numero_factura}}</td>
                                            <!--td>{{$pago->fecha_factura}}</td>
                                            <td>{{$pago->estatus}}</td-->
                                            <!--td>{{$pago->user->name}}</td-->
                                            <td>
                                                @if($esCliente == 1)
                                                    <a href="{{URL::to('pagoCliente/'.$pago->id.'/'.$cliente->id.'/'.$proyecto->id)}}" class="glyphicon glyphicon-edit"></a>
                                                @else
                                                    <a href="{{URL::to('pagoProveedor/'.$pago->id.'/'.$proveedore->id.'/'.$cotizacione->id)}}" class="glyphicon glyphicon-edit"></a>
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
                            {{$pagos->render()}}

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
                                    de Cliente(s)
                                    @if($proyecto->id != -1 or $cliente->id != -1)
                                        <a href="{{ URL::to('pagoCliente/-1/'.$cliente->id.'/'.$proyecto->id)}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                    @endif
                                @else
                                    de Proveedore(s)
                                    @if($cotizacione->id != -1 or $proveedore->id != -1)
                                        <a href="{{ URL::to('pagoProveedor/-1/'.$proveedore->id.'/'.$cotizacione->id)}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                    @endif
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
            @endif
    </div>
</div>