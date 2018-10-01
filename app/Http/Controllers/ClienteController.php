<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use mmdi\Cliente;
use mmdi\Proyecto;
use mmdi\Proveedore;
use mmdi\Contacto;
use mmdi\PagoCliente;
use mmdi\Cotizacione;

class ClienteController extends Controller
{
    public function lista()
    {
        $clientes = Cliente::getClientes();

		return view('cliente.clienteLista')->with(['clientes' => $clientes]);
    }

    public function cliente(Request $request,$id= '-1',$idProy='-1') {
	    $cliente = Cliente::find($id);

	    if(!$cliente){
            $cliente = new Cliente;
            $cliente->id = -1;
        }

        $proveedore = new Proveedore;
        $proveedore->id = -1;

        $proyecto = new Proyecto;
        $proyecto->id = -1;

        $cotizacione = new Cotizacione;
        $cotizacione->id = -1;

        $contactos = Contacto::where('cliente_id','=',$cliente->id)->paginate(5);

        $proyectos = Proyecto::where('cliente_id','=',$cliente->id)->paginate(5,['*'], 'proyectos_p');

        if (!$proyectos->isEmpty()) {
            foreach ($proyectos as $proyecto1) {
                $proyecto1->costo = Proyecto::getCosto($proyecto1);
                $proyecto1->saldo = Proyecto::getSaldo($proyecto1);
            }
        }

        $pagos = PagoCliente::where('cli_prov_id','=',$cliente->id)->paginate(5,['*'], 'pagos_p');

        return view('cliente.cliente')->
        with([  'cliente' => $cliente, 'proyecto' => $proyecto,
                'proveedore'=>$proveedore, 'cotizacione' => $cotizacione,
                'contactos'=>$contactos,
                'proyectos'=>$proyectos,
                'pagos'=>$pagos,'esCliente'=>1,
                'idProy'=>$idProy]);
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
