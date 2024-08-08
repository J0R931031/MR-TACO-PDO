<?php
namespace proyecto\Models;

use proyecto\Response\Success;

class Comida extends Models
{
    protected $filleable = ["ID_Comida", "Nombre", "Descripcion", "Precio"];
    protected $table = "Comida";

    public function mostrarComida() 
    {
        $comida = Comida::all();

        $success = new Success($comida);
        return $success->send();
    }
}
