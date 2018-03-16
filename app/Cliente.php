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

}
