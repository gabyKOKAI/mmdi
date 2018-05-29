<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use mmdi\Elemento;
use mmdi\Concepto;
use mmdi\Proveedore;

class ConceptoElementoController extends Controller
{

	/**
	* GET
	* /proyecto/agrega
	* Display the form to add a new proyecto
	*/
	public function conceptoElemento(Request $request,$idCon='-1',$idEle='-1',$edit='1') {
	    $concepto = Concepto::find($idCon);

	    $elemento="";
	    $precio="";
	    if($idEle!='-1'){
	        $elemento = $concepto->getElementos($concepto)->find($idEle);
	        $precio = $elemento->precioCliente;
	        $infoElemento = Elemento::getCostoGanancia($elemento);
	    }
	    else{
	       $elemento = new Elemento;
           $elemento->id = -1;
           $infoElemento = "";
	    }


	    # Get elementos
	    $elementosForDropdown= Elemento::all();
        $elementoSelected = $idEle;

        # Get elementos
	    $proveedoresForDropdown= Proveedore::all();
	    $tiposForDropdown= Elemento::getTiposDropDown();

        return view('conceptoElemento.conceptoElemento')->
        with(['concepto' => $concepto,'elemento' => $elemento,'precio' => $precio, 'elementosForDropdown' => $elementosForDropdown,'elementoSelected'=>$elementoSelected,'edit'=>$edit, 'proveedoresForDropdown' => $proveedoresForDropdown, 'tiposForDropdown' => $tiposForDropdown, 'infoElemento'=>$infoElemento]);
	}


	/**
	* POST
	* /proyecto
	* Process the form for adding a new book
	*/
	public function guardar(Request $request,$idCon='-1',$idEle='-1',$edit='1') {
		# Validate the request data
		$this->validate($request, [
			'precio' => 'required',
		]);

        $concepto = Concepto::find($idCon);
        $elemento = Elemento::find($request->input('elemento1'));
        ##dump($elemento);
        ##dump($concepto->getElementos($concepto)->find($request->input('elemento')));
        if($concepto->getElementos($concepto)->find($request->input('elemento'))){
            $res = "actualizado";
            $concepto->elementos()->sync([ $elemento->id => ['concepto_id'=>$concepto->id,'precio' => $request->input('precio'),'elemento_id'=>$elemento->id]],
                                        false);
        }
        else{
            $res = "agregado";
            # Set the parameters
            $concepto->elementos()->sync([ $elemento->id => ['concepto_id'=>$concepto->id,'precio' => $request->input('precio'),'costo' => $elemento->costo,'elemento_id'=>$elemento->id]],
                                        false);
        }



		# Redirect the user to the page to view the book
		return redirect('/concepto/'.$concepto->id)->with('success', 'El elemento '.$elemento->nombre.' fue '.$res.' para el concepto '.$concepto->nombre);
		#return view('layouts.prueba');
	}

	public function eliminar(Request $request,$idCon='-1',$idEle='-1') {
	    $concepto = Concepto::find($idCon);
	    $elemento = Elemento::find($idEle);
	    $concepto->elementos()->detach($idEle);
	    return redirect('/concepto/'.$concepto->id)->with('success', 'El elemento '.$elemento->nombre.' fue eliminado del concepto '.$concepto->nombre);
	}
}
