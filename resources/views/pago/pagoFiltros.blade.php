<div>
    <div class="row">
        <div class="col-sm-12 align-center">
            @if($esCliente == 1)
                <form method='GET' action='/pagosClientes'>
            @else
                <form method='GET' action='/pagosProveedores'>
            @endif
                <div class="col-sm-3 form-group control-label" align="left">
                    @if($esCliente == 1)
                        <label for='cli_prov_id'>Cliente</label>
                    @else
                        <label for='cli_prov_id'>Proveedor</label>
                    @endif
                    <select name="cli_prov_id"  class="form-control">
                        <option value="all" selected="selected"> Todos </option>
                        @foreach($cliProvForDropdown as $cliprov)
                            <option value="{{ $cliprov->id }}" {{ $cliprov->id == $cliProvSelected ? 'selected="selected"' : '' }}> {{ $cliprov->nombre }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3 form-group control-label" align="left">
                    @if($esCliente == 1)
                        <label for='proy_coti_id'>Proyecto</label>

                    @else
                        <label for='proy_coti_id'>Cotización</label>
                    @endif
                    <select name="proy_coti_id"  class="form-control">
                        <option value="all" selected="selected"> Todos </option>
                        @foreach($proyCotiForDropdown as $proycoti)
                            <option value="{{ $proycoti->id }}" {{ $proycoti->id == $proyCotiSelected ? 'selected="selected"' : '' }}> {{ $proycoti->nombre }} </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-2 form-group control-label" align="left">
                    <label for='tipo'>Tipo</label>
                    <select name="tipo"  class="form-control">
                        <option value="all" selected="selected"> Todos </option>
                        @foreach($tiposForDropdown as $tipo)
                            <option value="{{ $tipo }}" {{ $tipo == $tipoSelected ? 'selected="selected"' : '' }}> {{ $tipo }} </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-2 form-group control-label" align="left">
                    <label for='cuenta_id'>Cuenta</label>
                    <select name="cuenta_id"  class="form-control">
                        <option value="all" selected="selected"> Todos </option>
                        @foreach($cuentasForDropdown as $cuenta)
                            <option value="{{ $cuenta->id }}" {{ $cuenta->id == $cuentaSelected ? 'selected="selected"' : '' }}> {{ $cuenta->nombre }} </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-2 form-group control-label" align="left">
                    <label for='estatus'>Estatus</label>
                    <select name="estatus"  class="form-control">
                    <option value="all" selected="selected"> Todos </option>
                    @foreach($estatusForDropdown as $estatus)
                        <option value="{{ $estatus }}" {{ $estatus == $estatusSelected ? 'selected="selected"' : '' }}> {{ $estatus }} </option>
                    @endforeach
                    </select>
                </div>
                <div class="col-sm-1 form-graoup control-label" align="right">
                        <br>
                        <label for='monto'>Monto</label>
                </div>
                <div class="col-sm-2 form-group control-label" align="right">
                    <div class="col-sm-3" align="center">
                        <p'>Entre</p>
                    </div>
                    <div class="col-sm-9" align="left">
                        <input type='number' name='montoMayorA' id='montoMayorA' step='0.01' min="0" value='{{ app('request')->input('montoMayorA') }}' class='float form-control'>
                    </div>
                    <div class="col-sm-3" align="center">
                        <p'>y</p>
                    </div>
                    <div class="col-sm-9" align="left">
                        <input type='number' name='montoMenorA' id='montoMenorA' step='0.01' min="0" value='{{ app('request')->input('montoMenorA') }}' class='float form-control'>
                    </div>
                </div>
                <div class="col-sm-1 form-group control-label" align="center">
                        <br>
                        <label for='fecha'>Fecha Pago</label>
                </div>
                <div class="col-sm-3 form-graoup control-label" align="right">
                    <div class="col-sm-3" align="center">
                        <p'>Entre</p>
                    </div>
                    <div class="col-sm-9" align="left">
                        <input type='date' name='fechaMayorA' id='fechaMayorA' value='{{ app('request')->input('fechaMayorA') }}' class='form-control'>
                    </div>
                    <div class="col-sm-3" align="center">
                        <p'>y</p>
                    </div>
                    <div class="col-sm-9" align="left">
                        <input type='DATE' name='fechaMenorA' id='fechaMenorA' value='{{ app('request')->input('fechaMenorA') }}' class='form-control'>
                    </div>
                </div>

                <div class="col-sm-1 align-self-center">
                    <br>
                    <input type='submit' value='Aplicar Filtros' class='btn btn-primary btn-small'>
                </div>
            </form>
            @if($esCliente == 1)
                <form method='GET' action='/pagosClientes'>
            @else
                <form method='GET' action='/pagosProveedores'>
            @endif
               <div class="col-sm-2 align-self-center">
                    <br>
                    <input type='submit' value='Limpiar Filtros' class='btn btn-primary btn-small'>
                </div>
            </form>
        </div>
    </div>
</div>