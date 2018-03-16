<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use mmdi\Cliente;
use mmdi\Proyecto;
use mmdi\Proveedore;
use mmdi\Contacto;
use mmdi\PagoCliente;

class ClienteController extends Controller
{
    public function lista()
    {
        $clientes = Cliente::paginate(15);

		return view('cliente.clienteLista')->with(['clientes' => $clientes]);
    }

    public function cliente(Request $request,$id= '-1') {
	    $cliente = Cliente::find($id);

	     if(!$cliente){
            $cliente = new Cliente;
            $cliente->id = -1;
        }

         $proveedore = new Proveedore;
         $proveedore->id = -1;

        $contactos = Contacto::where('cliente_id','=',$cliente->id)->paginate(5);
        $proyectos = Proyecto::where('cliente_id','=',$cliente->id)->paginate(5);
        $proyectos = Proyecto::where('cliente_id','=',$cliente->id)->paginate(5);
        $pagos = PagoCliente::where('cli_prov_id','=',$cliente->id)->paginate(5);

        return view('cliente.cliente')->
        with(['cliente' => $cliente, 'proveedore'=>$proveedore, 'contactos'=>$contactos, 'proyectos'=>$proyectos,'pagos'=>$pagos,'esCliente'=>1]);
	}

	public function guardar(Request $request,$id) {
		# Validate the request data
		$this->validate($request, [
			'nombre' => 'required|min:3',
		]);

        $cliente = Cliente::find($id);

        if (!$cliente) {
            # Instantiate a new Concepto Model object
            $cliente = new Cliente();
            $res = "Creado";
         } else {
            $res = "Actualizado";
        }

        # Set the parameters
        $cliente->nombre = $request->input('nombre');
        $cliente->descripcion = $request->input('descripcion');
        $cliente->comentarios =  $request->input('comentario');
        $cliente->razon_social =  $request->input('razonSocial');
        $cliente->rfc = $request->input('rfc');
        $cliente->correo_factura =  $request->input('correoFactura');


        $cliente->save();

		# Redirect the user to the page to view the book
		return redirect('/cliente/'.$cliente->id)->with('success', 'El cliente '.$cliente->nombre.' fue '.$res);
	}
}
