<?php

namespace mmdi;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public function proyectos()
    {
        # Cliente has many Proyectos
        # Define a one-to-many relationship.
        return $this->hasMany('mmdi\Proyecto');
    }

    public function pagosClientes()
    {
        # Cliente has many Proyectos
        # Define a one-to-many relationship.
        return $this->hasMany('mmdi\PagoCliente');
    }

    public static function getClientes()
    {
        $clientes = Cliente::query();
        $queries = [];

        $columnas = ['nombre', 'razon_social', 'rfc'];

        foreach($columnas as $columna){
            if(request()->has($columna) and request($columna)!= 'all' and request($columna)!= ''){
                $clientes = $clientes->where($columna,'LIKE','%'.request($columna).'%');
                $queries[$columna] = request($columna);
            }
        }

		if(request()->has('sort'))
		{
            $clientes = $clientes->orderBy('nombre',request('sort'));
            $queries['sort'] = request('sort');
		}

		$clientes = $clientes->paginate(15,['*'], 'clientes_p')->appends($queries);

        return $clientes ;
    }
}
