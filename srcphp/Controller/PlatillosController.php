<?php

namespace proyecto\Controller;

use PDO;
use proyecto\Conexion;

class PlatillosController
{
    protected $pdo;

    public function __construct()
    {
        $cc = new Conexion("mrtacotrc", "localhost", "root", "1234");
        $this->pdo = $cc->getPDO();
    }

    public function obtenerPlatillos()
    {
        try {
            $query = "SELECT ID_Comida, Nombre, Descripcion, Precio, Categoria, Estado 
                      FROM COMIDA 
                      WHERE Categoria IN (1, 4) AND Estado = 'Habilitado'";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            $platillos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $platillos;

        } catch (\PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
