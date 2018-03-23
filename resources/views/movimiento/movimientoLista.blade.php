@extends('layouts.master')

@section('title')
    Movimientos
@endsection

@push('head')
    <!--link href="/css/movimiento.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    @if(count($movimientos)>0)
        <div class="container center">
            <div class="row">
                <div class="col-sm-12 align-center">
                    @if($recurso->id != -1)
                        <h1 class="center"> Movimientos de recurso {{$recurso->nombre}} </h1>
                    @elseif($cuenta->id != -1)
                        <h1 class="center"> Movimientos de cuenta {{$cuenta->nombre}} </h1>
                    @else
                        <h1 class="center">Todos los Movimientos</h1>
                    @endif
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
                                                <th class="center">Fecha</th>
                                                <th class="center">Descripción </th>
                                                <th class="center">Tipo </th>
                                                <th class="center">Monto</th>
                                                @if($recurso->id == -1)
                                                    <th class="center">Recurso Afectado</th>
                                                @endif
                                                @if($cuenta->id == -1)
                                                    <th class="center">Cuenta Afectada</th>
                                                @endif
                                                <th class="center">
                                                    <a href="{{URL::to('movimiento/-1')}}/{{$recurso->id}}/{{$cuenta->id}}" class="glyphicon glyphicon-plus-sign"></a>
                                                    <!--glyphicon-usd-->
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             @foreach($movimientos as $movimiento)
                                                <tr>
                                                    <!--td>{{$movimiento->id}}</td-->
                                                    <td> {{$movimiento->fecha}}</td>
                                                    <td>{{$movimiento->descripcion}}</td>
                                                    <td>{{$movimiento->tipo}}</td>
                                                    <td>{{$movimiento->monto}}</td>
                                                    @if($recurso->id == -1)
                                                        <td>{{$movimiento->recurso->nombre}}</td>
                                                    @endif
                                                    @if($cuenta->id == -1)
                                                        <td>{{$movimiento->cuenta->nombre}}</td>
                                                    @endif
                                                    <td>
                                                        <!--a href="{{ URL::to('movimiento/'.$movimiento->id)}}" class="glyphicon glyphicon-edit"></a-->
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
                {{$movimientos->render()}}

            </div>
            <div class="col-sm-1 align-self-center">
            </div>
        </div>
    </div>

    @else
        @if($recurso->id != -1)
           <h1> {{$recurso->nombre}} Sin Movimientos <a href="{{ URL::to('movimiento/-1/'.$recurso->id)}}" class="glyphicon glyphicon glyphicon-plus-sign"></a></h1>
        @elseif($cuenta->id != -1)
           <h1> {{$cuenta->nombre}} Sin Movimientos <a href="{{ URL::to('movimiento/-1/-1/'.$cuenta->id)}}" class="glyphicon glyphicon glyphicon-plus-sign"></a></h1>
        @else
           <h1> Sin Movimientos <a href="{{ URL::to('movimiento/-1/')}}/{{$recurso->id}}" class="glyphicon glyphicon glyphicon-plus-sign"></a></h1>
        @endif

    @endif
@endsection