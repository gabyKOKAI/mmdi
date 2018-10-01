<div>
    <div class="row">
        <div class="col-sm-12 align-center">
            <form method='GET' action='/proveedores'>
                <div class="col-sm-3 form-group control-label" align="left">
                        <label for='nombre'>Nombre</label>
                        <input type='text' name='nombre' id='nombre' value='{{ app('request')->input('nombre') }}'  class="form-control">
                </div>
                <div class="col-sm-3 form-group control-label" align="left">
                        <label for='nombre'>Razon Social</label>
                        <input type='text' name='razon_social' id='razon_social' value='{{ app('request')->input('razon_social') }}'  class="form-control">
                </div>
                <div class="col-sm-3 form-group control-label" align="left">
                        <label for='nombre'>RFC</label>
                        <input type='text' name='rfc' id='rfc' value='{{ app('request')->input('rfc') }}'  class="form-control">
                </div>
                <div class="col-sm-1 align-self-center">
                    <br>
                    <input type='submit' value='Aplicar Filtros' class='btn btn-primary btn-small'>
                </div>
            </form>
            <form method='GET' action='/proveedores'>
                <div class="col-sm-2 align-self-center">
                    <br>
                    <input type='submit' value='Limpiar Filtros' class='btn btn-primary btn-small'>
                </div>
            </form>
        </div>
    </div>
</div>