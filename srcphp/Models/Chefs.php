<?php
namespace proyecto\Models;

use proyecto\Response\Success;

class Chefs extends Models
{
    protected $filleable = ["ID_Chef", "FechaDeRegistro", "PersonaID"];
    protected $table = "Chefs";

    public function mostrarChefs() 
    {
        $chef = Chefs::all();

        $success = new Success($chef);
        return $success->send();
    }
}
