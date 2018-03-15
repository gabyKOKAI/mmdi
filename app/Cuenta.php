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
}
