<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use mmdi\Recurso;

class RecursoController extends Controller
{
    public function lista()
    {
		$recursos = Recurso::paginate(15);

		return view('recurso.recursoLista')->with(['recursos' => $recursos]);
    }
}
