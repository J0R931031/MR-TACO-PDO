<?php
namespace proyecto\Models;

use proyecto\Response\Success;

class Roles extends Models
{
   
    protected $filleable = ["ID_Rol", "NombreRol"];
    protected $table = "Roles";

    public function mostrarRoles() 
    {
        $rol = Roles::all();

        $success = new Success($rol);
        return $success -> send();
    }
}