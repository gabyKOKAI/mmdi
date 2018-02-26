<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use mmdi\Proyecto;
use mmdi\Concepto;

class ConceptoController extends Controller
{

	/**
	* GET
	* /proyecto/agrega
	* Display the form to add a new proyecto
	*/
	public function concepto(Request $request,$id= '-1',$idProy='-1') {
	    $concepto = Concepto::find($id);

	    # Get proyectos
        $proyectosForDropdown = Proyecto::all();
        # Get estatus
        $estatusForDropdown = Concepto::getEstatusDropDown();
        $elementos = [];

        $proyectoSelected = -1;
        $estatusSelected = -1;
        if($concepto){
            $proyectoSelected = $concepto->proyecto_id;
            $estatusSelected = $concepto->estatus;
            # Get elementos
            $elementos = Concepto::getElementos($concepto);
            $concepto->precioCliente = $concepto->getprecio($concepto);
            $concepto->ganancia = Concepto::getGananciaReal($concepto);
            $concepto->precioTotal = $concepto->precioCliente * $concepto->cantidad;
            $concepto->gananciaTotal = $concepto->ganancia * $concepto->cantidad ;
        }
        else{
            $concepto = new Concepto;
            $concepto->id = -1;
            $proyectoSelected = $idProy;
        }

        return view('concepto.concepto')->
        with(['concepto' => $concepto,'elementos' => $elementos, 'proyectosForDropdown' => $proyectosForDropdown,'proyectoSelected'=>$proyectoSelected,'estatusForDropdown' => $estatusForDropdown,'estatusSelected'=>$estatusSelected]);
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
			'cantidad' => 'required',
			'unidades' => 'required',
			'fecha' => 'date',
			'adicional' => 'boolean',
		]);

        $concepto = Concepto::find($id);

        if (!$concepto) {
            # Instantiate a new Concepto Model object
            $concepto = new Concepto();
            $res = "Creado";
         } else {
            $res = "Actualizado";
        }

        # Set the parameters
        $concepto->nombre = $request->input('nombre');
        $concepto->cantidad = $request->input('cantidad');
        $concepto->unidades = $request->input('unidades');
        $concepto->fecha =  $request->input('fecha');
        $concepto->comentario =  $request->input('comentario');
        $concepto->estatus = $request->input('estatus');
        if ($request->input('adicional')) {
            $concepto->adicional = 1;
        } else{
            $concepto->adicional = 0;
        }
        $concepto->proyecto_id = $request->input('proyecto_id');

        $concepto->save();

		# Redirect the user to the page to view the book
		return redirect('/concepto/'.$concepto->id)->with('success', 'El concepto '.$concepto->nombre.' fue '.$res);
	}


    public function eliminar(Request $request,$idCon='-1') {

	    $concepto = Concepto::find($idCon);

	    if (!$concepto) {
            return redirect('/proyecto')->with('alert', 'concepto no encontrado');
        }

	    $concepto->elementos()->detach();

	    $proyecto_id = $concepto->proyecto_id;
	    $concepto->delete();
	    return redirect('/proyecto/'.$proyecto_id)->with('success','El concepto '.$concepto->nombre.' se elimino.');
	}
}
