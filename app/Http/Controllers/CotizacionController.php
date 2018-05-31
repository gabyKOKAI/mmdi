<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use mmdi\Cotizacione;
use mmdi\Proveedore;
use mmdi\Proyecto;
use mmdi\PagoProveedore;
use mmdi\Cliente;
use mmdi\Concepto;
use mmdi\Elemento;

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
			'nombre' => 'required|min:3',
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
		#return view('layouts.prueba');
		return redirect('/cotizacion/'.$cotizacione->id)->with('success', 'La CXP '.$cotizacione->descripcion.' fue '.$res);
	}

	public function creaCotizacion(Request $request,$idCon='-1', $idEle='-1', $idProy='-1') {
	    if($idProy==-1){
            $elemento = Elemento::find($idEle);
            $concepto = Concepto::find($idCon);

            $subConcepto = $concepto->getElementos($concepto)->find($idEle);

            $proyecto = Proyecto::find($concepto->proyecto_id);

            # Get proyectos
            $proyectosForDropdown = Proyecto::all();
            # Get estatus
            $estatusForDropdown = Concepto::getEstatusDropDown();
            $elementos = [];
            $proyectoSelected = $concepto->proyecto_id;
            $estatusSelected = $concepto->estatus;
            $elementos = Concepto::getElementos($concepto);
            $concepto->costo = Concepto::getCosto($concepto);
            $concepto->precioCliente = $concepto->getprecio($concepto);
            $concepto->ganancia = Concepto::getGananciaReal($concepto);
            $concepto->precioTotal = $concepto->precioCliente * $concepto->cantidad;
            $concepto->gananciaTotal = $concepto->ganancia * $concepto->cantidad ;
            $concepto->costoTotal = $concepto->costo * $concepto->cantidad ;

            $nombre = "(".$concepto->proyecto_id.":".$concepto->id.":".$subConcepto->id.") ".$concepto->nombre."-".$subConcepto->nombre."(".$subConcepto->tipo.")";
            $nombreLike = "%(".$concepto->proyecto_id.":".$concepto->id.":".$subConcepto->id.") %";
            $descripcion = "CXP creada automaticamente desde el concepto ".$concepto->nombre.", para el subconcepto ".$subConcepto->nombre.".";
            $monto = $subConcepto->costoCliente * $concepto->cantidad;
            $idProyCot = $concepto->proyecto_id;
            $idProvCot = $subConcepto->proveedor_id;
        }
        else{
            $proyecto = Proyecto::find($idProy);
            $nombre = "(".$proyecto->id.":viaticos:viaticos) ".$proyecto->nombre."(viaticos)";
            $nombreLike = "%(".$proyecto->id.":viaticos:viaticos) %";
            $descripcion = "CXP de viaticos creada automaticamente desde el proyecto ".$proyecto->nombre;
            $monto = $proyecto->gasto_viaticos;
            $idProyCot = $idProy;
            $proveedore = Proveedore::where('nombre', 'LIKE', '%iaticos%' )->first();
            $idProvCot = $proveedore->id;
        }
        $cotizacione = Cotizacione::where('nombre', 'LIKE', $nombreLike )->first();

        if(!$cotizacione){

            $cotizacione = new Cotizacione();
            $res = "creada";
        }else{
            $res = "actualizada";
        }

        # Set the parameters
        $cotizacione->nombre = $nombre;
        $cotizacione->descripcion = $descripcion;
        $cotizacione->estatus = "Cotizado";
        $cotizacione->monto = $monto;
        $cotizacione->con_iva = 0;
        $cotizacione->proyecto_id = $idProyCot;
        $cotizacione->proveedor_id = $idProvCot;
        $cotizacione->save();

        $tipoMensaje = 'success';
        $mensaje = 'La CXP fue '.$res.' con exito.';

        #return redirect('/concepto/'.$concepto->id.'/'.$concepto->proyecto_id.'/'.$tipoMensaje.'/'.$mensaje)->with($tipoMensaje, $mensaje);
        #return view('layouts.prueba');
        if($idProy==-1){
            return view('concepto.concepto')->
            with(['concepto' => $concepto,'elementos' => $elementos, 'proyectosForDropdown' => $proyectosForDropdown,'proyectoSelected'=>$proyectoSelected,'estatusForDropdown' => $estatusForDropdown,'estatusSelected'=>$estatusSelected,'proyectoCon'=>$proyecto,'mensaje'=>$mensaje,'tipoMensaje'=>$tipoMensaje]);
        }
        else{
            return redirect('/proyecto/'.$idProy)->with($tipoMensaje, $mensaje);
        }
    }

}
