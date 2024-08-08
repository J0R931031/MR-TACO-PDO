<?php
namespace proyecto\Models;

use proyecto\Response\Success;

class RolUsuario extends Models
{
    protected $filleable = ["RolID", "UsuarioID"];
    protected $table = "Rol_Usuario";

    public function mostrarRolUsuario() 
    {
        $rolUsuario = RolUsuario::all();

        $success = new Success($rolUsuario);
        return $success->send();
    }
}
