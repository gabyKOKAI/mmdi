<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use mmdi\Proveedore;

class ProveedoreController extends Controller
{
    public function lista()
    {
         $proveedores = Proveedore::paginate(15);

		return view('proveedore.proveedoreLista')->with(['proveedores' => $proveedores]);
    }
}
