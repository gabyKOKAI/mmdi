<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use mmdi\Cotizacione;
use mmdi\Proveedore;
use mmdi\Proyecto;
use mmdi\PagoProveedore;
use mmdi\Cliente;

class CotizacionController extends Controller
{
    public function lista()
    {

		$cotizaciones = Cotizacione::paginate(15);

		if (!$cotizaciones->isEmpty()) {
            foreach ($cotizaciones as $cotizacione) {
                $cotizacione->saldo = Cotizacione::getSaldo($cotizacione);
            }
        }

		$proyecto = new Proyecto;
        $proyecto->id = -2;
        $cotizacione = new Cotizacione;
        $cotizacione->id = -2;

		return view('cotizacion.cotizacionLista')->with(['cotizaciones' => $cotizaciones,'proyecto' => $proyecto,'cotizacione' => $cotizacione]);
    }

    public function cotizacion(Request $request,$id= '-1',$idProy='-1') {
	    $cotizacione = Cotizacione::find($id);

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
        $pagos = PagoProveedore::where('cli_prov_id','=',-1)->paginate(5);
        if($cotizacione){
            $proyectoSelected = $cotizacione->proyecto_id;
            $proveedorSelected = $cotizacione->proveedor_id;
            $estatusSelected = $cotizacione->estatus;
            $cotizacione->calculoVariables($cotizacione);
            $pagos = PagoProveedore::where('cli_prov_id','=',$cotizacione->proveedore_id)->paginate(5);
        }
        else{
            $cotizacione = new Cotizacione;
            $cotizacione->id = -1;
            $proyectoSelected = $idProy;
        }

        $cliente = new Cliente;
        $cliente->id = -1;

        $proveedore = new Proveedore;
        $proveedore->id = -1;

        $proyecto = new Proyecto;
        $proyecto->id = -1;

        if($proveedorSelected != -1){
           $proveedore = Proveedore::find($proveedorSelected);

            $pagos = PagoProveedore::where('proy_coti_id','=',$cotizacione->id)->paginate(5);
        }

        return view('cotizacion.cotizacion')->
        with([  'cotizacione' => $cotizacione,
                'proyectosForDropdown' => $proyectosForDropdown,'proyectoSelected'=>$proyectoSelected,
                'proveedoresForDropdown' => $proveedoresForDropdown,'proveedorSelected'=>$proveedorSelected,
                'estatusForDropdown' => $estatusForDropdown,'estatusSelected'=>$estatusSelected,
                'pagos'=>$pagos,
                'esCliente'=>0,
                'cliente' => $cliente, 'proyecto' => $proyecto,
                'proveedore'=>$proveedore,
                ]);
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

        $cotizacione = Cotizacione::find($id);

        if (!$cotizacione) {
            # Instantiate a new Cotizacione Model object
            $cotizacione = new Cotizacione();
            $res = "Creado";
         } else {
            $res = "Actualizado";
        }

        # Set the parameters
        $cotizacione->nombre = $request->input('nombre');
        $cotizacione->descripcion = $request->input('descripcion');
        $cotizacione->estatus = $request->input('estatus');
        $cotizacione->monto = $request->input('monto');
        if ($request->input('con_iva')) {
            $cotizacione->con_iva = 1;
        } else{
            $cotizacione->con_iva = 0;
        }
        if ( $request->input('proyecto_id') != "---"){
            $cotizacione->proyecto_id = $request->input('proyecto_id');
        }
        $cotizacione->proveedor_id = $request->input('proveedor_id');

        $cotizacione->save();

		# Redirect the user to the page to view the book
		return redirect('/cotizacion/'.$cotizacione->id)->with('success', 'La cotizacion '.$cotizacione->descripcion.' fue '.$res);
	}

}
