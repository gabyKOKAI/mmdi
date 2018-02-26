@extends('layouts.master')


@section('title')
    Lista Proyectos
@endsection


@push('head')
    <link href="/css/cotizacion.css" type='text/css' rel='stylesheet'>
@endpush


@section('content')
    @if(count($cotizaciones)>0)
        <div class="container center">
            <div class="row">
                <div class="col-sm-12 align-center">
                    <h1 class="center">Cotizaciones</h1>
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
                            <th class="center">Descripcion </th>
                            <th class="center">Proyecto </th>
                            <th class="center">Proveedor </th>
                            <th class="center">Monto </th>
                            <th class="center">Con IVA </th>
                            <th class="center">Estatus </th>
                            <th class="center">
                                <a href="{{ URL::to('cotizacion/-1/')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                         @foreach($cotizaciones as $cotizacion)
                            <tr>
                                <!--td> <a href="{{ URL::to('proyecto/' . $cotizacion->id) }}">{{$cotizacion->id}}</a></td-->
                                <td>{{$cotizacion->descripcion}}</td>
                                @if($cotizacion->proyecto)
                                    <td>{{$cotizacion->proyecto->nombre}}</td>
                                @else
                                    <td>---SIN PROYECTO---</td>
                                @endif
                                <td>{{$cotizacion->proveedor->nombre}}</td>
                                <td>{{$cotizacion->monto}}</td>
                                <td>
                                    <input type="checkbox" class="form-check-input" id="con_iva" {{ $cotizacion->con_iva ? 'checked="checked"' : '' }} disabled>
                                </td>
                                <td>{{$cotizacion->estatus}}</td>
                                <td>
                                    <a href="{{ URL::to('cotizacion/'.$cotizacion->id)}}" class="glyphicon glyphicon-edit"></a>
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
                {{$cotizaciones->render()}}

            </div>
            <div class="col-sm-1 align-self-center">
            </div>
        </div>
    </div>

    @else
        <h1>Sin Cotizaciones<a href="{{ URL::to('cotizacion/-1/')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a></h1>
    @endif
@endsection


@push('body')
    <script src="/js/proyectos/lista.js"></script>
@endpush