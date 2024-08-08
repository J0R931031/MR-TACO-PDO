<?php
namespace proyecto\Models;

use proyecto\Response\Success;

class DetalleComida extends Models
{
    protected $filleable = ["ComidaID", "IngredienteID"];
    protected $table = "Detalle_Comida";

    public function mostrarDetalleComida() 
    {
        $detalleComida = DetalleComida::all();

        $success = new Success($detalleComida);
        return $success->send();
    }
}
