<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use App;

class ProyectoController extends Controller
{
     /**
    * GET /proyectos
    */
    public function lista()
    { 
		##return App::environment(); 
        ##return 'Here are all the proyectos...';
		##return view('proyecto.lista')->with(['title' => $title]);
		return view('proyecto.lista');
    }

     /**
    * GET /proyectos
    */
    public function search(Request $request) {

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
    return view('proyecto.search')->with([
        'searchTerm' => $searchTerm,
        'caseSensitive' => $request->has('caseSensitive'),
        'searchResults' => $searchResults
    ]);
	}

	/**
	* GET
	* /proyecto/agrega
	* Display the form to add a new book
	*/
	public function agrega(Request $request) {
		return view('proyecto.agrega');
	}


	/**
	* POST
	* /proyecto
	* Process the form for adding a new book
	*/
	public function guarda(Request $request) {
		# Validate the request data
		$this->validate($request, [
			'nombre' => 'required|min:3',
		]);
		
		$nombre = $request->input('nombre');

		#
		#
		# [...Code will eventually go here to actually save this book to a database...]
		#
		#

		# Redirect the user to the page to view the book
		##return redirect('/proyecto/'.$title);
		return redirect('/proyectos');
	}	
}
