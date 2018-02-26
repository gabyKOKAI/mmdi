<?php

namespace mmdi;

use Illuminate\Database\Eloquent\Model;

class Cotizacione extends Model
{

   public function proyecto()
    {
        # Proyecto belongs to Proyecto
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('mmdi\Proyecto');
    }

     public function proveedor()
    {
        # Proyecto belongs to ProVEEDOR
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('mmdi\Proveedore');
    }

   public static function getEstatusDropDown()
    {
        $estatus = ['Pendiente Cotizar','Cotizado','En Proceso','Entregado','Entrega Pendiente','Cancelado','Rechazado'];

        return $estatus;
    }
}
