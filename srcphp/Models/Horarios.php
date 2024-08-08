<?php
namespace proyecto\Models;

use proyecto\Response\Success;

class Horarios extends Models
{
    protected $filleable = ["Dia", "Horario1", "Horario2"];
    protected $table = "HORARIOS";

    public function mostrarHorarios() 
    {
        $horarios = Horarios::all();

        $success = new Success($horarios);
        return $success->send();
    }
}
?>
