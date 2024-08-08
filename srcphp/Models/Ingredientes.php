<?php
namespace proyecto\Models;

use proyecto\Response\Success;

class Ingredientes extends Models
{
    protected $filleable = ["ID_Ingrediente", "Nombre"];
    protected $table = "Ingredientes";

    public function mostrarIngredientes() 
    {
        $ingrediente = Ingredientes::all();

        $success = new Success($ingrediente);
        return $success->send();
    }
}
