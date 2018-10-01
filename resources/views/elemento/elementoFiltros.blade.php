<div>
    <div class="row">
        <div class="col-sm-12 align-center">
            <form method='GET' action='/elementos'>
                <div class="col-sm-4 form-group control-label" align="left">
                    <label for='nombre'>Nombre Elemento (PU)</label>
                    <input type='text' name='nombre' id='nombre' value='{{ app('request')->input('nombre') }}' class="form-control">
                </div>
                <div class="col-sm-2 form-group control-label" align="left">
                    <label for='tipo'>Tipo</label>
                    <select name="tipo"  class="form-control" required>
                        <option value="all" selected="selected"> Todos </option>
                        @foreach($tiposForDropdown as $tipo)
                            <option value="{{ $tipo }}" {{ $tipo == $tipoSelected ? 'selected="selected"' : '' }}> {{ $tipo }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3 form-group control-label" align="left">
                    <label for='proveedor_id'>Proveedor</label>
                    <select name="proveedor_id"  class="form-control">
                        <option value="all" selected="selected"> Todos </option>
                        @foreach($proveedoresForDropdown as $proveedor)
                            <option value="{{ $proveedor->id }}" {{ $proveedor->id == $proveedorSelected ? 'selected="selected"' : '' }}> {{ $proveedor->nombre }} </option>
                        @endforeach
                    </select>

                </div>
                <div class="col-sm-1 align-self-center">
                    <br>
                    <input type='submit' value='Aplicar Filtros' class='btn btn-primary btn-small'>
                </div>
            </form>
            <form method='GET' action='/elementos'>
               <div class="col-sm-2 align-self-center">
                    <br>
                    <input type='submit' value='Limpiar Filtros' class='btn btn-primary btn-small'>
                </div>
            </form>
        </div>
    </div>
</div>