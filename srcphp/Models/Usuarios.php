<?php
namespace proyecto\Models;

use proyecto\Response\Success;

class Usuarios extends Models
{
   
    protected $filleable = ["ID_U", "Correo", "Contrasena",];
    protected $table = "Usuarios";

    public function mostrarUsuarios() 
    {
        $usuario = Usuarios::all();

        $success = new Success($usuario);
        return $success -> send();
    }
}