<?php

namespace mmdi;

use Illuminate\Database\Eloquent\Model;

class Proveedore extends Model
{
    public function proyectos()
    {
        # Cliente has many Proyectos
        # Define a one-to-many relationship.
        return $this->hasMany('mmdi\Elemento');
    }

    public function cotizaciones()
    {
        # Proyecto has many Cotizaciones
        # Define a one-to-many relationship.
        return $this->hasMany('mmdi\Cotizacione');
    }

    public function pagosProveedores()
    {
        # Cliente has many Proyectos
        # Define a one-to-many relationship.
        return $this->hasMany('mmdi\PagoProveedore');
    }

    public static function getProveedores()
    {
        $proveeedores = Proveedore::query();
        $queries = [];

        $columnas = ['nombre', 'razon_social', 'rfc'];

        foreach($columnas as $columna){
            if(request()->has($columna) and request($columna)!= 'all' and request($columna)!= ''){
                $proveeedores = $proveeedores->where($columna,'LIKE','%'.request($columna).'%');
                $queries[$columna] = request($columna);
            }
        }

		if(request()->has('sort'))
		{
            $proveeedores = $proveeedores->orderBy('nombre',request('sort'));
            $queries['sort'] = request('sort');
		}

		$proveeedores = $proveeedores->paginate(15,['*'], 'proveeedores_p')->appends($queries);

        return $proveeedores ;
    }
}
