<?php
namespace proyecto\Models;

use proyecto\Response\Success;

class Pedidos extends Models
{
    protected $filleable = ["RegPedido", "FechaHoraPedido", "FechaHoraLlegada", "ClienteID", "PrecioTotal", "Estado"];
    protected $table = "Pedidos";

    public function mostrarPedidos() 
    {
        $pedido = Pedidos::all();

        $success = new Success($pedido);
        return $success->send();
    }
}
