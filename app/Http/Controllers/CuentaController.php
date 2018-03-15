<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use mmdi\Cuenta;

class CuentaController extends Controller
{
    public function lista()
    {
		$cuentas = Cuenta::where('saldo', '<>', -1)->paginate(15);

		return view('cuenta.cuentaLista')->with(['cuentas' => $cuentas]);
    }
}
