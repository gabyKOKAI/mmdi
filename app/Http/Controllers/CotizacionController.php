<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use mmdi\Cotizacione;
use mmdi\Proveedore;
use mmdi\Proyecto;

class CotizacionController extends Controller
{
    public function lista()
    {

		$cotizaciones = Cotizacione::paginate(15);

		return view('cotizacion.cotizacionLista')->with(['cotizaciones' => $cotizaciones]);
    }

    public function cotizacion(Request $request,$id= '-1') {
	    $cotizacion = Cotizacione::find($id);

	    # Get proveedores
        $proveedoresForDropdown = Proveedore::all();

        # Get proyectos
        $proyectosForDropdown = Proyecto::all();

        # Get estatus
        $estatusForDropdown = Cotizacione::getEstatusDropDown();
        $elementos = [];

        $proyectoSelected = -1;
        $proveedorSelected = -1;
         $estatusSelected = -1;
        if($cotizacion){
            $proyectoSelected = $cotizacion->proyecto_id;
            $proveedorSelected = $cotizacion->proveedor_id;
            $estatusSelected = $cotizacion->estatus;
        }
        else{
            $cotizacion = new Cotizacione;
            $cotizacion->id = -1;
        }

        return view('cotizacion.cotizacion')->
        with(['cotizacion' => $cotizacion, 'proyectosForDropdown' => $proyectosForDropdown,'proyectoSelected'=>$proyectoSelected,'proveedoresForDropdown' => $proveedoresForDropdown,'proveedorSelected'=>$proveedorSelected,'estatusForDropdown' => $estatusForDropdown,'estatusSelected'=>$estatusSelected]);
	}

    public function guardar(Request $request,$id) {
		# Validate the request data
		$this->validate($request, [
			'descripcion' => 'required|min:3',
			'proveedor_id' => 'required',
			'estatus' => 'required',
			'monto' => 'required',
			'con_iva' => 'boolean',
		]);

        $cotizacion = Cotizacione::find($id);

        if (!$cotizacion) {
            # Instantiate a new Cotizacione Model object
            $cotizacion = new Cotizacione();
            $res = "Creado";
         } else {
            $res = "Actualizado";
        }

        # Set the parameters
        $cotizacion->descripcion = $request->input('descripcion');
        $cotizacion->estatus = $request->input('estatus');
        $cotizacion->monto = $request->input('monto');
        if ($request->input('con_iva')) {
            $cotizacion->con_iva = 1;
        } else{
            $cotizacion->con_iva = 0;
        }
        if ( $request->input('proyecto_id') != "---"){
            $cotizacion->proyecto_id = $request->input('proyecto_id');
        }
        $cotizacion->proveedor_id = $request->input('proveedor_id');

        $cotizacion->save();

		# Redirect the user to the page to view the book
		return redirect('/cotizacion/'.$cotizacion->id)->with('success', 'La cotizacion '.$cotizacion->descripcion.' fue '.$res);
	}

}
