<!DOCTYPE html>
<html>
    <head>
        <title>Cotización {{$proyecto->nombre}}</title>

        <meta charset='utf-8'>
        <style>
            .page-break {
                page-break-after: always;
            }
            <?php include(public_path().'/css/pdf.css');?>
            <!--?php include(public_path().'/css/Bootstrap/css/bootstrap.min.css');?-->
        </style>
        <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.js"></script>
        <script src="{{URL::asset('/css/Bootstrap/js/bootstrap.min.js')}}"></script-->

    </head>
  <body>
  <header>
  </header>
    <!--h1>Page 1</h1-->
    <!--div class="page-break"></div-->
    <!--h1>Page 2</h1-->

    <div class="container center">
        <div class="row">
            <div class="col-sm-3 align-self-left">
            </div>
            <div class="col-sm-6 align-self-center">
               <img src='http://moramoradiseno.com/wp-content/uploads/2017/06/cropped-mm-diseno.001-2.png' style='width:300px' alt='MMDI Logo' class="center">
            </div>
            <div class="col-md-3">
            </div>
        </div>
        <div class="row">
            <div>
                <h2 class="center">Cotización para el proyecto "{{$proyecto->nombre}}"</h2>
            </div>
            <div>
                <h4 class="center">Cliente " {{$proyecto->cliente->nombre}} "</h4>
            </div>
        </div>
        <div class="row">
            <table class="table">
              <tr>
                <td class="right">
                    Inicial:
                </td>
                <td class="left">
                    {{$proyecto->inicial}}
                </td>
                <td class="right">
                    Honorarios:
                </td>
                <td class="left">
                    {{$proyecto->honorarios}}
                </td>
                <td class="right">
                    Costo:
                </td>
                <td class="left">
                    {{$proyecto->costo}}
                </td>
              </tr>
              <tr>
              <td class="right">
                    Adicionales:
                </td>
                <td class="left">
                    {{$proyecto->adicional}}
                </td>
                <td class="right">
                     Honorarios Adicionales:
                </td>
                <td class="left">
                    {{$proyecto->honorariosAdicional}}
                </td>
                <td class="right">
                    Costo Adicionales:
                </td>
                <td class="left">
                    {{$proyecto->adicional + $proyecto->honorariosAdicional}}
                </td>
              </tr>
              <tr>
               <td>

                </td>
                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
                <td class="right">
                    Saldo:
                </td>
                <td class="left">
                     {{$proyecto->saldo}}
                </td>
              </tr>
            </table>
        </div>
        <br>
        <div class="container">
            <div class="row">
                <div class="col-sm-4 align-left">
                    <hr>
                </div>
                <div class="col-sm-4 align-center">
                     <h3 class="center">Conceptos</h3>
                </div>
                <div class="col-sm-4 align-left">
                    <hr>
                </div>
            </div>
        </div>
        @if(count($conceptos)>0)
            <div class="row">
                <table class="table table-hover table-striped .table-striped table-responsive">
                    <thead>
                        <tr>
                            <!--th class="center">#</th-->
                            <th class="center">Nombre </th>
                            <th class="center">Cantidad </th>
                            <th class="center">Unidades </th>
                            <th class="center">Precio </th>
                            <th class="center">Fecha</th>
                            <th class="center">Estatus </th>
                            <th class="center">Total </th>
                            <th class="center">Adicinal </th>
                        </tr>
                    </thead>
                    <tbody>
                         @foreach($conceptos as $concepto)
                            <tr>
                                <!--td class="center"> <a href="{{ URL::to('concepto/' . $concepto->id) }}">{{$concepto->id}}</a></td-->
                                <td class="center"> {{$concepto->nombre}}</td>
                                <td class="center">{{$concepto->cantidad}}</td>
                                <td class="center">{{$concepto->unidades}}</td>
                                <td class="center">{{$concepto->precio}}</td>
                                <td class="center">{{$concepto->fecha}}</td>
                                <td class="center">{{$concepto->estatus}}</td>
                                <td class="center">{{$concepto->total}}</td>
                                <td class="center">
                                    <input type="checkbox" class="form-check-input" id="adicional" {{ $concepto->adicional ? 'checked="checked"' : '' }} disabled>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <h4>Sin Conceptos
                @if($proyecto->id != -1)
                    <a href="{{ URL::to('concepto/-1/'.$proyecto->id)}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                @endif
            </h4>
        @endif
    </div>

    <!--div class="page-break"></div-->

    <div class="row">
      @include('pago.tablaPagos')
    </div>

  </body>
</html>