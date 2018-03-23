@extends('layouts.master')

@push('head')
    <!--link href="/css/conceptoElemento.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 align-center">

                @if($elemento->id != -1)
                    <h1 class="center">Concepto '{{$concepto->nombre}}' con Elemento  '{{$elemento->nombre}}' </h1>
                     <form method='GET' action='/conceptoElemento/guardar/{{$concepto->id}}/{{$elemento->id}}/{{$edit}}'>
               @else
                    <h1 class="center">Nuevo Elemento para concepto</h1>
                    <form method='GET' action='/conceptoElemento/guardar/{{$concepto->id}}/-1/{{$edit}}'>
               @endif
                       {{ csrf_field() }}
                       <input type="hidden" name="_method" value="PUT">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="container center">
                            <div class="row">
                                <div class="col-sm-4" align="left">
                                </div>
                                <div class="col-sm-4" align="left">
                                    <div class="col-sm-12 container center">
									    <div class="row">
                                            <div class="col-sm-12 form-group required control-label" align="left">
                                                    <label for='nombreCon'>Nombre Concepto</label>
                                                    <a href="{{ URL::to('concepto/'.$concepto->id) }}" class="glyphicon glyphicon-edit"></a>
                                                    <input type='text' name='nombreCon' id='nombreCon' value='{{$concepto->nombre}}'  class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                           <div class="col-sm-12 form-group required control-label" align="left">
                                                <label for='elemento'>Elemento</label>

                                                @if($elementoSelected!=-1)
                                                    <a href="{{ URL::to('elemento/'.$elemento->id)}}" class="glyphicon glyphicon-edit"></a>
                                                    <input type="hidden" name="elemento" value="{{$elementoSelected}}">
                                                    <select name="elemento"  class="form-control" disabled>
                                                @else
                                                    <a href="{{ URL::to('elemento/-1')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                                    <select name="elemento"  class="form-control">
                                                @endif
                                                    @foreach($elementosForDropdown as $elemento)
                                                    <option value="{{ $elemento->id }}" {{ $elemento->id == $elementoSelected ? 'selected="selected"' : '' }}>
                                                        ({{$elemento->getPrecio($elemento)}})
                                                        {{ $elemento->nombre}} >
                                                        {{$elemento->tipo}}
                                                        {{'[CGT:'.$elemento->costo.'-'.$elemento->ganancia.' '.$elemento->tipo_ganancia.']' }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-sm-6 form-group required control-label" align="left">
                                                <label for='precio'>Precio </label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">$</span>
                                                    @if($edit == 1)
                                                        <input type='number' name='precio' id='precio' step='0.01' value='{{$precio}}' class='float form-control'required>
                                                    @else
                                                        <input type="hidden" name="precio" value="{{$precio}}">
                                                        <input type='number' name='precio' id='precio' step='0.01' value='{{$precio}}' class='float form-control'disabled>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
									</div>
                                </div>
                            </div>
                        </div>
                        <div class="container center">
                            <div class="row">
                            <br>
                            </div>
                        </div>
						<div class="container center">
                            <div class="row">
                                <div class="col-sm-12 align-self-center">
                                    @if($elementoSelected!=-1)
                                        @if($edit == 1)
                                            <input type='submit' value='Actualizar Precio' class='btn btn-primary btn-small'>
                                            <a href="{{ URL::to('conceptoElemento/eliminar/'.$concepto->id.'/'.$elemento->id.'/'.$edit)}}" class="glyphicon glyphicon-trash"></a>
                                        @else
                                            <input type='submit' value='Actualizar Precio' class='btn btn-primary btn-small' disabled>
                                        @endif
                                    @else
                                        <input type='submit' value='Agregar Elemento a Concepto' class='btn btn-primary btn-small'>
                                    @endif
                                </div>
                            </div>
                        </div>

               </form>
			</div>
		</div>
    </div>

@endsection