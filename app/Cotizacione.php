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

    public function pagosProveedores()
    {
        # Cliente has many Proyectos
        # Define a one-to-many relationship.
        return $this->hasMany('mmdi\PagoProveedore');
    }

    public static function getEstatusDropDown()
    {
        $estatus = ['Pendiente Cotizar','Cotizado','En Proceso','Entregado','Entrega Pendiente','Cancelado'];

        return $estatus;
    }

    public static function getSaldo($cotizacione)
    {
        if($cotizacione->con_iva == 1)
            $saldo = $cotizacione->monto/1.16 - Cotizacione::getEfectivo($cotizacione->id) -Cotizacione::getTransferencias($cotizacione->id) - Cotizacione::getCheques($cotizacione->id);
        else
            $saldo = $cotizacione->monto - Cotizacione::getEfectivo($cotizacione->id) -Cotizacione::getTransferencias($cotizacione->id) - Cotizacione::getCheques($cotizacione->id);
        return $saldo;
    }

    public static function getEfectivo($cotizacione_id)
    {
        $efectivo = PagoProveedore::where('proy_coti_id','=',$cotizacione_id)->where('tipo','=','Efectivo')->where('con_iva','=',0)->where('estatus','<>','Cancelado')->sum('monto');
        $efectivoIVA = PagoProveedore::where('proy_coti_id','=',$cotizacione_id)->where('tipo','=','Efectivo')->where('con_iva','=',1)->where('estatus','<>','Cancelado')->sum('monto')/1.16;
        return $efectivo + $efectivoIVA;
    }

    public static function getTransferencias($cotizacione_id)
    {
        $transferencias = PagoProveedore::where('proy_coti_id','=',$cotizacione_id)->where('tipo','=','Transferencia')->where('con_iva','=',0)->where('estatus','<>','Cancelado')->sum('monto');
        $transferenciasIVA = PagoProveedore::where('proy_coti_id','=',$cotizacione_id)->where('tipo','=','Transferencia')->where('con_iva','=',1)->where('estatus','<>','Cancelado')->sum('monto')/1.16;
        return $transferencias + $transferenciasIVA;
    }

    public static function getCheques($cotizacione_id)
    {
        $cheques = PagoProveedore::where('proy_coti_id','=',$cotizacione_id)->where('tipo','=','Cheque')->where('con_iva','=',0)->where('estatus','<>','Cancelado')->sum('monto');
        $chequesIVA = PagoProveedore::where('proy_coti_id','=',$cotizacione_id)->where('tipo','=','Cheque')->where('con_iva','=',1)->where('estatus','<>','Cancelado')->sum('monto')/1.16;
        return $cheques + $chequesIVA;
    }

    public static function calculoVariables($cotizacione)
    {
        $cotizacione->efectivo = $cotizacione->getEfectivo($cotizacione->id);
        $cotizacione->transferencias = $cotizacione->getTransferencias($cotizacione->id);
        $cotizacione->cheques = $cotizacione->getCheques($cotizacione->id);
        $cotizacione->saldo = $cotizacione->getSaldo($cotizacione);
    }
}
