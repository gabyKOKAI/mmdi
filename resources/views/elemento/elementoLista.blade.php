@extends('layouts.master')

@section('title')
    Elementos
@endsection

@push('head')
    <!--link href="/css/elemento.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    @if(count($elementos)>0)
        <div class="container center">
            <div class="row">
                <div class="col-sm-12 align-center">
                    <h1 class="center">Elementos</h1>
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
                                                <th class="center">Tipo </th>
                                                <th class="center">Proveedor</th>
                                                <th class="center">Unidades</th>
                                                <th class="center">Costo</th>
                                                <th class="center">Ganancia</th>
                                                <th class="center">Tipo Ganancia</th>
                                                <th class="center">Precio</th>
                                                <th class="center">
                                                    <a href="{{URL::to('elemento/-1')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             @foreach($elementos as $elemento)
                                                <tr>
                                                    <!--td>{{$elemento->id}}</td-->
                                                    <td> {{$elemento->nombre}}</td>
                                                    <td>{{$elemento->tipo}}</td>
                                                    <td>{{$elemento->proveedor->nombre}}</td>
                                                    <td>{{$elemento->unidades}}</td>
                                                    <td>{{$elemento->costo}}</td>
                                                    <td>{{$elemento->ganancia}}</td>
                                                    <td>{{$elemento->tipo_ganancia}}</td>
                                                    <td>{{$elemento->precio}}</td>
                                                    <td>
                                                        <a href="{{ URL::to('elemento/'.$elemento->id)}}" class="glyphicon glyphicon-edit"></a>
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
                {{$elementos->render()}}

            </div>
            <div class="col-sm-1 align-self-center">
            </div>
        </div>
    </div>

    @else
        <h1>Sin Elementos <a href="{{ URL::to('elemento/-1/')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a></h1>
    @endif
@endsection