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
}
