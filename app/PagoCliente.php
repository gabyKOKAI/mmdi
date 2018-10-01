<?php

namespace mmdi;

use Illuminate\Database\Eloquent\Model;

class PagoCliente extends Model
{
    public function cliProv()
    {
        # Proyecto belongs to Cliente
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('mmdi\Cliente');
    }

    public function proyCoti()
    {
        # Proyecto belongs to Cliente
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('mmdi\Proyecto');
    }

    public function user()
    {
        # Proyecto belongs to Cliente
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('mmdi\User');
    }

    public function cuenta()
    {
        # Proyecto belongs to Cliente
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('mmdi\Cuenta');
    }

    public static function getEstatusDropDown()
    {
        $estatus = ['Facturado', 'Factura Pendiente', 'Sin Factura', 'Cancelado'];
        return $estatus;
    }

    public static function getTiposDropDown()
    {
        $tipos = ['Transferencia', 'Efectivo', 'Cheque'];
        return $tipos;
    }

    public static function getPagos()
    {
        $pagos = PagoCliente::query();
        $queries = [];

        $columnas = ['cli_prov_id', 'proy_coti_id', 'tipo','cuenta_id','monto','estatus'];

        foreach($columnas as $columna){
            if(request()->has($columna) and request($columna)!= 'all' and request($columna)!= ''){
                $pagos = $pagos->where($columna,'LIKE','%'.request($columna).'%');
                $queries[$columna] = request($columna);
            }
        }

        if(request()->has('montoMayorA') and request('montoMayorA')!= ''){
            $montoMayorA = request('montoMayorA');
            $pagos = $pagos->where('monto', '>=', $montoMayorA);
            $queries['montoMayorA'] = request('montoMayorA');
        }
        if(request()->has('montoMenorA') and request('montoMenorA')!= ''){
            $montoMenorA = request('montoMenorA');
            $pagos = $pagos->where('monto', '<=', $montoMenorA);
            $queries['montoMenorA'] = request('montoMenorA');
        }

        if(request()->has('fechaMayorA') and request('fechaMayorA')!= ''){
            $fechaMayorA = request('fechaMayorA');
            $pagos = $pagos->where('fecha_pago', '>=', $fechaMayorA);
            $queries['fechaMayorA'] = request('fechaMayorA');
        }
        if(request()->has('fechaMenorA') and request('fechaMenorA')!= ''){
            $fechaMenorA = request('fechaMenorA');
            $pagos = $pagos->where('fecha_pago', '<=', $fechaMenorA);
            $queries['fechaMenorA'] = request('fechaMenorA');
        }

		if(request()->has('sort'))
		{
            $pagos = $clientes->orderBy('cliente_id',request('sort'));
            $queries['sort'] = request('sort');
		}

		$pagos = $pagos->paginate(15,['*'], 'pagos_p')->appends($queries);

        return $pagos ;
    }
}
