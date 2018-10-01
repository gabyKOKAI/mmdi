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

    public static function getMovimientos()
    {
        $movimientos = Movimiento::query();
        $queries = [];

        $columnas = ['tipo','cuenta_id','recurso_id'];

        foreach($columnas as $columna){
            if(request()->has($columna) and request($columna)!= 'all' and request($columna)!= ''){
                $pagos = $movimientos->where($columna,'LIKE','%'.request($columna).'%');
                $queries[$columna] = request($columna);
            }
        }

        if(request()->has('montoMayorA') and request('montoMayorA')!= ''){
            $montoMayorA = request('montoMayorA');
            $movimientos = $movimientos->where('monto', '>=', $montoMayorA);
            $queries['montoMayorA'] = request('montoMayorA');
        }
        if(request()->has('montoMenorA') and request('montoMenorA')!= ''){
            $montoMenorA = request('montoMenorA');
            $movimientos = $movimientos->where('monto', '<=', $montoMenorA);
            $queries['montoMenorA'] = request('montoMenorA');
        }

        if(request()->has('fechaMayorA') and request('fechaMayorA')!= ''){
            $fechaMayorA = request('fechaMayorA');
            $movimientos = $movimientos->where('fecha', '>=', $fechaMayorA);
            $queries['fechaMayorA'] = request('fechaMayorA');
        }
        if(request()->has('fechaMenorA') and request('fechaMenorA')!= ''){
            $fechaMenorA = request('fechaMenorA');
            $movimientos = $movimientos->where('fecha', '<=', $fechaMenorA);
            $queries['fechaMenorA'] = request('fechaMenorA');
        }

		if(request()->has('sort'))
		{
            $movimientos = $clientes->orderBy('fecha',request('sort'));
            $queries['sort'] = request('sort');
		}

		$movimientos = $movimientos->paginate(15,['*'], 'movimentos_p')->appends($queries);

        return $movimientos ;
    }
}
