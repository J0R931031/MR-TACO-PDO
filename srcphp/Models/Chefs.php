<?php
namespace proyecto\Models;

use proyecto\Response\Success;

class Chefs extends Models
{
    protected $filleable = ["ID_Chef", "PersonaID","Direccion","CURP","RFC"];
    protected $table = "Chefs";

    public function mostrarChefs() 
    {
        $chef = Chefs::all();

        $success = new Success($chef);
        return $success->send();
    }
}
