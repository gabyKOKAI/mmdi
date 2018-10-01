@extends('layouts.master')

@push('head')
    <!--link href="/css/proveedore.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    @include('proveedore.proveedoreFiltros')
    @if(count($proveedores)>0)
        <div class="container center">
            <div class="row">
                <div class="col-sm-12 align-center">
                    <h1 class="center">Proveedores</h1>
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
                                <th class="center">Nombre</th>
                                <th class="center">Descripción </th>
                                <th class="center">Razón Social</th>
                                <th class="center">RFC</th>
                                <th class="center">
                                    <a href="{{URL::to('proveedor/-1')}}" class="glyphicon glyphicon-plus-sign"></a>
                                    <!--glyphicon-usd-->
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach($proveedores as $proveedore)
                                <tr>
                                    <!--td>{{$proveedore->id}}</td-->
                                    <td> {{$proveedore->nombre}}</td>
                                    <td>{{$proveedore->descripcion}}</td>
                                    <td>{{$proveedore->razon_social}}</td>
                                    <td>{{$proveedore->rfc}}</td>
                                    <td>
                                        <a href="{{ URL::to('proveedor/'.$proveedore->id)}}" class="glyphicon glyphicon-edit"></a>
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
                {{$proveedores->render()}}

            </div>
            <div class="col-sm-1 align-self-center">
            </div>
        </div>
    </div>

    @else
        <h1> Sin Proveedores <a href="{{ URL::to('proveedor/-1/')}}" class="glyphicon glyphicon-plus-sign"></a></h1>
    @endif
@endsection