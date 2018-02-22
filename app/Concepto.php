<?php

namespace mmdi;

use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    public function proyecto()
    {
        # Concepto belongs to Proyecto
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('mmdi\Proyecto');
    }

    public function elementos()
    {
        # With timetsamps() will ensure the pivot table has its created_at/updated_at fields automatically maintained
        return $this->belongsToMany('mmdi\Elemento')->withTimestamps()->withPivot('precio');
    }

    public static function getEstatusDropDown()
    {
        $estatus = ['Cotizado','En Proceso','Entregado','Cancelado'];
        return $estatus;
    }

    public static function precio($concepto)
    {
        $precio = $concepto->elementos->sum('pivot.precio');
        return $precio;
    }

    public static function getElementos($concepto)
    {
        $elementos = $concepto->elementos;

        foreach ($elementos as $elemento) {
            $elemento->precioCliente = $elemento->pivot->precio;
            $elemento->precio = $elemento->costo+$elemento->ganancia;
        }

        #->paginate(5)
        return $elementos ;
    }

    public static function getGananciaReal($concepto)
    {
        $elementos = $concepto->elementos;

        $ganancia = 0;
        foreach ($elementos as $elemento) {
            $ganancia = $ganancia + $elemento->pivot->precio - $elemento->costo;
        }

        return $ganancia ;
    }

}
