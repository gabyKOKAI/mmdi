<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use mmdi\PagoProveedore;
use mmdi\Proveedore;
use mmdi\Cliente;
use mmdi\Cotizacione;
use mmdi\Cuenta;


class PagosProveedoreController extends Controller
{
     public function lista()
    {
         $pagosProveedores = PagoProveedore::paginate(15);

         $cliente = new Cliente;
         $cliente->id = -1;

         $proveedore = new Proveedore;
         $proveedore->id = -1;

		return view('pago.pagosProveedoreLista')->with(['pagos' => $pagosProveedores, 'cliente'=>$cliente,'proveedore'=>$proveedore, 'esCliente'=>0]);
    }

    public function pagoProveedore(Request $request,$id= '-1',$idPro='-1',$idCue= '-1') {
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
            $cliProvSelected = $pago->cliente_id;
            $proyCotiSelected = $pago->proyecto_id;
            $cuentaSelected = $pago->cuenta_id;
            $tipoSelected = $pago->tipo;
            $estatusSelected = $pago->estatus;
        }
        else{
            $pago = new PagoProveedore;
            $pago->id = -1;
            $cuentaSelected = $idCue;
        }

        return view('pago.pagoProveedore')->
        with(['pago' => $pago,
        'cli_prov'=>$proveedore,
        'cliProvForDropdown' => $cliProvForDropdown,'cliProvSelected'=>$cliProvSelected,
        'proyCotiForDropdown' => $proyCotiForDropdown,'proyCotiSelected'=>$proyCotiSelected,
        'cuentasForDropdown' => $cuentasForDropdown,'cuentaSelected'=>$cuentaSelected,
        'tiposForDropdown' => $tiposForDropdown,'tipoSelected'=>$tipoSelected,
        'estatusForDropdown' => $estatusForDropdown,'estatusSelected'=>$estatusSelected,
        'esCliente'=>0]);
	}

	public function guardar(Request $request,$id= '-1',$idPro='-1') {

		# Validate the request data
		$this->validate($request, [
			'descripcion' => 'required|min:3',
		]);

        $pago = PagoProveedore::find($id);

        if (!$pago) {
            # Instantiate a new Concepto Model object
            $pago = new PagoProveedore();
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
        dump($request->input('cli_prov_id'));
        $pago->cli_prov_id =  $request->input('cli_prov_id');
        if ( $request->input('proy_coti_id') != "---"){
            $pago->proy_coti_id = $request->input('proy_coti_id');
        }

        $pago->save();

		# Redirect the user to the page to view the book
		return redirect('/pagoProveedor/'.$pago->id)->with('success', 'El pago proveedor por '.$pago->monto.' fue '.$res);
		#return view('layouts.prueba');
	}
}
