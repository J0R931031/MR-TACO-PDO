<?php
namespace proyecto\Models;

use proyecto\Response\Success;

class Personas extends Models
{
    protected $filleable = [
        "Nombre", 
        "ApellidoPaterno", 
        "ApellidoMaterno", 
        "Sexo", 
        "Telefono", 
        "FechaNacimiento", 
        "Edad", 
        "UsuarioID"];
    protected $table = "Personas";

    public function mostrarPersonas() 
    {
        $persona = Personas::all();

        $success = new Success($persona);
        return $success->send();
    }
}