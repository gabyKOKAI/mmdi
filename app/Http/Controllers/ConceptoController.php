<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use mmdi\Proyecto;
use mmdi\Concepto;
use mmdi\Cotizacione;

class ConceptoController extends Controller
{

	/**
	* GET
	* /proyecto/agrega
	* Display the form to add a new proyecto
	*/
	public function concepto(Request $request,$id= '-1',$idProy='-1')
	    #, $tipoMensaje='', $mensaje='')
	    {
	    $concepto = Concepto::find($id);
	    if($idProy == -1){
	        $proyecto = Proyecto::find($concepto->proyecto_id);
	    }
	    else{
	        $proyecto = Proyecto::find($idProy);
	    }


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
            $concepto->costo = Concepto::getCosto($concepto);
            $concepto->precioCliente = $concepto->getprecio($concepto);
            $concepto->ganancia = Concepto::getGananciaReal($concepto);
            $concepto->precioTotal = $concepto->precioCliente * $concepto->cantidad;
            $concepto->gananciaTotal = $concepto->ganancia * $concepto->cantidad ;
            $concepto->costoTotal = $concepto->costo * $concepto->cantidad ;
        }
        else{
            $concepto = new Concepto;
            $concepto->id = -1;
            $concepto->fecha = date("Y-m-d");
            $proyectoSelected = $idProy;
            $concepto->adicional = $proyecto->distribuido;
        }

        return view('concepto.concepto')->
        with(['concepto' => $concepto,'elementos' => $elementos, 'proyectosForDropdown' => $proyectosForDropdown,'proyectoSelected'=>$proyectoSelected,'estatusForDropdown' => $estatusForDropdown,'estatusSelected'=>$estatusSelected,'proyectoCon'=>$proyecto]);
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
        ##$concepto->estatus = $request->input('estatus');
        $concepto->estatus = "Sin Estatus";
        if ($request->input('adicional')) {
            $concepto->adicional = 1;
        } else{
            $concepto->adicional = 0;
        }
        $concepto->proyecto_id = $request->input('proyecto_id');

        $concepto->save();

		# Redirect the user to the page to view the book
		return redirect('/concepto/'.$concepto->id.'/'.$concepto->proyecto_id)->with('success', 'El concepto '.$concepto->nombre.' fue '.$res);
	}


    public function eliminar(Request $request,$idCon='-1') {

	    $concepto = Concepto::find($idCon);

        $nombreLike = "%(".$concepto->proyecto_id.":".$concepto->id.":%";

	    if (!$concepto) {
            return redirect('/proyecto')->with('alert', 'concepto no encontrado');
        }

	    $concepto->elementos()->detach();

	    $proyecto_id = $concepto->proyecto_id;
	    $concepto->delete();


	    $cotizaciones = Cotizacione::where('nombre', 'LIKE', $nombreLike )->get();
	    foreach ($cotizaciones as $cotizacione) {
            $cotizacione->delete();
        }

	    return redirect('/proyecto/'.$proyecto_id)->with('success','El concepto '.$concepto->nombre.' se elimino.');
	    #return view('layouts.prueba');
	}

}
