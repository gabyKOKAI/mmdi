<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use mmdi\PagoProveedore;
use mmdi\Cliente;
use mmdi\Proveedore;
use mmdi\Cuenta;
use mmdi\Proyecto;
use mmdi\Cotizacione;
use mmdi\Movimiento;
use mmdi\Recurso;

class PagosProveedoreController extends Controller
{
    public function lista()
    {
        $pagosProveedores = PagoProveedore::getPagos();

        $cliente = new Cliente;
        $cliente->id = -1;

        $proveedore = new Proveedore;
        $proveedore->id = -1;

        $proyecto = new Proyecto;
        $proyecto->id = -2;

        $cotizacione = new Cotizacione;
        $cotizacione->id = -2;

        $cliProvForDropdown = Proveedore::all();
        $proyCotiForDropdown = Cotizacione::all();
        $cuentasForDropdown = Cuenta::where('saldo', '<>', -1)->get();
        $tiposForDropdown = PagoProveedore::getTiposDropDown();
        $estatusForDropdown = PagoProveedore::getEstatusDropDown();

        $cliProvSelected = request('cli_prov_id');
        $proyCotiSelected = request('proy_coti_id');
        $cuentaSelected = request('cuenta');
        $tipoSelected = request('tipo');
        $estatusSelected = request('estatus');

		return view('pago.pagosProveedoreLista')
					->with(['pagos' => $pagosProveedores,
		        			'proveedore'=>$proveedore, 'cotizacione' => $cotizacione,
							'cliente'=>$cliente, 'proyecto' => $proyecto,
							'cliProvForDropdown' => $cliProvForDropdown,'cliProvSelected'=>$cliProvSelected,
                            'proyCotiForDropdown' => $proyCotiForDropdown,'proyCotiSelected'=>$proyCotiSelected,
                            'cuentasForDropdown' => $cuentasForDropdown,'cuentaSelected'=>$cuentaSelected,
                            'tiposForDropdown' => $tiposForDropdown,'tipoSelected'=>$tipoSelected,
                            'estatusForDropdown' => $estatusForDropdown,'estatusSelected'=>$estatusSelected,
		        			'esCliente'=>0]);
    }

    public function pagoProveedore(Request $request,$id= '-1',$idPro='-1',$idCoti= '-1') {
	    $pago = PagoProveedore::find($id);

	    $proveedore = Proveedore::find($idPro);
        if(!$proveedore){
            $proveedore = new Proveedore;
            $proveedore->id = $idPro;
        }

        $cliProvForDropdown = Proveedore::all();
        $proyCotiForDropdown = Cotizacione::all();
        $cuentasForDropdown = Cuenta::where('saldo', '<>', -1)->get();
        $tiposForDropdown = PagoProveedore::getTiposDropDown();
        $estatusForDropdown = PagoProveedore::getEstatusDropDown();

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
                $proyCotiForDropdown = Cotizacione::where('proveedor_id','=',$cliProvSelected)->get();
            }
        }
        else{
            $pago = new PagoProveedore;
            $pago->id = -1;
            $cliProvSelected = $idPro;
            $proyCotiSelected = $idCoti;
            $pago->fecha_pago = date("Y-m-d");
			if($idPro != -1){
                $proyCotiForDropdown = Cotizacione::where('proveedor_id','=',$idPro)->get();
            }
        }

        return view('pago.pagoProveedore')->
        with(['pago' => $pago,
        'cliProv'=>$proveedore,
        'cliProvForDropdown' => $cliProvForDropdown,'cliProvSelected'=>$cliProvSelected,
        'proyCotiForDropdown' => $proyCotiForDropdown,'proyCotiSelected'=>$proyCotiSelected,
        'cuentasForDropdown' => $cuentasForDropdown,'cuentaSelected'=>$cuentaSelected,
        'tiposForDropdown' => $tiposForDropdown,'tipoSelected'=>$tipoSelected,
        'estatusForDropdown' => $estatusForDropdown,'estatusSelected'=>$estatusSelected,
        'esCliente'=>0]);
	}

	public function guardar(Request $request,$id= '-1',$idPro='-1',$idCoti='-1') {

		# Validate the request data
		$this->validate($request, [
			'descripcion' => 'required|min:3',
		]);

        $pago = PagoProveedore::find($id);
        $cuenta = Cuenta::find($request->input('cuenta'));
        $cotizacione = Cotizacione::find($request->input('proy_coti_id'));

        if (!$pago) {
            # Instantiate a new Concepto Model object
            $pago = new PagoProveedore();
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
        if($cotizacione and $pago->con_iva == 1)
        {
            $saldo = $cotizacione->getSaldo($cotizacione)-($request->input('monto'))/1.16;
        }
        elseif($cotizacione and $pago->con_iva == 0)
        {
            $saldo = $cotizacione->getSaldo($cotizacione)-$request->input('monto');
        }

        $mensaje = "";
        if($saldo<0 and $request->input('estatus')<>'Cancelado'){
		    $tipoMensaje = "error";
		    $mensaje = 'El pago no puede hacerse porque se está pagando de más al proveedor por la CXP. El Saldo Actual es de: $ '.number_format($cotizacione->getSaldo($cotizacione));
		    $pago->id = -1;
		}elseif($cuenta->saldo < $request->input('monto') and $request->input('estatus')<>'Cancelado'){
		    $tipoMensaje = "error";
		    $mensaje = 'El pago no puede hacerse porque no se tiene suficiente dinero en la cuenta. El Saldo Actual es de: $ '.number_format($cuenta->saldo,2);
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
                $proveedor = Proveedore::find($pago->cli_prov_id);
                if($res == "Creado" and $pago->estatus <>  "Cancelado"){
                	$cuenta->saldo = $cuenta->saldo - $pago->monto;                
                    $cuenta->save();
                    Movimiento::registraMovimiento(
                        $pago->fecha_pago,
                        $pago->monto,
		                $pago->tipo.' de proveedor '.substr($proveedor->nombre,0,15).' para la CXP '.substr($cotizacione->nombre,0,15),
		                "Salida",
                        $recurso1->id,
                        $pago->cuenta_id);
                }
                if($res == "Actualizado" and $pago->estatus <> $estatusAnterior){
                    if($pago->estatus ==  "Cancelado"){
                        #agrego a la cuenta y registro movimiento inverso
                        $cuenta->saldo = $cuenta->saldo + $pago->monto;
                        $cuenta->save();
                        Movimiento::registraMovimiento(
                            $pago->fecha_pago,
                            $pago->monto,
                            'Se cancelo'.$pago->tipo.' de proveedor '.substr($proveedor->nombre,0,15).' para la CXP '.substr($cotizacione->nombre,0,15),
                            "Cancelado",
                            $recurso1->id,
                            $pago->cuenta_id);
                    }else{
                        #elimino la cuenta y registro movimiento
                        $cuenta->saldo = $cuenta->saldo - $pago->monto;
                        $cuenta->save();
                        Movimiento::registraMovimiento(
                            $pago->fecha_pago,
                            $pago->monto,
                            'Se activa '.$pago->tipo.' de proveedor '.substr($proveedor->nombre,0,15).' para la CXP '.substr($cotizacione->nombre,0,15),
                            "NoCancelado",
                            $recurso1->id,
                            $pago->cuenta_id);
                    }
                }
            }

            $tipoMensaje = "success";
		    $mensaje = $mensaje.'El pago proveedor por '.$pago->monto.' fue '.$res;

        }
		# Redirect the user to the page to view the book
		#return redirect('/pagoProveedor/'.$pago->id)->with('success', 'El pago proveedor por '.$pago->monto.' fue '.$res);
		return redirect('/pagoProveedor/'.$pago->id.'/'.$idPro.'/'.$idCoti)->with($tipoMensaje, $mensaje);
		#return view('layouts.prueba');
	}
}