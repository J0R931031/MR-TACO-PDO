<?php
namespace proyecto\Models;

use proyecto\Response\Success;

class Ordenes extends Models
{
    protected $filleable = ["RegOrd", "FechaHoraApertura", "Mesa", "Nombre", "MeseroID", "FechaHoraCierre", "PrecioTotal", "Estado"];
    protected $table = "Ordenes";

    public function mostrarOrdenes() 
    {
        $orden = Ordenes::all();

        $success = new Success($orden);
        return $success->send();
    }
}
