<div>
    <div class="row">
        <div class="col-sm-12 align-center">
            <form method='GET' action='/cotizaciones'>
                <div class="col-sm-3 form-group control-label" align="left">
                        <label for='nombre'>Nombre</label>
                        <input type='text' name='nombre' id='nombre' value='{{ app('request')->input('nombre') }}'  class="form-control">
                </div>
                <div class="col-sm-2 form-group control-label" align="left">
                    <label for='proyecto'>Proyecto</label>
                    <select name="proyecto_id"  class="form-control">
                        <option value="all" selected="selected"> Todos </option>
                        @foreach($proyectosForDropdown as $proyecto)
                            <option value="{{ $proyecto->id }}" {{ $proyecto->id == $proyectoSelected ? 'selected="selected"' : '' }}> {{ $proyecto->nombre }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2 form-group control-label" align="left">
                    <label for='proveedore'>Proveedor</label>
                    <select name="proveedor_id"  class="form-control">
                        <option value="all" selected="selected"> Todos </option>
                        @foreach($proveedoresForDropdown as $proveedore1)
                            <option value="{{ $proveedore1->id }}" {{ $proveedore1->id == $proveedorSelected ? 'selected="selected"' : '' }}> {{ $proveedore1->nombre }} </option>
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
                </div>
                <div class="col-sm-2 form-group control-label" align="center">
                    <input type="checkbox" class="form-check-input" id="distribuido" name="distribuido" value="1" {{ app('request')->input('distribuido') ? 'checked="checked"' : '' }}>Distribuido</input>
                    <br>
                    <input type="checkbox" class="form-check-input" id="nodistribuido" name="nodistribuido" value=1 {{ app('request')->input('nodistribuido') ? 'checked="checked"' : '' }}>No Distribuido</input>
                </div>
                <div class="col-sm-2 form-group control-label" align="center">
                    <input type="checkbox" class="form-check-input" id="adicionalesDistribuido" name="adicionalesDistribuido" value=1 {{ app('request')->input('adicionalesDistribuido') ? 'checked="checked"' : '' }}>Adicional Distribuido</input>
                    <br>
                    <input type="checkbox" class="form-check-input" id="noadicionalesDistribuido" name="noadicionalesDistribuido" value=1 {{ app('request')->input('noadicionalesDistribuido') ? 'checked="checked"' : '' }}>Adicional No Distribuido</input>
                </div-->
                 <div class="col-sm-1 align-self-center">
                    <br>
                    <input type='submit' value='Aplicar Filtros' class='btn btn-primary btn-small'>
                </div>
            </form>
            <form method='GET' action='/cotizaciones'>
                <div class="col-sm-2 align-self-center">
                    <br>
                    <input type='submit' value='Limpiar Filtros' class='btn btn-primary btn-small'>
                </div>
            </form>
        </div>
    </div>
</div>