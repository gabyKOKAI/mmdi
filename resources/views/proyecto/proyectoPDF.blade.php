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

    <div class="center">
        <div>
               <img src='http://moramoradiseno.com/wp-content/uploads/2017/06/cropped-mm-diseno.001-2.png' style='width:300px' alt='MMDI Logo' class="center">
        </div>
        <div class="margenTexto">
                <p class="right">
                    CDMX, FECHA
                </p>
                <p class="left fontBold">At´n: {{$proyecto->cliente->nombre}}
                <br> P R E S E N T E
                <br> {{$proyecto->nombre}}
                </p>
            </div>
        </div>
        @if(count($conceptos)>0)
            <div class="margenTexto">
                <table class="table">
                    <thead>
                        <tr class="black">
                            <th colspan=6 class="center font110">Conceptos Iniciales</th>
                        </tr>
                        <tr class="gris">
                            <th class="center">#</th>
                            <th class="center">Nombre </th>
                            <th class="center">Cantidad </th>
                            <th class="center">Unidades </th>
                            <th class="center">Precio </th>
                            <!--th class="center">Fecha</th-->
                            <!--th class="center">Estatus </th-->
                            <th class="center">Total </th>
                        </tr>
                    </thead>
                    <tbody>
                        {{$con = 1}}
                         @foreach($conceptos as $concepto)

                          @if(!$concepto->adicional)
                            <tr>
                                <!--td class="center"> <a href="{{ URL::to('concepto/' . $concepto->id) }}">{{$concepto->id}}</a></td-->
                                <td class="center"> {{$con}}</td>
                                <td class="center"> {{$concepto->nombre}}</td>
                                <td class="center">{{$concepto->cantidad}}</td>
                                <td class="center">{{$concepto->unidades}}</td>
                                <td class="center">$ {{number_format($concepto->precio,2)}}</td>
                                <!--td class="center">{{$concepto->fecha}}</td-->
                                <!--td class="center">{{$concepto->estatus}}</td-->
                                <td class="right">$ {{number_format($concepto->precio*$concepto->cantidad,2)}}</td>
                            </tr>
                            {{$con = $con + 1}}
                            @endif

                        @endforeach
                        <tr>
                            <!--td class="center"> <a href="{{ URL::to('concepto/' . $concepto->id) }}">{{$concepto->id}}</a></td-->
                            <td class="center"> {{$con}}</td>
                            <td class="center">Honorarios</td>
                            <td class="center">1</td>
                            <td class="center">S/U</td>
                            <td class="center">$ {{number_format($proyecto->honorarios,2)}}</td>
                            <!--td class="center">fecha</td-->
                            <!--td class="center">estatus</td-->
                            <td class="right">$ {{number_format($proyecto->honorarios,2)}}</td>
                        </tr>
                        <tr>
                            <td colspan=4></td>
                            <td class="right gris">SUBTOTAL</td>
                            <td class="right gris">$ {{number_format($proyecto->costo,2)}}</td>
                        </tr>
                        <tr>
                            <td colspan=4></td>
                            <td class="right gris">IVA (16%)</td>
                            <td class="right gris">$ {{number_format($proyecto->costo*.16,2)}}</td>
                        </tr>
                        <tr>
                            <td colspan=4></td>
                            <td class="right gris">TOTAL</td>
                            <td class="right gris">$ {{number_format($proyecto->costo*1.16,2)}}</td>
                        </tr>


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
        <br>
        @if(count($conceptos)>0)
            <div class="margenTexto">
                <table class="table">
                    <thead>
                        <tr class="black">
                            <th colspan=6 class="center font110">Conceptos Adicionales</th>
                        </tr>
                        <tr class="gris">
                            <th class="center">#</th>
                            <th class="center">Nombre </th>
                            <th class="center">Cantidad </th>
                            <th class="center">Unidades </th>
                            <th class="center">Precio </th>
                            <!--th class="center">Fecha</th-->
                            <!--th class="center">Estatus </th-->
                            <th class="center">Total </th>
                        </tr>
                    </thead>
                    <tbody>
                        {{$con = 1}}
                         @foreach($conceptos as $concepto)

                          @if($concepto->adicional)
                            <tr>
                                <!--td class="center"> <a href="{{ URL::to('concepto/' . $concepto->id) }}">{{$concepto->id}}</a></td-->
                                <td class="center"> {{$con}}</td>
                                <td class="center"> {{$concepto->nombre}}</td>
                                <td class="center">{{$concepto->cantidad}}</td>
                                <td class="center">{{$concepto->unidades}}</td>
                                <td class="center">$ {{number_format($concepto->precio,2)}}</td>
                                <!--td class="center">{{$concepto->fecha}}</td-->
                                <!--td class="center">{{$concepto->estatus}}</td-->
                                <td class="right">$ {{number_format($concepto->precio*$concepto->cantidad,2)}}</td>
                            </tr>
                            {{$con = $con + 1}}
                            @endif
                        @endforeach
                        <tr>
                            <!--td class="center"> <a href="{{ URL::to('concepto/' . $concepto->id) }}">{{$concepto->id}}</a></td-->
                            <td class="center"> {{$con}}</td>
                            <td class="center">Honorarios</td>
                            <td class="center">1</td>
                            <td class="center">S/U</td>
                            <td class="center">$ {{number_format($proyecto->honorariosAdicional,2)}}</td>
                            <!--td class="center">fecha</td-->
                            <!--td class="center">estatus</td-->
                            <td class="right">$ {{number_format($proyecto->honorariosAdicional,2)}}</td>
                        </tr>
                        <tr class="gris">
                            <td colspan=5 class="right">SUBTOTAL</td>
                            <td class="right">$ {{number_format($proyecto->adicional + $proyecto->honorariosAdicional,2)}}</td>
                        </tr>
                        <tr class="gris">
                            <td colspan=5 class="right">IVA (16%)</td>
                            <td class="right">$ {{number_format(($proyecto->adicional + $proyecto->honorariosAdicional)*.16,2)}}</td>
                        </tr>
                        <tr class="gris">
                            <td colspan=5 class="right">TOTAL</td>
                            <td class="right">$ {{number_format(($proyecto->adicional + $proyecto->honorariosAdicional)*1.16,2)}}</td>
                        </tr>

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
        <div class="margenTexto">
                <p class="center font140">
                    MM DISEÑO
                </p>
                <p class="left">
                <span class="fontBold">Forma de Pago:</span> 60% de anticipo
                <br>
                <span class="fontBold">Tiempo de Entrega:</span> 8 semanas
                <br>
                <span class="fontBold">* Precios sujetos a cambio de acuerdo al TC del día. (USD/MXN)</span>
                </p>

            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="row">
      @include('pago.tablaPagos')
      <div class="margenTexto">
                <p class="right">
                    Saldo: {{$proyecto->saldo}}
                </p>
            </div>
        </div>
    </div>

  </body>
</html>