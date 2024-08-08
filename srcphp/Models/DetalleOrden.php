<?php
namespace proyecto\Models;

use proyecto\Response\Success;

class DetalleOrden extends Models
{
    protected $filleable = ["ID_DetalleOrden", "RegOrd", "ComidaID", "Cantidad", "FechaHoraOrd", "FechaHoraCon", "Especificaciones", "Estado", "ChefID"];
    protected $table = "Detalle_Orden";

    public function mostrarDetalleOrden() 
    {
        $detalleOrden = DetalleOrden::all();

        $success = new Success($detalleOrden);
        return $success->send();
    }
}
