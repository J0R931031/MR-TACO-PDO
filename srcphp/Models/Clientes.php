<?php
namespace proyecto\Models;

use proyecto\Response\Success;

class Clientes extends Models
{
    protected $filleable = ["ID_Cliente", "FechaDeRegistro", "PersonaID"];
    protected $table = "Clientes";

    public function mostrarClientes() 
    {
        $cliente = Clientes::all();

        $success = new Success($cliente);
        return $success->send();
    }
}
