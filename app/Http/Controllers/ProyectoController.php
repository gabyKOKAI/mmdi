<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use App;
use mmdi\Proyecto;
use mmdi\Cliente;
use mmdi\Concepto;

class ProyectoController extends Controller
{
     /**
    * GET /proyectos
    */
    public function lista()
    { 
		##return App::environment();

		$proyectos = Proyecto::with('cliente','conceptos')->get();
		$proyectos = Proyecto::paginate(10 );

        if ($proyectos->isEmpty()) {
            dump('No matches found');
        } else {
            foreach ($proyectos as $proyecto) {
                ##dump($proyecto->nombre.$proyecto->cliente->nombre);
                $proyecto->costo = Proyecto::getCosto($proyecto);
                $proyecto->saldo = Proyecto::getSaldo($proyecto);
                #foreach ($proyecto->conceptos as $concepto) {
                    #dump($concepto->elementos->sum('pivot.precio'));
                    #foreach ($concepto->elementos as $elemento) {
                    #    dump($elemento->pivot);
                    #}
                #}
            }
        }

		return view('proyecto.proyectoLista')->with(['proyectos' => $proyectos]);
    }

     /**
    * GET /proyectos
    */
    public function busca(Request $request) {

    # ======== Temporary code to explore $request ==========

    # See all the properties and methods available in the $request object
    ##dump($request);

    # See just the form data from the $request object
    ##dump($request->all());

    # See just the form data for a specific input, in this case a text input
    ##dump($request->input('searchTerm'));

    # See what the form data looks like for a checkbox
    ##dump($request->input('caseSensitive'));

    # Boolean to see if the request contains data for a particular field
    ##dump($request->has('searchTerm')); # Should be true
    ##dump($request->has('publishedYear')); # There's no publishedYear input, so this should be false

    # You can get more information about a request than just the data of the form, for example...
    ##dump($request->fullUrl());
    ##dump($request->method());
    ##dump($request->isMethod('post'));

    # ======== End exploration of $request ==========

	 # Start with an empty array of search results; books that
    # match our search query will get added to this array
    $searchResults = [];
    
    # Store the searchTerm in a variable for easy access
    # The second parameter (null) is what the variable
    # will be set to *if* searchTerm is not in the request.
    $searchTerm = $request->input('searchTerm', null);
    
    # Only try and search *if* there's a searchTerm
    if ($searchTerm) {
        # Open the books.json data file
        # database_path() is a Laravel helper to get the path to the database folder
        # See https://laravel.com/docs/helpers for other path related helpers
        $proyectosRawData = file_get_contents(database_path('/proyectos.json'));
        
        # Decode the book JSON data into an array
        # Nothing fancy here; just a built in PHP method
        $proyectos = json_decode($proyectosRawData, true);
        
        # Loop through all the book data, looking for matches
        # This code was taken from v0 of foobooks we built earlier in the semester
        foreach ($proyectos as $title => $proyecto) {
            # Case sensitive boolean check for a match
            if ($request->has('caseSensitive')) {
                $match = $title == $searchTerm;
            # Case insensitive boolean check for a match
            } else {
                $match = strtolower($title) == strtolower($searchTerm);
            }
            
            # If it was a match, add it to our results
            if ($match) {
                $searchResults[$title] = $proyecto;
            }
        }
    }
	
    # Return the view with some placeholder data we'll flesh out in a later step
    return view('proyecto.proyectoBusca')->with([
        'searchTerm' => $searchTerm,
        'caseSensitive' => $request->has('caseSensitive'),
        'searchResults' => $searchResults
    ]);
	}

	/**
	* GET
	* /proyecto/agrega
	* Display the form to add a new proyecto
	*/
	public function proyecto(Request $request,$id= '-1') {
	    $proyecto = Proyecto::find($id);

	    # Get clientes
        $clientesForDropdown = Cliente::all();
        # Get estatus
        $estatusForDropdown = Proyecto::getEstatusDropDown();
        # Get conceptos
        $conceptos = [];


        $clienteSelected = "";
        $estatusSelected = "";
        if($proyecto){
            #$conceptos = $proyecto->conceptos();
            $clienteSelected = $proyecto->cliente_id;
            $estatusSelected = $proyecto->estatus;

            $proyecto->inicial = $proyecto->getCostoIA($proyecto->id,0);
            $proyecto->adicional = $proyecto->getCostoIA($proyecto->id,1);
            $proyecto->honorarios = $proyecto->getHonorarios($proyecto->id,$proyecto->gasto_porc_honorarios);
            $proyecto->costo = $proyecto->getCosto($proyecto);
            $proyecto->efectivo = $proyecto->getEfectivo($proyecto->id);
            $proyecto->transferencias = $proyecto->getTransferencias($proyecto->id);
            $proyecto->cheques = $proyecto->getCheques($proyecto->id);
            $proyecto->saldo = $proyecto->getSaldo($proyecto);
            $proyecto->indirectos = $proyecto->getIndirectos($proyecto->id);
            $proyecto->utilidades = $proyecto->indirectos + $proyecto->honorarios;
            $proyecto->mmdi = $proyecto->utilidades * $proyecto->gasto_porc_ganancias_MMDI / 100;
            $proyecto->errores = $proyecto->utilidades * $proyecto->gasto_porc_errores / 100;
            $proyecto->ddg = $proyecto->utilidades - $proyecto->mmdi -$proyecto->gasto_viaticos -$proyecto->gasto_IMSS -$proyecto->errores;
            $proyecto->meg = $proyecto->ddg * $proyecto->ganancia_MEG / 100;
            $proyecto->amm = $proyecto->ddg * $proyecto->ganancia_AMM / 100;
            $proyecto->mme = $proyecto->ddg * $proyecto->ganancia_MME / 100;
            $proyecto->ame = $proyecto->ddg * $proyecto->ganancia_AME / 100;
            $conceptos = Proyecto::getConceptos($proyecto->id);
        }
        else{
            $proyecto = new Proyecto;
            $proyecto->id = -1;
        }

        return view('proyecto.proyecto')->
        with(['proyecto' => $proyecto,'conceptos' => $conceptos, 'clientesForDropdown' => $clientesForDropdown,'clienteSelected'=>$clienteSelected,'estatusForDropdown' => $estatusForDropdown,'estatusSelected'=>$estatusSelected]);
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
		]);

        # First get a proyecto to update
        #$proyecto = Proyecto::where('nombre', 'LIKE', $nombre)->first();
        $proyecto = Proyecto::find($id);


        if (!$proyecto) {
            # Instantiate a new Proyecto Model object
            $proyecto = new Proyecto();
            $res = "Creado";
         } else {
            $res = "Actualizado";
        }

        # Set the parameters
        $proyecto->nombre = $request->input('nombre');
        $proyecto->descripcion = $request->input('descripcion');
        $proyecto->direccion = $request->input('direccion');
        $proyecto->comentario =  $request->input('comentario');
        $proyecto->gasto_viaticos =  $request->input('gasto_viaticos');
        $proyecto->gasto_IMSS =  $request->input('gasto_IMSS');

        $proyecto->gasto_porc_honorarios =  $request->input('gasto_porc_honorarios');
        $proyecto->gasto_porc_ganancias_MMDI =  $request->input('gasto_porc_ganancias_MMDI');
        $proyecto->gasto_porc_errores =  $request->input('gasto_porc_errores');
        $proyecto->ganancia_MEG =  $request->input('ganancia_MEG');
        $proyecto->ganancia_AMM =  $request->input('ganancia_AMM');
        $proyecto->ganancia_MME =  $request->input('ganancia_MME');
        $proyecto->ganancia_AME =  $request->input('ganancia_AME');

        $proyecto->estatus = $request->input('estatus');

        $cliente = Cliente::find($request->input('cliente_id'));
        $proyecto->cliente()->associate($cliente); # <--- Associate cliente with this proyecto


        # Invoke the Eloquent `save` method to generate a new row in the
        # `proyecto` table, with the above data
        $proyecto->save();

		# Redirect the user to the page to view the book
		return redirect('/proyecto/'.$proyecto->id)->with('success', 'El proyecto '.$proyecto->nombre.' fue '.$res);
	}

}
