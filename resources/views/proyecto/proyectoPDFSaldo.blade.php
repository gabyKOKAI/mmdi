<!DOCTYPE html>

<html>
    <head>
        <title>Saldo {{$proyecto->nombre}}</title>

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
                    <?php setlocale(LC_ALL,"es_ES"); ?>
                    {{strftime("CDMX, %A %d de %B del %Y")}}
                    <?php setlocale(LC_ALL,NULL); ?>
                </p>
                <p class="left fontBold">At´n: {{$proyecto->cliente->nombre}}
                <br> P R E S E N T E
                <br> {{$proyecto->nombre}}
                </p>
            </div>
        </div>
        @if(count($pagos)>0)
            <div class="margenTexto">
                <table class="table">
                    <thead>
                        <tr class="black">
                            <th colspan=8 class="center font110">Pagos</th>
                        </tr>
                        <tr class="gris">
                            <th class="center">#</th>
                            <th class="center">Descripcion</th>
                            <th class="center">Forma de Pago</th>
                            <th class="center">Estatus </th>
                            <th class="center">Fecha</th>
                            <th class="center">Pago </th>
                            <th class="center">IVA </th>
                            <th class="center">NETO </th>
                        </tr>
                    </thead>
                    <tbody>
                        {{$con = 1}}
                        {{$totalPagosSinIVA = 0}}
                        {{$totalPagosIVA = 0}}
                        {{$totalPagosConIVA = 0}}
                         @foreach($pagos as $pago)
                            @if($pago->estatus != "Cancelado")
                            <tr>
                                <td class="center"> {{$con}}</td>
                                <td class="center"> {{$pago->descripcion}}</td>
                                <td class="center"> {{$pago->tipo}}</td>
                                <td class="center"> {{$pago->estatus}}</td>
                                <td class="center">{{$pago->fecha_pago}}</td-->
                                <td class="right">$ {{number_format($pago->monto,2)}}</td>
                                {{$totalPagosConIVA = $totalPagosConIVA + $pago->monto}}
                                @if($pago->con_iva)
                                    <td class="right">$ {{number_format($pago->monto*(.16/1.16),2)}}</td>
                                    {{$totalPagosIVA = $totalPagosIVA + $pago->monto*(.16/1.16)}}
                                    <td class="right">$ {{number_format($pago->monto/1.16,2)}}</td>
                                    {{$totalPagosSinIVA = $totalPagosSinIVA + $pago->monto/1.16}}
                                @else
                                    <td class="right">$ {{number_format(0,2)}}</td>
                                    <td class="right">$ {{number_format($pago->monto,2)}}</td>
                                    {{$totalPagosSinIVA = $totalPagosSinIVA + $pago->monto}}
                                @endif
                            </tr>
                            {{$con = $con + 1}}
                            @endif
                        @endforeach
                        <tr>
                            <td colspan=8></td>
                        </tr>
                        <tr>
                            <td colspan=5></td>
                            <td class="right gris">$ {{number_format($totalPagosConIVA,2)}}</td>
                            <td class="right gris">$ {{number_format($totalPagosIVA,2)}}</td>
                            <td class="right gris">$ {{number_format($totalPagosSinIVA,2)}}</td>
                        </tr>
                        <tr>
                            <td colspan=8></td>
                        </tr>
                        <tr>
                            <td colspan=5></td>
                            <td colspan=2 class="right gris">TOTAL PROYECTO</td>
                            <td class="right gris">$ {{number_format($proyecto->totAdicionales, 2)}}</td>
                        </tr>
                        <tr>
                            <td colspan=5></td>
                            <td colspan=2 class="right gris">SALDO</td>
                            <td class="right gris">$ {{number_format($proyecto->saldo,2)}}</td>
                        </tr>


                    </tbody>
                </table>
            </div>
        @else
            <h4>Sin Pagos</h4>
        @endif
        <br>
        <div class="margenTexto">
                <p class="center font140">
                    MM DISEÑO
                </p>
                <p class="left">
                <span class="fontBold">NOTA:</span> <span class="fontItalic">{{$proyecto->nota_PDF}}</span>
                </p>

            </div>
        </div>
    </div>
  </body>
</html>