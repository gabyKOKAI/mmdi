<?php

namespace mmdi;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    public function movimientos()
    {
        # Recurso has many movimientos
        # Define a one-to-many relationship.
        return $this->hasMany('mmdi\movimientos');
    }

     public function pagosClientes()
    {
        # Cliente has many Proyectos
        # Define a one-to-many relationship.
        return $this->hasMany('mmdi\PagoCliente');
    }

     public function pagosProveedores()
    {
        # Cliente has many Proyectos
        # Define a one-to-many relationship.
        return $this->hasMany('mmdi\PagoProveedore');
    }
}
