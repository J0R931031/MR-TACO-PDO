<?php
namespace proyecto\Models;

use proyecto\Response\Success;

class DetallePedido extends Models
{
    protected $filleable = ["ID_DetallePedido", "RegPedido", "ComidaID", "Cantidad", "ChefID", "Especificaciones"];
    protected $table = "Detalle_Pedido";

    public function mostrarDetallePedido() 
    {
        $detallePedido = DetallePedido::all();

        $success = new Success($detallePedido);
        return $success->send();
    }
}
