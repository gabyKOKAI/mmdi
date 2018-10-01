<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use mmdi\Elemento;
use mmdi\Proveedore;
use mmdi\Concepto;

class ElementoController extends Controller
{
      /**
    * GET /elementos
    */
    public function lista()
    {
		$elementos = Elemento::getElementos();

        $concepto = new Concepto;
        $concepto->id = -2;

        # Get proveedores
        $proveedoresForDropdown = Proveedore::all();
        $proveedorSelected = request('proveedor_id');

        # Get tipos
        $tiposForDropdown = Elemento::getTiposDropDown();
        $tipoSelected = request('tipo');

		return view('elemento.elementoLista')->with(['elementos' => $elementos, 'concepto' => $concepto,'tiposForDropdown' => $tiposForDropdown,'tipoSelected'=>$tipoSelected,'proveedoresForDropdown' => $proveedoresForDropdown,'proveedorSelected'=>$proveedorSelected]);
    }

    public function proveedoresElemento($id= '-1') {
        $proveedore_id = $id;
        //dump($proveedore_id);
        $elementos = Elemento::where('proveedor_id','=',$proveedore_id)->get();
        if (!$elementos->isEmpty()) {
            foreach ($elementos as $elemento) {
                $elemento->precio = Elemento::getPrecio($elemento);
            }
        }
        //dump($elementos);
        return $elementos;

    }

    public function elementoCostoGanancia($id= '-1') {
        $res = "";
        $elemento = Elemento::find($id);
        if($elemento){
            $res = Elemento::getCostoGanancia($elemento);
        }
        return $res;
    }



    /**
	* GET
	* /proyecto/agrega
	* Display the form to add a new proyecto
	*/
	public function elemento(Request $request,$id= '-1',$idCon= '-1') {
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
        with(['elemento' => $elemento, 'tiposForDropdown' => $tiposForDropdown,'tipoSelected'=>$tipoSelected,'tiposGananciasForDropdown' => $tiposGananciasForDropdown,'tipoGananciaSelected'=>$tipoGananciaSelected,'proveedoresForDropdown' => $proveedoresForDropdown,'proveedorSelected'=>$proveedorSelected, 'idCon'=>$idCon]);
	}

	/**
	* POST
	* /proyecto
	* Process the form for adding a new book
	*/
	public function guardar(Request $request,$id, $idCon) {
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
		if($idCon != -1){
		    $concepto = Concepto::find($idCon);
		    return redirect('/conceptoElemento/'.$idCon.'/-1/'.$concepto->proyecto->id)->with('success', 'El elemento '.$elemento->nombre.' fue '.$res);
		}else{
		    return redirect('/elemento/'.$elemento->id.'/'.$idCon)->with('success', 'El elemento '.$elemento->nombre.' fue '.$res);
		}
	}

}
