<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use mmdi\PagoCliente;
use mmdi\Cliente;
use mmdi\Proveedore;
use mmdi\Cuenta;
use mmdi\Proyecto;
use mmdi\Cotizacione;
use mmdi\Movimiento;
use mmdi\Recurso;

class PagosClienteController extends Controller
{
    public function lista()
    {
         $pagosClientes = PagoCliente::paginate(15);

         $cliente = new Cliente;
         $cliente->id = -1;

         $proveedore = new Proveedore;
         $proveedore->id = -1;

         $proyecto = new Proyecto;
         $proyecto->id = -2;

         $cotizacione = new Cotizacione;
         $cotizacione->id = -2;

		return view('pago.pagosClienteLista')
		            ->with(['pagos' => $pagosClientes,
		                    'proveedore'=>$proveedore, 'cotizacione' => $cotizacione,
		                    'cliente'=>$cliente, 'proyecto' => $proyecto,
		                    'esCliente'=>1]);
    }

    public function pagoCliente(Request $request,$id= '-1',$idCli='-1',$idProy= '-1') {
	    $pago = PagoCliente::find($id);

	    $cliente = Cliente::find($idCli);
        if(!$cliente){
            $cliente = new Cliente;
            $cliente->id = $idCli;
        }

        $cliProvForDropdown = Cliente::all();
        $proyCotiForDropdown = Proyecto::all();
        $cuentasForDropdown = Cuenta::where('saldo', '<>', -1)->get();
        $tiposForDropdown = PagoCliente::getTiposDropDown();
        $estatusForDropdown = PagoCliente::getEstatusDropDown();

        $cliProvSelected = -1;
        $proyCotiSelected = -1;
        $cuentaSelected = -1;
        $tipoSelected = "Transferencia";
        $estatusSelected = "Factura Pendiente";
        if($pago){
            $cliProvSelected = $pago->cli_prov_id;
            $proyCotiSelected = $pago->proy_coti_id;
            $cuentaSelected = $pago->cuenta_id;
            $tipoSelected = $pago->tipo;
            $estatusSelected = $pago->estatus;
            if($cliProvSelected != -1){
                $proyCotiForDropdown = Proyecto::where('cliente_id','=',$cliProvSelected)->get();
            }
        }
        else{
            $pago = new PagoCliente;
            $pago->id = -1;
            $cliProvSelected = $idCli;
            $proyCotiSelected = $idProy;
            $pago->fecha_pago = date("Y-m-d");
            if($idCli != -1){
                $proyCotiForDropdown = Proyecto::where('cliente_id','=',$idCli)->get();
            }
        }

        return view('pago.pagoCliente')->
        with(['pago' => $pago,
        'cliProv'=>$cliente,
        'cliProvForDropdown' => $cliProvForDropdown,'cliProvSelected'=>$cliProvSelected,
        'proyCotiForDropdown' => $proyCotiForDropdown,'proyCotiSelected'=>$proyCotiSelected,
        'cuentasForDropdown' => $cuentasForDropdown,'cuentaSelected'=>$cuentaSelected,
        'tiposForDropdown' => $tiposForDropdown,'tipoSelected'=>$tipoSelected,
        'estatusForDropdown' => $estatusForDropdown,'estatusSelected'=>$estatusSelected,
        'esCliente'=>1]);
	}

	public function guardar(Request $request,$id= '-1',$idCli='-1',$idProy='-1') {

		# Validate the request data
		$this->validate($request, [
			'descripcion' => 'required|min:3',
		]);

        $pago = PagoCliente::find($id);
        $cuenta = Cuenta::find($request->input('cuenta'));
        $proyecto = Proyecto::find($request->input('proy_coti_id'));

        if (!$pago) {
            # Instantiate a new Concepto Model object
            $pago = new PagoCliente();
            #$pago->id = -1;
            $pago->con_iva = -1;
            $estatusAnterior = "";
            $res = "Creado";
         } else {
            $estatusAnterior = $pago->estatus;
            $res = "Actualizado";
        }

        if ($request->input('conIva')) {
            $pago->con_iva = 1;
        } else{
            $pago->con_iva = 0;
        }

        $saldo = 0;
        if($proyecto and $pago->con_iva == 1)
        {
            $saldo = $proyecto->getSaldo($proyecto)-($request->input('monto'))/1.16;
        }
        elseif($proyecto and $pago->con_iva == 0)
        {
            $saldo =$proyecto->getSaldo($proyecto)-$request->input('monto');
        }

        $mensaje = "";
        if($saldo<0 and $request->input('estatus')<>'Cancelado'){
		    $tipoMensaje = "error";
		    $mensaje = 'El pago no puede hacerse porque el cliente está pagando de más al proyecto. El Saldo Actual es de:'.$proyecto->getSaldo($proyecto);
		    $pago->id = -1;
		}
		else{

            # Set the parameters
            $pago->monto = $request->input('monto');
            $pago->fecha_pago = $request->input('fecha');
            $pago->numero_factura =  $request->input('factura');
            $pago->fecha_factura = $request->input('fechaFact');
            $pago->entrega =  "-";// $request->input('entrega');
            $pago->recibe = "-";// $request->input('recibe');
            $pago->user_id = $request->user()->id;
            $pago->descripcion = $request->input('descripcion');
            $pago->tipo =  $request->input('tipo');
            $pago->estatus =  $request->input('estatus');
            $pago->cuenta_id = $request->input('cuenta');
            $pago->cli_prov_id =  $request->input('cli_prov_id');
            if ( $request->input('proy_coti_id') != "---"){
                $pago->proy_coti_id = $request->input('proy_coti_id');
            }

            $recurso1 = Recurso::where('nombre', '=', "Proyectos")->first();

            if($mensaje== ""){
                $pago->save();
                if($res == "Creado" and $pago->estatus <>  "Cancelado"){
                    $cuenta->saldo = $cuenta->saldo + $pago->monto;
                    $cuenta->save();
                    Movimiento::registraMovimiento(
                        $pago->fecha_pago,
                        $pago->monto,
                        $pago->tipo.' de cliente '. $pago->cli_prov_id.' para el proyecto '.$pago->proy_coti_id,
                        "Entrada",
                        $recurso1->id,
                        $pago->cuenta_id);
                }
                if($res == "Actualizado" and $pago->estatus <> $estatusAnterior){
                    if($pago->estatus ==  "Cancelado"){
                        #elimino de la cuenta y registro movimiento inverso
                        $cuenta->saldo = $cuenta->saldo - $pago->monto;
                        $cuenta->save();
                        Movimiento::registraMovimiento(
                            $pago->fecha_pago,
                            $pago->monto,
                            'Se cancelo'.$pago->tipo.' de cliente '. $pago->cli_prov_id.' para el proyecto '.$pago->proy_coti_id,
                            "Cancelado",
                            $recurso1->id,
                            $pago->cuenta_id);
                    }else{
                        #agrego a la cuenta y registro movimiento
                        $cuenta->saldo = $cuenta->saldo + $pago->monto;
                        $cuenta->save();
                        Movimiento::registraMovimiento(
                            $pago->fecha_pago,
                            $pago->monto,
                            'Se activa '.$pago->tipo.' de cliente '. $pago->cli_prov_id.' para el proyecto '.$pago->proy_coti_id,
                            "NoCancelado",
                            $recurso1->id,
                            $pago->cuenta_id);
                    }
                }
            }

            $tipoMensaje = "success";
		    $mensaje = $mensaje.'El pago cliente por '.$pago->monto.' fue '.$res.$saldo;

        }
        #dump($mensaje);
		# Redirect the user to the page to view the book
		#return redirect('/pagoCliente/'.$pago->id)->with('success', 'El pago cliente por '.$pago->monto.' fue '.$res);
		return redirect('/pagoCliente/'.$pago->id.'/'.$idCli.'/'.$idProy)->with($tipoMensaje, $mensaje);
		#return view('layouts.prueba');
	}
}