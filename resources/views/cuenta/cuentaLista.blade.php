@extends('layouts.master')

@push('head')
    <!--link href="/css/cuenta.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    @if(count($cuentas)>0)
        <div class="container center">
            <div class="row">
                <div class="col-sm-12 align-center">
                    <h1 class="center">Cuentas</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                </div>
                <div class="col-sm-8 align-self-center">

                <table class="table table-hover table-striped .table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <!--th class="center">#</th-->
                                                <th class="center">Cuenta</th>
                                                <th class="center">Descripción </th>
                                                <th class="center">Saldo</th>
                                                 <th class="center">
                                                    Movimientos <a href="{{URL::to('movimiento/-1')}}" class="glyphicon glyphicon-plus-sign"></a>
                                                    <!--glyphicon-usd-->
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             @foreach($cuentas as $cuenta)
                                                <tr>
                                                    <!--td>{{$cuenta->id}}</td-->
                                                    <td> {{$cuenta->nombre}}</td>
                                                    <td> {{$cuenta->descripcion}}</td>
                                                    <td>{{$cuenta->saldo}}</td>
                                                    <td>
                                                        <a href="{{ URL::to('movimientos/-1/'.$cuenta->id)}}" class="glyphicon glyphicon-list-alt"></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                </div>
                <div class="col-sm-2">
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
                {{$cuentas->render()}}

            </div>
            <div class="col-sm-1 align-self-center">
            </div>
        </div>
    </div>

    @else
        <h1>Sin Cuentas <!--a href="{{ URL::to('cuenta/-1/')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a--></h1>
    @endif
@endsection