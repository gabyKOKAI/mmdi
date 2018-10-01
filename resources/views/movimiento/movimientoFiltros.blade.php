<div>
    <div class="row">
        <div class="col-sm-12 align-center">
            <form method='GET' action='/movimientos'>
                <div class="col-sm-6 form-group control-label" align="center">
                    <div class="row">
                        <div class="col-sm-2" align="center">
                            <label for='fecha'>Fecha Pago</label>
                        </div>
                        <div class="col-sm-5" align="left">
                            Entre <input type='date' name='fechaMayorA' id='fechaMayorA' value='{{ app('request')->input('fechaMayorA') }}' class='form-control'>
                        </div>
                        <div class="col-sm-5" align="left">
                            y <input type='DATE' name='fechaMenorA' id='fechaMenorA' value='{{ app('request')->input('fechaMenorA') }}' class='form-control'>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 form-group control-label" align="center">
                    <div class="row">
                        <div class="col-sm-2" align="center">
                            <label for='monto'>Monto</label>
                        </div>
                        <div class="col-sm-5" align="left">
                            Entre <input type='number' name='montoMayorA' id='montoMayorA' step='0.01' min="0" value='{{ app('request')->input('montoMayorA') }}' class='float form-control'>
                        </div>
                        <div class="col-sm-5" align="left">
                            y <input type='number' name='montoMenorA' id='montoMenorA' step='0.01' min="0" value='{{ app('request')->input('montoMenorA') }}' class='float form-control'>
                        </div>
                    </div>
                </div>
                <div class="col-sm-1 form-group control-label" align="left">
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
                    <label for='recurso'>Recurso</label>
                    <select name="recurso_id"  class="form-control">
                        <option value="all" selected="selected"> Todos </option>
                        @foreach($recursosForDropdown as $recurso)
                            <option value="{{ $recurso->id }}" {{ $recurso->id == $recursoSelected ? 'selected="selected"' : '' }}> {{ $recurso->nombre }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2 form-group control-label" align="left">
                    <label for='cuenta'>Cuenta</label>
                    <select name="cuenta_id"  class="form-control">
                        <option value="all" selected="selected"> Todos </option>
                        @foreach($cuentasForDropdown as $cuenta)
                            <option value="{{ $cuenta->id }}" {{ $cuenta->id == $cuentaSelected ? 'selected="selected"' : '' }}> {{ $cuenta->nombre }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-1 align-self-center">
                    <br>
                    <input type='submit' value='Aplicar Filtros' class='btn btn-primary btn-small'>
                </div>
            </form>
            <form method='GET' action='/movimientos'>
                <div class="col-sm-2 align-self-center">
                    <br>
                    <input type='submit' value='Limpiar Filtros' class='btn btn-primary btn-small'>
                </div>
            </form>
        </div>
    </div>
</div>