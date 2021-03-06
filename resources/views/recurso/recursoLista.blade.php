@extends('layouts.master')

@push('head')
    <!--link href="/css/recurso.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    @if(count($recursos)>0)
        <div class="container center">
            <div class="row">
                <div class="col-sm-12 align-center">
                    <h1 class="center">Recursos</h1>
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
                                                <th class="center">Recurso</th>
                                                <th class="center">Descripción </th>
                                                <th class="center">Distribuido</th>
                                                <th class="center">Gasto</th>
                                                <th class="center">Saldo</th>
                                                <th class="center">
                                                    Movimientos <a href="{{URL::to('movimiento/-1')}}" class="glyphicon glyphicon-plus-sign"></a>
                                                    <!--glyphicon-usd-->
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             @foreach($recursos as $recurso)
                                                <tr>
                                                    <!--td>{{$recurso->id}}</td-->
                                                    <td> {{$recurso->nombre}}</td>
                                                    <td>{{$recurso->descripcion}}</td>
                                                    <td>{{$recurso->ingreso}}</td>
                                                    <td>{{$recurso->saldo_gasto}}</td>
                                                    <td>{{$recurso->ingreso - $recurso->saldo_gasto}}</td>
                                                    <td>
                                                        <a href="{{ URL::to('movimientos?sinfiltros=1&recurso_id='.$recurso->id)}}" class="glyphicon glyphicon-list-alt"></a>
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
                {{$recursos->render()}}

            </div>
            <div class="col-sm-1 align-self-center">
            </div>
        </div>
    </div>

    @else
        <h1>Sin Recursos <a href="{{ URL::to('recurso/-1/')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a></h1>
    @endif
@endsection