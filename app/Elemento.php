<?php

namespace mmdi;

use Illuminate\Database\Eloquent\Model;

class Elemento extends Model
{
    public function conceptos()
    {
        # With timetsamps() will ensure the pivot table has its created_at/updated_at fields automatically maintained
        return $this->belongsToMany('mmdi\Concepto')->withTimestamps()->withPivot('precio');
    }

     public function proveedor()
    {
        # Elemento belongs to Proveedor
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('mmdi\Proveedore');
    }

    public static function getTiposDropDown()
    {
        $tipos = ['Material', 'Mano de Obra', 'Mueble', 'Viaticos','Otro'];
        return $tipos;
    }

    public static function getTiposGananciasDropDown()
    {
        //$tipos = ['% Comision','$ Comision Fija','% MarkUp','$ MarkUp Fijo'];
        $tipos = ['%','$'];
        return $tipos;
    }

    public static function getPrecio($elemento)
    {
        if($elemento->tipo_ganancia == "%"){
            $precio = $elemento->costo + ($elemento->costo*$elemento->ganancia/100);
        }
        if($elemento->tipo_ganancia == "$"){
            $precio = $elemento->costo + $elemento->ganancia;
        }
        return $precio;
    }

    public static function getElementos()
    {
        $elementos = Elemento::paginate(15);

        foreach ($elementos as $elemento) {
            $elemento->precio = Elemento::getPrecio($elemento);
        }

        return $elementos ;
    }
}
