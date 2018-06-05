<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use mmdi\Proveedore;
use mmdi\Cliente;
use mmdi\Proyecto;
use mmdi\Contacto;
use mmdi\PagoProveedore;
use mmdi\Cotizacione;

class ProveedoreController extends Controller
{
    public function lista()
    {
         $proveedores = Proveedore::paginate(15);

		return view('proveedore.proveedoreLista')->with(['proveedores' => $proveedores]);
    }

    public function proveedore(Request $request,$id= '-1',$idCoti='-1') {
	    $proveedore = Proveedore::find($id);

	    if(!$proveedore){
            $proveedore = new Proveedore;
            $proveedore->id = -1;
        }

        $cliente = new Cliente;
        $cliente->id = -1;

        $proyecto = new Proyecto;
        $proyecto->id = -1;

        $cotizacione = new Cotizacione;
        $cotizacione->id = -1;

        $contactos = Contacto::where('proveedor_id','=',$proveedore->id)->paginate(5);

        $cotizaciones = Cotizacione::where('proveedor_id','=',$proveedore->id)->paginate(5);

        if (!$cotizaciones->isEmpty()) {
            foreach ($cotizaciones as $cotizacion1) {

                $cotizacion1->saldo = Cotizacione::getSaldo($cotizacion1);
            }
        }

        $pagos = PagoProveedore::where('cli_prov_id','=',$proveedore->id)->paginate(5);

        return view('proveedore.proveedore')->
        with([  'cliente' => $cliente, 'proyecto' => $proyecto,
                'proveedore'=>$proveedore, 'cotizacione' => $cotizacione,
                'contactos'=>$contactos,
                'cotizaciones'=>$cotizaciones,
                'pagos'=>$pagos,'esCliente'=>0,
                'idCoti'=>$idCoti]);
	}

	public function guardar(Request $request,$id) {
		# Validate the request data
		$this->validate($request, [
			'nombre' => 'required|min:3',
		]);

        $proveedore = Proveedore::find($id);

        if (!$proveedore) {
            # Instantiate a new Concepto Model object
            $proveedore = new Proveedore();
            $res = "Creado";
         } else {
            $res = "Actualizado";
        }

        # Set the parameters
        $proveedore->nombre = $request->input('nombre');
        $proveedore->descripcion = $request->input('descripcion');
        $proveedore->comentarios =  $request->input('comentario');
        $proveedore->razon_social =  $request->input('razonSocial');
        $proveedore->rfc = $request->input('rfc');
        $proveedore->calle =  $request->input('calle');
        $proveedore->delegacion_municipio =  $request->input('delegacion_municipio');
        $proveedore->colonia =  $request->input('colonia');
        $proveedore->ciudad =  $request->input('ciudad');
        $proveedore->cp =  $request->input('cp');

        $proveedore->save();

		# Redirect the user to the page to view the book
		return redirect('/proveedor/'.$proveedore->id)->with('success', 'El proveedor '.$proveedore->nombre.' fue '.$res);
	}
}
