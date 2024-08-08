<?php
namespace proyecto\Models;

use proyecto\Response\Success;

class Meseros extends Models
{
    protected $filleable = ["ID_Mesero", "FechaRegistro", "PersonaID"];
    protected $table = "Meseros";

    public function mostrarMeseros() 
    {
        $mesero = Meseros::all();

        $success = new Success($mesero);
        return $success->send();
    }
}
