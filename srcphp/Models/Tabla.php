<?php
namespace proyecto\Models;

use proyecto\Response\Success;

class Tabla extends Models
{
    protected $filleable = [
        "ID_P", 
        "Nombre", 
        "ApellidoPaterno", 
        "ApellidoMaterno", 
        "Sexo", 
        "Telefono", 
        "Direccion", 
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