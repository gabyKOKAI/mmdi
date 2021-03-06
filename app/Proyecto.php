<?php

namespace mmdi;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    public function cliente()
    {
        # Proyecto belongs to Cliente
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('mmdi\Cliente');
    }

    public function conceptos()
    {
        # Proyecto has many Conceptos
        # Define a one-to-many relationship.
        return $this->hasMany('mmdi\Concepto');
    }

    public function cotizaciones()
    {
        # Proyecto has many Cotizaciones
        # Define a one-to-many relationship.
        return $this->hasMany('mmdi\Cotizacione');
    }

    public function pagosClientes()
    {
        # Cliente has many Proyectos
        # Define a one-to-many relationship.
        return $this->hasMany('mmdi\PagoCliente');
    }

    public static function getEstatusDropDown()
    {
        $estatus = ['Prospecto', 'Cotizado', 'Aprobado', 'En Proceso (Carpeta)','En Proceso (Proyecto)','Por liquidar','Terminado'];
        //'Ganancias Distribuidas'
        return $estatus;
    }

    public static function getCosto($proyecto)
    {
        $costo = 0;
        foreach ($proyecto->conceptos as $concepto) {
            $costo = $costo + ($concepto->elementos->sum('pivot.precio')*$concepto->cantidad);
        }

        $costo = $costo + Proyecto::getHonorarios($proyecto->id,$proyecto->gasto_porc_honorarios,0);
        $costo = $costo + Proyecto::getHonorarios($proyecto->id,$proyecto->gasto_porc_honorarios,1);
        return $costo;
    }

    public static function getSaldo($proyecto)
    {
        $saldo = Proyecto::getCosto($proyecto) - Proyecto::getEfectivo($proyecto->id) -Proyecto::getTransferencias($proyecto->id) -Proyecto::getCheques($proyecto->id);
        return $saldo;
    }

    public static function getEfectivo($proyecto_id)
    {
        $efectivo = PagoCliente::where('proy_coti_id','=',$proyecto_id)->where('tipo','=','Efectivo')->where('con_iva','=',0)->where('estatus','<>','Cancelado')->sum('monto');
        $efectivoIVA = PagoCliente::where('proy_coti_id','=',$proyecto_id)->where('tipo','=','Efectivo')->where('con_iva','=',1)->where('estatus','<>','Cancelado')->sum('monto')/1.16;
        return $efectivo + $efectivoIVA;
    }

    public static function getTransferencias($proyecto_id)
    {
        $transferencias = PagoCliente::where('proy_coti_id','=',$proyecto_id)->where('tipo','=','Transferencia')->where('con_iva','=',0)->where('estatus','<>','Cancelado')->sum('monto');
        $transferenciasIVA = PagoCliente::where('proy_coti_id','=',$proyecto_id)->where('tipo','=','Transferencia')->where('con_iva','=',1)->where('estatus','<>','Cancelado')->sum('monto')/1.16;
        return $transferencias + $transferenciasIVA;
    }

    public static function getCheques($proyecto_id)
    {
        $cheques = PagoCliente::where('proy_coti_id','=',$proyecto_id)->where('tipo','=','Cheque')->where('con_iva','=',0)->where('estatus','<>','Cancelado')->sum('monto');
        $chequesIVA = PagoCliente::where('proy_coti_id','=',$proyecto_id)->where('tipo','=','Cheque')->where('con_iva','=',1)->where('estatus','<>','Cancelado')->sum('monto')/1.16;
        return $cheques + $chequesIVA;
    }

    public static function getIndirectos($proyecto_id)
    {
        $conceptos = Concepto::where('proyecto_id', 'LIKE', $proyecto_id)->where('adicional', '=', 0 )->get();

        $indirectos = 0;
        foreach ($conceptos as $concepto) {
            $ganancia = Concepto::getGananciaReal($concepto);
            $indirectos = $indirectos + ($ganancia*$concepto->cantidad);
        }
        return $indirectos;
    }

    public static function getCostoIndirectos($proyecto_id)
    {
        $conceptos = Concepto::where('proyecto_id', 'LIKE', $proyecto_id)->where('adicional', '=', 0 )->get();

        $costo = 0;
        foreach ($conceptos as $concepto) {
            $costoCon = Concepto::getCosto($concepto);
            $costo = $costo + ($costoCon*$concepto->cantidad);
        }
        return $costo;
    }

    public static function getHonorarios($proyecto_id,$gasto_porc_honorarios,$tipo)
    {
        $honorarios = Proyecto::getCostoIA($proyecto_id,$tipo)*$gasto_porc_honorarios/100;
        return $honorarios;
    }


    public static function getConceptos($proyecto_id, $adicionales)
    {
        if($adicionales == -1){
            $conceptos = Concepto::where('proyecto_id', 'LIKE', $proyecto_id)->get();
        }
        else{
            $conceptos = Concepto::where('proyecto_id', 'LIKE', $proyecto_id)->where('adicional', '=', $adicionales)->get();
        }
       //->paginate(5);

        $num = 1;

        foreach ($conceptos as $concepto) {
            $concepto->costo = Concepto::getCosto($concepto);
            $concepto->ganancia = Concepto::getGananciaReal($concepto);
            $concepto->precio = Concepto::getPrecio($concepto);
            $concepto->costoTotal = $concepto->costo * $concepto->cantidad ;
            $concepto->gananciaTotal = $concepto->ganancia * $concepto->cantidad ;
            $concepto->precioTotal = $concepto->precio * $concepto->cantidad;
            $concepto->num = $num;
            $num = $num + 1;
        }
        return $conceptos;
    }

    public static function getCostoIA($proyecto_id, $tipo)
    {
        $conceptos = Concepto::where('proyecto_id', 'LIKE', $proyecto_id)->where('adicional', '=', $tipo )->get();

        $total = 0;
        foreach ($conceptos as $concepto) {
            $precio = Concepto::getPrecio($concepto);
            $total = $total + ($precio*$concepto->cantidad);
        }
        return $total;
    }

    public static function calculoVariables($proyecto)
    {
        $proyecto->inicial = $proyecto->getCostoIA($proyecto->id,0);
        $proyecto->adicional = $proyecto->getCostoIA($proyecto->id,1);
        $proyecto->honorarios = $proyecto->getHonorarios($proyecto->id,$proyecto->gasto_porc_honorarios,0);
        $proyecto->honorariosAdicional = $proyecto->getHonorarios($proyecto->id,$proyecto->gasto_porc_honorarios,1);
        $proyecto->costo =  $proyecto->inicial + $proyecto->honorarios;
        $proyecto->totAdicionales =  $proyecto->getCosto($proyecto);
        $proyecto->efectivo = $proyecto->getEfectivo($proyecto->id);
        $proyecto->transferencias = $proyecto->getTransferencias($proyecto->id);
        $proyecto->cheques = $proyecto->getCheques($proyecto->id);
        $proyecto->saldo = $proyecto->getSaldo($proyecto);
        $proyecto->indirectos = $proyecto->getIndirectos($proyecto->id);
        $proyecto->utilidades = $proyecto->indirectos + $proyecto->honorarios;
        $proyecto->mmdi = $proyecto->utilidades * $proyecto->gasto_porc_ganancias_MMDI / 100;
        $proyecto->errores = $proyecto->utilidades * $proyecto->gasto_porc_errores / 100;
        $proyecto->ddg = $proyecto->utilidades - $proyecto->mmdi -$proyecto->gasto_viaticos -$proyecto->gasto_IMSS -$proyecto->errores;
        $proyecto->recMmdi = $proyecto->mmdi + $proyecto->errores + $proyecto->gasto_viaticos +$proyecto->gasto_IMSS + $proyecto->getCostoIndirectos($proyecto->id);
        $proyecto->meg = $proyecto->ddg * $proyecto->ganancia_MEG / 100;
        $proyecto->amm = $proyecto->ddg * $proyecto->ganancia_AMM / 100;
        $proyecto->mme = $proyecto->ddg * $proyecto->ganancia_MME / 100;
        $proyecto->ame = $proyecto->ddg * $proyecto->ganancia_AME / 100;
    }

    public static function getProyectos()
    {
        $proyectos = Proyecto::query();
        $queries = [];

        $columnas = ['nombre', 'cliente_id','estatus', 'saldo'];
        $columnasCk = ['distribuido', 'adicionalesDistribuido'];

        foreach($columnas as $columna){

            if(request()->has($columna) and request($columna)!= 'all' and request($columna)!= ''){
                $proyectos = $proyectos->where($columna,'LIKE','%'.request($columna).'%');
                $queries[$columna] = request($columna);
            }
        }

        foreach($columnasCk as $columna){

            if(request()->has($columna) and request()->has('no'.$columna)){
                $queries[$columna] = request($columna);
                $queries['no'.$columna] = request('no'.$columna);
            }
            elseif(request()->has($columna)){
                $proyectos = $proyectos->where($columna,'LIKE','%'.request($columna).'%');
                $queries[$columna] = request($columna);
            }
            elseif(request()->has('no'.$columna)){
                $proyectos = $proyectos->where($columna,0);
                $queries['no'.$columna] = request('no'.$columna);
            }
        }

        /*
        $saldoMayorA = -1000000000000;
        $saldoMenorA = 1000000000000;
        if(request()->has('saldoMayorA')){
            $saldoMayorA = request('saldoMayorA');
            $queries['saldoMayorA'] = request('saldoMayorA');
        }
        if(request()->has('saldoMenorA')){
            $saldoMenorA = request('saldoMenorA');
            $queries['saldoMenorA'] = request('saldoMenorA');
        }
        */

		if(request()->has('sort'))
		{
            $proyectos = $proyectos->orderBy('nombre',request('sort'));
            $queries['sort'] = request('sort');
		}

		$proyectos = $proyectos->paginate(15,['*'], 'proyectos_p')->appends($queries);

        if (!$proyectos->isEmpty()) {
            foreach ($proyectos as $proyecto) {
                $proyecto->costo = Proyecto::getCosto($proyecto);
                $proyecto->saldo = Proyecto::getSaldo($proyecto);
            }
        }

        /*if(request()->has('saldoMayorA') or request()->has('saldoMenorA')){
            $proyectos = $proyectos->where('saldo', '>=', $saldoMayorA);
            $proyectos = $proyectos->where('saldo', '<=', $saldoMenorA);
        }*/


        return $proyectos ;
    }
}