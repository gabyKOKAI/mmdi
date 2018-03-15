<?php

namespace mmdi\Http\Controllers;

use Illuminate\Http\Request;
use mmdi\Movimiento;
use mmdi\Cuenta;
use mmdi\Recurso;
use mmdi\Proyecto;

class MovimientoController extends Controller
{
      public function lista($idRec= '-1',$idCue= '-1')
    {
        if($idRec != -1){
		    $movimientos = Movimiento::where('recurso_id', 'LIKE', $idRec)->paginate(15);
		    $recurso = Recurso::find($idRec);
		    $cuenta = new Cuenta;
		    $cuenta->id = -1;
		}
		elseif($idCue != -1){
		    $movimientos = Movimiento::where('cuenta_id', 'LIKE', $idCue)->paginate(15);
		    $cuenta = Cuenta::find($idCue);
		    $recurso = new Recurso;
		    $recurso->id = -1;
		}
		else{
		     $movimientos = Movimiento::paginate(15);
		     $recurso = new Recurso;
		     $recurso->id = -1;
		     $cuenta = new Cuenta;
		     $cuenta->id = -1;
		}

		return view('movimiento.movimientoLista')->with(['movimientos' => $movimientos, 'recurso' => $recurso,'cuenta' => $cuenta]);
    }

    public function movimiento(Request $request,$id= '-1',$idRec='-1',$idCue= '-1') {
	    $movimiento = Movimiento::find($id);

        $recursosForDropdown = Recurso::all();
        $cuentasForDropdown = Cuenta::all();
        $tiposForDropdown = Movimiento::getTiposDropDown();

        $tipoSelected = "Salida";
        $recursoSelected = -1;
        $cuentaSelected = -1;
        if($movimiento){
            $tipoSelected = $elemento->tipo;
            $recursoSelected = $movimiento->recurso_id;
            $cuentaSelected = $movimiento->cuenta_id;
        }
        else{
            $movimiento = new Movimiento;
            $movimiento->id = -1;
            $recursoSelected = $idRec;
            $cuentaSelected = $idCue;
        }

        return view('movimiento.movimiento')->
        with(['movimiento' => $movimiento, 'tiposForDropdown' => $tiposForDropdown,'tipoSelected'=>$tipoSelected, 'recursosForDropdown' => $recursosForDropdown,'recursoSelected'=>$recursoSelected, 'cuentasForDropdown' => $cuentasForDropdown,'cuentaSelected'=>$cuentaSelected]);
	}

	public function guardar(Request $request,$id,$idRec='-1',$idCue= '-1') {
		# Validate the request data
		$this->validate($request, [
			'descripcion' => 'required|min:3'
		]);

		$movimiento = Movimiento::find($id);

            if (!$movimiento) {
                # Instantiate a new Concepto Model object
                $movimiento = new Movimiento();
                $res = "agregado";
             } else {
                $res = "actualizado";
            }

        $recurso = Recurso::find($request->input('recurso'));
        $cuenta = Cuenta::find($request->input('cuenta'));

        if($request->input('tipo')== "Salida"){
            $saldoRecurso = $recurso->distribuido - $recurso->saldo_gasto - $request->input('monto');
            $saldoCuenta = $cuenta->saldo - $request->input('monto');
        } else{
            $saldoRecurso = $recurso->distribuido - $recurso->saldo_gasto + $request->input('monto');
            $saldoCuenta = $cuenta->saldo + $request->input('monto');
        }

        $mensaje = "";
        if($saldoRecurso<0){
		    $tipoMensaje = "error";
		    $mensaje = $mensaje + 'El movimiento no puede hacerse porque el recurso '.$recurso->nombre.' no tiene saldo suficiente.';
        }
        if($saldoCuenta<0){
		    $tipoMensaje = "error";
		    $mensaje = $mensaje + 'El movimiento no puede hacerse porque la cuenta '.$cuenta->nombre.' no tiene fondos suficiente.';
		    }
        if($mensaje == ""){
            Movimiento::registraMovimiento($request->input('fecha'), $request->input('monto'), $request->input('descripcion'), $request->input('tipo'), $request->input('recurso'),$request->input('cuenta'));

            if($request->input('tipo')== "Salida"){
                $recurso->saldo_gasto = $recurso->saldo_gasto + $request->input('monto');
                $cuenta->saldo = $cuenta->saldo - $request->input('monto');
            }else{
                $recurso->saldo_gasto = $recurso->saldo_gasto - $request->input('monto');
                $cuenta->saldo = $cuenta->saldo + $request->input('monto');
            }

            $recurso->save();
            $cuenta->save();

            $tipoMensaje = 'success';
            $mensaje = 'El movimiento fue '.$res.' y se actualizaron el gasto del recurso '.$recurso->nombre.' y los fondos de la cuenta '.$cuenta->nombre;
        }
        # Redirect the user to the page to view the book
		return redirect('/movimiento/'.$movimiento->id)->with($tipoMensaje, $mensaje);
	}

	    public function actualizaDistribuido($id, $distribuido){
        $proyecto = Proyecto::find($id);
        $proyecto->distribuido = $distribuido;
        $proyecto->save();
    }

    public function distribuir($id) {
        $distribuido = 1;

        $proyecto = Proyecto::find($id);
        $proyecto->calculoVariables($proyecto);

        $fecha = "2018-10-10";
        $cuenta = Cuenta::where('nombre', 'LIKE', "Proyectos")->first();

        if($proyecto->meg >= 0){
            $recurso1 = Recurso::where('nombre', 'LIKE', "MEG")->first();
            $recurso1->distribuido = $recurso1->distribuido + $proyecto->meg;
        }else{
            $distribuido = 0;
        }

        if($proyecto->ame >= 0){
            $recurso2 = Recurso::where('nombre', 'LIKE', "AME")->first();
            $recurso2->distribuido = $recurso2->distribuido + $proyecto->ame;
        }else{
            $distribuido = 0;
        }

        if($proyecto->mme >= 0){
            $recurso3 = Recurso::where('nombre', 'LIKE', "MME")->first();
            $recurso3->distribuido = $recurso3->distribuido + $proyecto->mme;
        }else{
            $distribuido = 0;
        }

        if($proyecto->amm >= 0){
            $recurso4 = Recurso::where('nombre', 'LIKE', "AMM")->first();
            $recurso4->distribuido = $recurso4->distribuido + $proyecto->amm;
        }else{
            $distribuido = 0;
        }

        $recurso5 = Recurso::where('nombre', 'LIKE', "MMDI")->first();
        $recurso5->distribuido = $recurso5->distribuido + $proyecto->recMmdi;

        if($distribuido == 1){
            $recurso1->save();
            Movimiento::registraMovimiento($fecha, $proyecto->meg, 'distribución de proyecto '.$proyecto->id.'-'.$proyecto->nombre, "Entrada",$recurso1->id,$cuenta->id);
            $recurso2->save();
            Movimiento::registraMovimiento($fecha, $proyecto->ame, 'distribución de proyecto '.$proyecto->id.'-'.$proyecto->nombre, "Entrada",$recurso2->id,$cuenta->id);
            $recurso3->save();
            Movimiento::registraMovimiento($fecha, $proyecto->mme, 'distribución de proyecto '.$proyecto->id.'-'.$proyecto->nombre, "Entrada",$recurso3->id,$cuenta->id);
            $recurso4->save();
            Movimiento::registraMovimiento($fecha, $proyecto->amm, 'distribución de proyecto '.$proyecto->id.'-'.$proyecto->nombre, "Entrada",$recurso4->id,$cuenta->id);
            $recurso5->save();
            Movimiento::registraMovimiento($fecha, $proyecto->recMmdi, 'distribución de proyecto '.$proyecto->id.'-'.$proyecto->nombre, "Entrada",$recurso5->id,$cuenta->id);
            $tipoMensaje = 'success';
            $mensaje = 'Se actualizaron todos los recursos y se marco el proyecto como distribuido';
            $this->actualizaDistribuido($id, $distribuido);
        }else{
            $tipoMensaje = 'error';
            $mensaje = 'El proceso no termino correctamente, favor de verificar';
        }

        # Redirect the user to the page to view the book
		return redirect('/proyecto/'.$proyecto->id)->with($tipoMensaje, $mensaje);
	}

	public function distribuirAdicionales($id) {
		$proyecto = Proyecto::find($id);

        $proyecto->adicionalesDistribuido = 1;
        $proyecto->save();

        $proyecto->calculoVariables($proyecto);

        $recurso = Recurso::where('nombre', 'LIKE', "MMDI")->first();
        $recurso->distribuido = $recurso->distribuido +  $proyecto->adicional;
        $recurso->save();

        $tipoMensaje = 'success';
        $mensaje = 'Se actualizaron todos los recursos y se marco el proyecto como distribuido';

        # Redirect the user to the page to view the book
		return redirect('/proyecto/'.$proyecto->id)->with($tipoMensaje, $mensaje);
	}

}
