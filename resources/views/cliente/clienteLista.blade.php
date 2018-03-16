@extends('layouts.master')

@section('title')
    Elemento
@endsection

@push('head')
    <!--link href="/css/cliente.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    @if(count($clientes)>0)
        <div class="container center">
            <div class="row">
                <div class="col-sm-12 align-center">
                    <h1 class="center">Clientes</h1>
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
                                    <a href="{{URL::to('cliente/-1')}}" class="glyphicon glyphicon-plus-sign"></a>
                                    <!--glyphicon-usd-->
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach($clientes as $cliente)
                                <tr>
                                    <!--td>{{$cliente->id}}</td-->
                                    <td> {{$cliente->nombre}}</td>
                                    <td>{{$cliente->descripcion}}</td>
                                    <td>{{$cliente->razon_social}}</td>
                                    <td>{{$cliente->rfc}}</td>
                                    <td>
                                        <a href="{{ URL::to('cliente/'.$cliente->id)}}" class="glyphicon glyphicon-edit"></a>
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
                {{$clientes->render()}}

            </div>
            <div class="col-sm-1 align-self-center">
            </div>
        </div>
    </div>

    @else
        <h1> Sin Clientes <a href="{{ URL::to('cliente/-1/')}}" class="glyphicon glyphicon-plus-sign"></a></h1>
    @endif
@endsection