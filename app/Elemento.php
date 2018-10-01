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
        $tipos = ['Material', 'Mano de Obra', 'Material & Mano de Obra', 'Mueble', 'Viaticos','Otro'];
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

    public static function getCostoGanancia($elemento)
    {
        $res = "Precio General de Base de Datos (PU) = $ ".$elemento->getPrecio($elemento)."   [Costo = $ ".$elemento->costo;
        if($elemento->tipo_ganancia =="%"){
            $res = $res." | Ganancia = ".$elemento->ganancia." ".$elemento->tipo_ganancia."]";
        }else{
            $res = $res." | Ganancia = ".$elemento->tipo_ganancia." ".$elemento->ganancia."]";
        }
        return $res;
    }

    public static function getElementos()
    {
        $elementos = Elemento::query();
        $queries = [];

        $columnas = ['tipo', 'proveedor_id', 'nombre'];

        foreach($columnas as $columna){

            if(request()->has($columna) and request($columna)!= 'all' and request($columna)!= ''){
                $elementos = $elementos->where($columna,'LIKE','%'.request($columna).'%');
                $queries[$columna] = request($columna);
            }
        }

		if(request()->has('sort'))
		{
            $elementos = $elementos->orderBy('proveedor_id',request('sort'));
            $queries['sort'] = request('sort');
		}

		$elementos = $elementos->paginate(15)->appends($queries);

        foreach ($elementos as $elemento) {
            $elemento->precio = Elemento::getPrecio($elemento);
        }

        return $elementos ;
    }
}
