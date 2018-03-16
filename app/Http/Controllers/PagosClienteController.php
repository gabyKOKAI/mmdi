<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use mmdi\PagoCliente;
use mmdi\Cliente;
use mmdi\Proveedore;
use mmdi\Cuenta;
use mmdi\Proyecto;

class PagosClienteController extends Controller
{
    public function lista()
    {
         $pagosClientes = PagoCliente::paginate(15);

         $cliente = new Cliente;
         $cliente->id = -1;

         $proveedore = new Proveedore;
         $proveedore->id = -1;

		return view('pago.pagosClienteLista')->with(['pagos' => $pagosClientes,'proveedore'=>$proveedore,'cliente'=>$cliente, 'esCliente'=>1]);
    }

    public function pagoCliente(Request $request,$id= '-1',$idCli='-1',$idCue= '-1') {
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
            $cuentaSelected = $idCue;
            if($idCli != -1){
                $proyCotiForDropdown = Proyecto::where('cliente_id','=',$idCli)->get();
            }
        }

        return view('pago.pagoCliente')->
        with(['pago' => $pago,
        'cli_prov'=>$cliente,
        'cliProvForDropdown' => $cliProvForDropdown,'cliProvSelected'=>$cliProvSelected,
        'proyCotiForDropdown' => $proyCotiForDropdown,'proyCotiSelected'=>$proyCotiSelected,
        'cuentasForDropdown' => $cuentasForDropdown,'cuentaSelected'=>$cuentaSelected,
        'tiposForDropdown' => $tiposForDropdown,'tipoSelected'=>$tipoSelected,
        'estatusForDropdown' => $estatusForDropdown,'estatusSelected'=>$estatusSelected,
        'esCliente'=>1]);
	}

	public function guardar(Request $request,$id= '-1',$idCli='-1') {

		# Validate the request data
		$this->validate($request, [
			'descripcion' => 'required|min:3',
		]);

        $pago = PagoCliente::find($id);

        if (!$pago) {
            # Instantiate a new Concepto Model object
            $pago = new PagoCliente();
            $res = "Creado";
         } else {
            $res = "Actualizado";
        }

        # Set the parameters
        $pago->monto = $request->input('monto');
        $pago->fecha_pago = $request->input('fecha');
        if ($request->input('conIva')) {
            $pago->con_iva = 1;
        } else{
            $pago->con_iva = 0;
        }
        $pago->numero_factura =  $request->input('factura');
        $pago->fecha_factura = $request->input('fechaFact');
        $pago->entrega =  $request->input('entrega');
        $pago->recibe = $request->input('recibe');
        $pago->descripcion = $request->input('descripcion');
        $pago->tipo =  $request->input('tipo');
        $pago->estatus =  $request->input('estatus');
        $pago->cuenta_id = $request->input('cuenta');
        $pago->cli_prov_id =  $request->input('cli_prov_id');
        if ( $request->input('proy_coti_id') != "---"){
            $pago->proy_coti_id = $request->input('proy_coti_id');
        }

        $pago->save();

		# Redirect the user to the page to view the book
		return redirect('/pagoCliente/'.$pago->id)->with('success', 'El pago cliente por '.$pago->monto.' fue '.$res);
		#return view('layouts.prueba');
	}
}
