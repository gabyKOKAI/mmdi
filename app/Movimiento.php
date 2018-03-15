<?php

namespace mmdi;

use Illuminate\Database\Eloquent\Model;
use mmdi\Movimiento;

class Movimiento extends Model
{
    public function recurso()
    {
        # Proyecto belongs to Cliente
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('mmdi\Recurso');
    }

    public function cuenta()
    {
        # Proyecto belongs to Cliente
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('mmdi\Cuenta');
    }

    public static function getTiposDropDown()
    {
        $tipos = ['Entrada', 'Salida'];
        return $tipos;
    }

     public static function registraMovimiento($fecha,$monto,$descripcion,$tipo,$recurso,$cuenta){
        $res = 0;

        $movimiento = new Movimiento();
        # Set the parameters
        $movimiento->fecha =$fecha;
        $movimiento->monto =$monto;
        $movimiento->descripcion =  $descripcion;
        $movimiento->tipo =  $tipo;
        $movimiento->recurso_id = $recurso;
        $movimiento->cuenta_id = $cuenta;
        $movimiento->save();

        $res = 1;
        return $res;
    }
}
