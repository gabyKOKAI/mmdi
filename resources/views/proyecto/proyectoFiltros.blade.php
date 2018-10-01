<div>
    <form method='GET' action='/proyectos'>
        <div class="row">
            <div class="col-sm-12 align-center">
                <div class="col-sm-3 form-group control-label" align="left">
                        <label for='nombre'>Nombre</label>
                        <input type='text' name='nombre' id='nombre' value='{{ app('request')->input('nombre') }}'  class="form-control">
                </div>

                <div class="col-sm-3 form-group control-label" align="left">
                    <label for='cliente'>Cliente</label>

                        <select name="cliente_id"  class="form-control">
                        <option value="all" selected="selected"> Todos </option>
                        @foreach($clientesForDropdown as $cliente1)
                            <option value="{{ $cliente1->id }}" {{ $cliente1->id == $clienteSelected ? 'selected="selected"' : '' }}> {{ $cliente1->nombre }} </option>
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

                <!--div class="col-sm-4 form-group control-label" align="left">
                        <div class="row">
                            <label class="col-sm-12">Saldo:</label>
                            <div class="col-sm-2" align="left">
                                <br>Entre
                            </div>
                            <div class="col-sm-4" align="left">
                                <input type='text' name='saldoMayorA' id='saldoMayorA'  value='{{ app('request')->input('saldoMayorA') }}'  class="form-control"></input>
                            </div>
                            <div class="col-sm-1" align="left">
                                <br>Y
                            </div>
                            <div class="col-sm-4" align="left">
                                <input type='text' name='saldoMenorA' id='saldoMenorA' value='{{ app('request')->input('saldoMenorA') }}'  class="form-control"></input>
                            </div>
                        </div>
                </div-->
                <div class="col-sm-2 form-group control-label" align="center">
                    <input type="checkbox" class="form-check-input" id="distribuido" name="distribuido" value="1" {{ app('request')->input('distribuido') ? 'checked="checked"' : '' }}>Distribuido</input>
                    <br>
                    <input type="checkbox" class="form-check-input" id="nodistribuido" name="nodistribuido" value=1 {{ app('request')->input('nodistribuido') ? 'checked="checked"' : '' }}>No Distribuido</input>
                </div>
                <div class="col-sm-2 form-group control-label" align="center">
                    <input type="checkbox" class="form-check-input" id="adicionalesDistribuido" name="adicionalesDistribuido" value=1 {{ app('request')->input('adicionalesDistribuido') ? 'checked="checked"' : '' }}>Adicional Distribuido</input>
                    <br>
                    <input type="checkbox" class="form-check-input" id="noadicionalesDistribuido" name="noadicionalesDistribuido" value=1 {{ app('request')->input('noadicionalesDistribuido') ? 'checked="checked"' : '' }}>Adicional No Distribuido</input>
                </div>
                <div class="col-sm-12 align-self-center">
                    <input type='submit' value='Aplicar Filtros' class='btn btn-primary btn-small'>
                    <br>
                </div>
            </div>
        </div>
    </form>
    <br>
    <form method='GET' action='/proyectos'>
        <input type='submit' value='Limpiar Filtros' class='btn btn-primary btn-small'>
    </form>
</div>