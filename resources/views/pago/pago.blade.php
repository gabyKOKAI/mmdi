<div class="container">
    <div class="row">
        <div class="col-sm-12 align-center">
           @if($pago->id != -1)
                <h1 class="center">[{{$pago->id}}] Pago
                @if($esCliente == 1)
                    Cliente
                    </h1>
                    <form method='GET' action='/clientepago/guardar/{{$pago->id}}/{{$cliProvSelected}}/{{$proyCotiSelected}}'>
                 @else
                    Proveedor
                    </h1>
                    <form method='GET' action='/proveedorpago/guardar/{{$pago->id}}/{{$cliProvSelected}}/{{$proyCotiSelected}}'>
                 @endif
           @else
                <h1 class="center">Nuevo Pago
                 @if($esCliente == 1)
                    Cliente
                    </h1>
                    <form method='GET' action='/clientepago/guardar/-1/{{$cliProvSelected}}/{{$proyCotiSelected}}'>
                 @else
                    Proveedor
                    </h1>
                    <form method='GET' action='/proveedorpago/guardar/-1/{{$cliProvSelected}}/{{$proyCotiSelected}}'>
                 @endif
           @endif
               {{ csrf_field() }}
               <input type="hidden" name="_method" value="PUT">
               <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="container center">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="container center">
                                <div class="row">
                                    <div class="col-sm-1">
                                    </div>
                                    <div class="col-sm-2 form-group required control-label" align="left">
                                        <label for='tipo'>Tipo</label>
                                        @if($pago->id == -1)
                                            <select name="tipo"  class="form-control" required>
                                        @else
                                            <input type="hidden" name="tipo" value="<?php echo e($tipoSelected); ?>">
                                            <select name="tipo"  class="form-control" disabled>
                                        @endif
                                            @foreach($tiposForDropdown as $tipo)
                                                <option value="{{ $tipo }}" {{ $tipo == $tipoSelected ? 'selected="selected"' : '' }}> {{ $tipo }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-2 form-group required control-label" align="left">
                                        <label for='cuenta'>Cuenta</label>
                                             @if($pago->id == -1)
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
                                    <div class="col-sm-3 form-group required control-label" align="left">
                                        @if($esCliente == 1)
                                            <label for='cli_prov_id'>Cliente</label>

                                            @if($cliProvSelected!=-1)
                                                <a href="{{ URL::to('cliente/'.$cliProvSelected)}}" class="glyphicon glyphicon-edit"></a>
                                            @else
                                                <a href="{{ URL::to('cliente/-1')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                            @endif
                                        @else
                                            <label for='cli_prov_id'>Proveedor</label>
                                            @if($cliProvSelected!=-1)
                                                <a href="{{ URL::to('proveedore/'.$cliProvSelected)}}" class="glyphicon glyphicon-edit"></a>
                                            @else
                                                 <a href="{{ URL::to('proveedor/-1')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                            @endif
                                        @endif

                                        @if($pago->id == -1 and $cliProvSelected == -1)
                                            <select name="cli_prov_id"  class="form-control" required>
                                        @else
                                            <input type="hidden" name="cli_prov_id" value="{{$cliProvSelected}}">
                                            <select name="cli_prov_id"  class="form-control" disabled>
                                        @endif
                                            @foreach($cliProvForDropdown as $cliProv)
                                                <option value="{{ $cliProv->id }}" {{ $cliProv->id == $cliProvSelected ? 'selected="selected"' : '' }}> {{ $cliProv->nombre }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4 form-group control-label" align="left">
                                        @if($esCliente == 1)
                                            <label for='proy_coti_id'>Proyecto</label>

                                            @if($cliProvSelected!=-1)
                                                <a href="{{ URL::to('proyecto/'.$proyCotiSelected)}}" class="glyphicon glyphicon-edit"></a>
                                            @else
                                                <a href="{{ URL::to('proyecto/-1')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                            @endif
                                        @else
                                            <label for='proy_coti_id'>CXP</label>
                                            @if($cliProvSelected!=-1)
                                                <a href="{{ URL::to('cotizacion/'.$proyCotiSelected)}}" class="glyphicon glyphicon-edit"></a>
                                            @else
                                                <a href="{{ URL::to('cotizacion/-1')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                                            @endif
                                        @endif

                                            @if($proyCotiSelected == -1 or $proyCotiSelected == -2)
                                                <select name="proy_coti_id"  class="form-control" required>
                                            @else
                                                <input type="hidden" name="proy_coti_id" value="<?php echo e($proyCotiSelected); ?>">
                                                <select name="proy_coti_id"  class="form-control" disabled>
                                            @endif
                                            <option value="---" {{ $cliProv->id == -1 ? 'selected="selected"' : '' }}>
                                            @if($esCliente == 1)
                                                {{"--- SIN PROYECTO ---"}}
                                            @else
                                                {{"--- SIN CXP ---"}}
                                            @endif
                                            </option>

                                            @foreach($proyCotiForDropdown as $proyCoti)
                                                <option value="{{ $proyCoti->id }}" {{ $proyCoti->id == $proyCotiSelected ? 'selected="selected"' : '' }}> {{$proyCoti->nombre}}
                                                (
                                                @if($esCliente == 1)
                                                    {{$proyCoti->cliente->nombre}}
                                                @else
                                                    {{$proyCoti->proveedor->nombre}}
                                                @endif
                                                ) </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-1">
                                    </div>
                                    <div class="col-sm-2 form-group required control-label" align="left">
                                        <label for='monto'>Monto</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">$</span>
                                            @if($pago->id == -1)
                                                <input type='number' name='monto' id='monto' step='0.01' min="0" value='{{$pago->monto}}' class='float form-control' required>
                                            @else
                                                <input type="hidden" name="monto" value="<?php echo e($pago->monto); ?>">
                                                <input type='number' name='monto' id='monto' step='0.01' min="0" value='{{$pago->monto}}' class='float form-control' disabled>
                                            @endif
                                        </div>
                                    </div>
                                     <div class="col-sm-2 form-group control-label" align="left">
                                        <div><br></div>
                                        <div>
                                            @if($pago->id == -1)
                                                <a id="more" href="#" onclick="
                                                    $('.details').slideToggle(1);
                                                    $('.details1').slideToggle(1);
                                                ">
                                                    <input type="checkbox" class="form-check-input" id="conIva" name="conIva" value="1" {{ $pago->con_iva ? 'checked="checked"' : ''}}>Con IVA</input>
                                                </a>
                                            @else
                                                <input type="hidden" name="conIva" value="<?php echo e($pago->con_iva); ?>">
                                                <input type="checkbox" class="form-check-input" id="conIva" name="conIva" value="1" {{ $pago->con_iva ? 'checked="checked"' : ''}} disabled>Con IVA</input>
                                            @endif
                                        </div>
                                     </div>
                                     <div class="col-sm-3 form-group required control-label" align="left">
                                        <label for='fecha'>Fecha</label>

                                        @if($pago->id == -1)
                                            <input type='date' name='fecha' id='fecha' value='{{$pago->fecha_pago}}' class="form-control" required>
                                        @else
                                            <input type="hidden" name="fecha" value="<?php echo e($pago->fecha_pago); ?>">
                                            <input type='date' name='fecha' id='fecha' value='{{$pago->fecha_pago}}' class="form-control" disabled>
                                        @endif
                                     </div>
                                     <div class="col-sm-4 form-group required control-label" align="left">
                                        <label for='monto'>Descripcion</label>
                                        <input type='text' name='descripcion' id='descripcion' value='{{$pago->descripcion}}'  class="form-control" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                    </div>
                                    <!--div class="col-sm-2 form-group required control-label" align="left">
                                        <label for='entrega'>Entrega</label>
                                        @if($pago->id == -1)
                                            <input type='text' name='entrega' id='entrega' value='{{$pago->entrega}}'  class="form-control" required>
                                        @else
                                            <input type="hidden" name="entrega" value="<?php echo e($pago->entrega); ?>">
                                           <input type='text' name='entrega' id='entrega' value='{{$pago->entrega}}'  class="form-control" disabled>
                                        @endif
                                    </div>
                                    <div class="col-sm-2 form-group required control-label" align="left">
                                        <label for='recibe'>Recibe</label>
                                         @if($pago->id == -1)
                                            <input type='text' name='recibe' id='recibe' value='{{$pago->recibe}}'  class="form-control" required>
                                        @else
                                            <input type="hidden" name="recibe" value="<?php echo e($pago->recibe    ); ?>">
                                            <input type='text' name='recibe' id='recibe' value='{{$pago->recibe}}'  class="form-control" disabled>
                                        @endif

                                    </div-->
                                     <div class="col-sm-2 form-group required control-label" align="left">
                                        <label for='estatus'>Estatus</label>
                                        <span class="details" style="display:visible">
                                            <select name="estatus"  class="form-control" required>
                                            @foreach($estatusForDropdown as $estatus)
                                                <option value="{{ $estatus }}" {{ $estatus == $estatusSelected ? 'selected="selected"' : '' }}> {{ $estatus }} </option>
                                            @endforeach
                                        </select>
                                        </span>
                                        <span class="details1" style="display:none">
                                            <input type="hidden" name="estatus" value="Sin Factura">
                                            <input type='text' name='estatus' id='estatus' value='Sin Factura' class="form-control" disabled>
                                        </span>
                                    </div>
                                    <div class="col-sm-2 form-group control-label" align="left">
                                        <label for='factura'>Factura</label>
                                        <input type='text' name='factura' id='factura' value='{{$pago->numero_factura}}'  class="form-control">
                                    </div>
                                     <div class="col-sm-3 form-group control-label" align="left">
                                        <label for='fechaFact'>Fecha Factura</label>
                                        <input type='date' name='fechaFact' id='fechaFact' value='{{$pago->fecha_factura}}' class="form-control">
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container center">
                    <div class="row">
                        <div class="col-sm-12 align-self-center">
                            <p for='user'>Pago registrado por:
                                 @if($pago->id == -1)
                                    {{ Auth::user()->name }}
                                 @else
                                    {{$pago->user->name}}
                                 @endif
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 align-self-center">
                            <input type='submit' value='Guarda Pago' class='btn btn-primary btn-small'>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>