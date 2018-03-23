<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use mmdi\Elemento;
use mmdi\Proveedore;

class ElementoController extends Controller
{
      /**
    * GET /elementos
    */
    public function lista()
    {
		$elementos = Elemento::getElementos();

		return view('elemento.elementoLista')->with(['elementos' => $elementos]);
    }

    /**
	* GET
	* /proyecto/agrega
	* Display the form to add a new proyecto
	*/
	public function elemento(Request $request,$id= '-1') {
	    $elemento = Elemento::find($id);

	    # Get proveedores
        $proveedoresForDropdown = Proveedore::all();

        # Get tipos
        $tiposForDropdown = Elemento::getTiposDropDown();

        # Get tiposGanancias
        $tiposGananciasForDropdown = Elemento::getTiposGananciasDropDown();

        $tipoSelected = -1;
        $tipoGananciaSelected = -1;
        $proveedorSelected = -1;
        if($elemento){
            $tipoSelected = $elemento->tipo;
            $tipoGananciaSelected = $elemento->tipo_ganancia;
            $proveedorSelected = $elemento->proveedor_id;
            $elemento->precio = Elemento::getPrecio($elemento);
        }
        else{
            $elemento = new Elemento;
            $elemento->id = -1;
        }

        return view('elemento.elemento')->
        with(['elemento' => $elemento, 'tiposForDropdown' => $tiposForDropdown,'tipoSelected'=>$tipoSelected,'tiposGananciasForDropdown' => $tiposGananciasForDropdown,'tipoGananciaSelected'=>$tipoGananciaSelected,'proveedoresForDropdown' => $proveedoresForDropdown,'proveedorSelected'=>$proveedorSelected]);
	}

	/**
	* POST
	* /proyecto
	* Process the form for adding a new book
	*/
	public function guardar(Request $request,$id) {
		# Validate the request data
		$this->validate($request, [
			'nombre' => 'required|min:3',
			'unidades' => 'required',
		]);

        $elemento = Elemento::find($id);

        if (!$elemento) {
            # Instantiate a new Concepto Model object
            $elemento = new Elemento();
            $res = "Creado";
         } else {
            $res = "Actualizado";
        }

        # Set the parameters
        $elemento->nombre = $request->input('nombre');
        $elemento->unidades = $request->input('unidades');
        $elemento->proveedor_id =  $request->input('proveedor_id');
        $elemento->tipo = $request->input('tipo');
        $elemento->comentario =  $request->input('comentario');
        $elemento->costo =  $request->input('costo');
        $elemento->ganancia =  $request->input('ganancia');
        $elemento->tipo_ganancia =  $request->input('tipo_ganancia');

        $elemento->save();

		# Redirect the user to the page to view the book
		return redirect('/elemento/'.$elemento->id)->with('success', 'El elemento '.$elemento->nombre.' fue '.$res);
	}

}
