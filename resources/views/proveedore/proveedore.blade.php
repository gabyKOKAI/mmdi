@extends('layouts.master')

@section('title')
    Elemento
@endsection

@push('head')
    <!--link href="/css/movimiento.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 align-center">

               @if($movimiento->id != -1)
                    <h1 class="center">[{{$movimiento->id}}] Movimiento </h1>
                     <form method='GET' action='/movimiento/guardar/{{$movimiento->id}}'>
               @else
                    <h1 class="center">Nuevo Movimiento</h1>
                    <form method='GET' action='/movimiento/guardar/-1'>
               @endif
                       {{ csrf_field() }}
                       <input type="hidden" name="_method" value="PUT">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="container center">
                            <div class="row">
                                <div class="col-sm-1 container center">
                                </div>
                                <div class="col-sm-6">
                                    <div class="container center">
                                        <div class="row">
                                            <div class="col-sm-2 form-group required control-label" align="left">
                                                <label for='tipo'>Tipo</label>
                                                <select name="tipo"  class="form-control" required>
                                                    @foreach($tiposForDropdown as $tipo)
                                                        <option value="{{ $tipo }}" {{ $tipo == $tipoSelected ? 'selected="selected"' : '' }}> {{ $tipo }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 form-group required control-label" align="left">
                                                <label for='cuenta'>Cuenta</label>
                                                     @if($cuentaSelected == -1)
                                                        <select name="cuenta"  class="form-control" required>
                                                    @else
                                                        <input type="hidden" name="cuenta" value="<?php echo e($cuentaSelected); ?>">
                                                        <select name="cuenta"  class="form-control" disabled>
                                                    @endif
                                                    @foreach($cuentasForDropdown as $cuenta)
                                                        <option value="{{ $cuenta->id }}" {{ $cuenta->id == $cuentaSelected ? 'selected="selected"' : '' }}> {{ $cuenta->nombre }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 form-group required control-label" align="left">
                                                <label for='recurso'>Recurso</label>
                                                @if($recursoSelected == -1)
                                                    <select name="recurso"  class="form-control" required>
                                                @else
                                                    <input type="hidden" name="recurso" value="<?php echo e($recursoSelected); ?>">
                                                    <select name="recurso"  class="form-control" disabled>
                                                @endif
                                                    @foreach($recursosForDropdown as $recurso)
                                                        <option value="{{ $recurso->id }}" {{ $recurso->id == $recursoSelected ? 'selected="selected"' : '' }}> {{ $recurso->nombre }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 form-group required control-label" align="left">
                                                <label for='monto'>Monto</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">$</span>
                                                    @if($movimiento->id == -1)
                                                        <input type='number' name='monto' id='monto' step='0.01' min="0" value='{{$movimiento->monto}}' class='float form-control' required>
                                                    @else
                                                        <input type='number' name='monto' id='monto' step='0.01' min="0" value='{{$movimiento->monto}}' class='float form-control' disabled>
                                                    @endif
                                                </div>
                                            </div>
                                             <div class="col-sm-3" align="left">
                                            </div>


                                        </div>
                                        <div class="row">
                                            <div class="col-sm-0" align="left">
                                            </div>
                                             <div class="col-sm-3 form-group required control-label" align="left">
                                                <label for='fecha'>Fecha</label>
                                                <input type='date' name='fecha' id='fecha' value='{{$movimiento->fecha}}' class="form-control" required>
                                             </div>
                                             <div class="col-sm-3 form-group required control-label" align="left">
                                                <label for='monto'>Descripcion</label>
                                                <input type='text' name='descripcion' id='descripcion' value='{{$movimiento->descripcion}}'  class="form-control" required>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="container center">
                            <div class="row">
                                <div class="col-sm-12 align-self-center">
                                    <br>
                                    <input type='submit' value='Guarda Movimiento' class='btn btn-primary btn-small'>
                                </div>
                            </div>
                        </div>

               </form>
			</div>
		</div>
    </div>

@endsection