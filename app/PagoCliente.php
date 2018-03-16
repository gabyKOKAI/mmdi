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
}
