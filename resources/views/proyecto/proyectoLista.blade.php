@extends('layouts.master')


@section('title')
    Lista Proyectos
@endsection


@push('head')
    <link href="/css/proyectos/lista.css" type='text/css' rel='stylesheet'>
@endpush


@section('content')
    @if(count($proyectos)>0)
        <div class="container center">
            <div class="row">
                <div class="col-sm-12 align-center">
                    <h1 class="center">Proyectos</h1>
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
                            <th class="center">Nombre </th>
                            <th class="center">Cliente </th>
                            <th class="center">Costo </th>
                            <th class="center">Saldo </th>
                            <th class="center">Estatus </th>
                            <th class="center">
                                <a href="{{ URL::to('proyecto/-1/')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                         @foreach($proyectos as $proyecto)
                            <tr>
                                <!--td> <a href="{{ URL::to('proyecto/' . $proyecto->id) }}">{{$proyecto->id}}</a></td-->
                                <td>{{$proyecto->nombre}}</td>
                                <td>{{$proyecto->cliente->nombre}}</td>
                                <td>{{$proyecto->costo}}</td>
                                <td>{{$proyecto->saldo}}</td>
                                <td>{{$proyecto->estatus}}</td>
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
                {{$proyectos->render()}}

            </div>
            <div class="col-sm-1 align-self-center">
            </div>
        </div>
    </div>

    @else
        <h1>Sin Proyectos <a href="{{ URL::to('proyecto/-1/')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a></h1>
    @endif
@endsection


@push('body')
    <script src="/js/proyectos/lista.js"></script>
@endpush