<?php

namespace mmdi;

use Illuminate\Database\Eloquent\Model;

class PagoProveedore extends Model
{

    public function cliProv()
    {
        # Proyecto belongs to Cliente
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('mmdi\Proveedore');
    }

    public function proyCoti()
    {
        # Proyecto belongs to Cliente
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('mmdi\Cotizacione');
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
}
