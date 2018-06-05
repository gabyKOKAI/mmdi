<?php

use mmdi\Proyecto;
use mmdi\Cotizacione;
use mmdi\Concepto;
use mmdi\Elemento;

Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Home', route('home'));
});

Breadcrumbs::register('proyectos', function ($breadcrumbs) {
    //$breadcrumbs->parent('home');
    $breadcrumbs->push('Proyectos', route('proyectos'));
});

Breadcrumbs::register('proyecto', function ($breadcrumbs, $proyecto) {
    $breadcrumbs->parent('proyectos');
    if($proyecto->id != -1){
        $breadcrumbs->push($proyecto->nombre, route('proyecto', ['id' => $proyecto->id, 'idCli' => $proyecto->cliente->id]));
    }else{
        $breadcrumbs->push('Nuevo Proyecto', route('proyecto', ['id' => '-1', 'idCli' => '-1']));
    }
});

Breadcrumbs::register('elementos', function ($breadcrumbs) {
    //$breadcrumbs->parent('home');
    $breadcrumbs->push('Elementos', route('elementos'));
});
Breadcrumbs::register('concepto', function ($breadcrumbs, $concepto, $idProy) {
    if($idProy != -1){
        $proyecto = Proyecto::find($idProy);
        $breadcrumbs->parent('proyecto', $proyecto);
    }
    if($concepto->id != -1){
        $breadcrumbs->push($concepto->nombre, route('concepto', ['id' => $concepto->id]));
    }else{
        $breadcrumbs->push("Nuevo Concepto", route('concepto', ['id' => $concepto->id]));
    }

});

Breadcrumbs::register('elemento', function ($breadcrumbs, $elemento) {
    $breadcrumbs->parent('elementos');
    if($elemento->id != -1){
        $breadcrumbs->push($elemento->nombre, route('elemento', ['id' => $elemento->id]));
    }else{
        $breadcrumbs->push('Nuevo Elemento', route('elemento', ['id' => '-1']));
    }

});

Breadcrumbs::register('subConcepto', function ($breadcrumbs, $concepto, $elemento) {
    if($concepto->id != -1){
        $concepto = Concepto::find($concepto->id);
        $breadcrumbs->parent('concepto', $concepto, $concepto->proyecto->id);
        /*if($elemento->id != -1){
            $elemento = Elemento::find($elemento->id);
            $breadcrumbs->parent('elemento', $elemento);
            $breadcrumbs->push($concepto->nombre."-".$elemento->nombre, route('subConcepto', ['idCon' => $concepto->id,'id1Ele' => $elemento->id]));
        }else{
        }*/
        $breadcrumbs->push($concepto->nombre."-".$elemento->nombre, route('subConcepto', ['idCon' => $concepto->id,'id1Ele' => $elemento->id]));
    }
});

Breadcrumbs::register('conceptosElemento', function ($breadcrumbs, $elemento, $conceptoId) {
    if($conceptoId != -1){
        $concepto = Concepto::find($conceptoId);
        $breadcrumbs->parent('subConcepto', $concepto, $elemento);
        $breadcrumbs->push($elemento->nombre, route('subConcepto', ['idCon' => $conceptoId,'id1Ele' => $elemento->id]));
    }
});

Breadcrumbs::register('clientes', function ($breadcrumbs) {
    //$breadcrumbs->parent('home');
    $breadcrumbs->push('Clientes', route('clientes'));
});

Breadcrumbs::register('cliente', function ($breadcrumbs, $cliente, $idProy) {
    if($idProy != -1){
        $proyecto = Proyecto::find($idProy);
        $breadcrumbs->parent('proyecto', $proyecto);
        if($cliente->id != -1){
            $breadcrumbs->push($cliente->nombre, route('proyecto', ['id' => $proyecto->id]));
        }else{
            $breadcrumbs->push("Nuevo Cliente", route('proyecto', ['id' => $proyecto->id]));
        }
    }else{
        $breadcrumbs->parent('clientes');
        if($cliente and $cliente->id != -1){
            $breadcrumbs->push($cliente->nombre, route('proyecto', ['id' => '-1']));
        }else{
            $breadcrumbs->push("Nuevo Cliente", route('proyecto', ['id' => '-1']));
        }
    }
});

Breadcrumbs::register('cotizaciones', function ($breadcrumbs) {
    //$breadcrumbs->parent('home');
    $breadcrumbs->push('CXP', route('cotizaciones'));
});

Breadcrumbs::register('cotizacion', function ($breadcrumbs, $cotizacion) {
    $breadcrumbs->parent('cotizaciones');
    if($cotizacion->id == -1){
        $breadcrumbs->push('Nueva Cotización', route('cotizacion', ['id' => '-1', 'idCli' => '-1']));
    }else{
        $breadcrumbs->push($cotizacion->nombre, route('cotizacion', ['id' => $cotizacion->id, 'idPro' => $cotizacion->proveedor->id]));
    }
});

Breadcrumbs::register('proveedores', function ($breadcrumbs) {
    //$breadcrumbs->parent('home');
    $breadcrumbs->push('Proveedores', route('proveedores'));
});

Breadcrumbs::register('proveedor', function ($breadcrumbs, $proveedore, $idCoti) {
    if($idCoti == -1){
        $breadcrumbs->parent('proveedores');
        if($proveedore and $proveedore->id != -1){
            $breadcrumbs->push($proveedore->nombre, route('cotizacion', ['id' => '-1']));
        }else{
            $breadcrumbs->push("Nuevo Proveedor", route('cotizacion', ['id' => '-1']));
        }
    }else if($idCoti == -2){
        $cotizacion = new Cotizacione;
        $cotizacion->id = -1;
        $breadcrumbs->parent('cotizacion', $cotizacion);
        if($proveedore->id != -1){
            $breadcrumbs->push($proveedore->nombre, route('cotizacion', ['id' => $cotizacion->id]));
        }else{
            $breadcrumbs->push("Nuevo Proveedor", route('cotizacion', ['id' => $cotizacion->id]));
        }
    }else{
        $cotizacion = Cotizacione::find($idCoti);
        $breadcrumbs->parent('cotizacion', $cotizacion);
        if($proveedore->id != -1){
            $breadcrumbs->push($proveedore->nombre, route('cotizacion', ['id' => $cotizacion->id]));
        }else{
            $breadcrumbs->push("Nuevo Proveedor", route('cotizacion', ['id' => $cotizacion->id]));
        }
    }
});

Breadcrumbs::register('movimientos', function ($breadcrumbs) {
    //$breadcrumbs->parent('home');
    $breadcrumbs->push('Movimientos', route('movimientos'));
});

Breadcrumbs::register('movimiento', function ($breadcrumbs, $movimiento) {
    $breadcrumbs->parent('movimientos');
    if($movimiento->id == -1){
        $breadcrumbs->push('Nuevo Movimiento', route('movimiento', ['id' => '-1']));
    }
});



