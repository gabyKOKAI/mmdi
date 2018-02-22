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
}
