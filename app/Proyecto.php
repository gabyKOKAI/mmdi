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
        $costo =$costo + Proyecto::getHonorarios($proyecto->id,$proyecto->gasto_porc_honorarios);
        return $costo;
    }

    public static function getSaldo($proyecto)
    {
        $saldo = Proyecto::getCosto($proyecto) + Proyecto::getCostoIA($proyecto->id,1) - Proyecto::getEfectivo($proyecto->id) -Proyecto::getTransferencias($proyecto->id) -Proyecto::getCheques($proyecto->id);
        return $saldo;
    }

    public static function getEfectivo($proyecto_id)
    {
        $efectivo = 100;
        return $efectivo;
    }

    public static function getTransferencias($proyecto_id)
    {
        $transferencias = 150;
        return $transferencias;
    }

    public static function getCheques($proyecto_id)
    {
        $cheques = 200;
        return $cheques;
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

    public static function getHonorarios($proyecto_id,$gasto_porc_honorarios)
    {
        $honorarios = Proyecto::getCostoIA($proyecto_id,0)*$gasto_porc_honorarios/100;
        return $honorarios;
    }

    public static function getConceptos($proyecto_id)
    {
        $conceptos = Concepto::where('proyecto_id', 'LIKE', $proyecto_id)->paginate(5);

        foreach ($conceptos as $concepto) {
            $concepto->precio = Concepto::getPrecio($concepto);
            $concepto->total = $concepto->precio*$concepto->cantidad;
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
}