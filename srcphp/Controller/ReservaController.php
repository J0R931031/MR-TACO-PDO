<?php

namespace proyecto\Controller;

use PDO;
use proyecto\Conexion;
use proyecto\Exception;

class ReservaController
{
    protected $pdo;

    public function __construct()
    {
        $cc = new Conexion("mrtacotrc", "localhost", "root", "1234");
        $this->pdo = $cc->getPDO();
    }

    public function obtenerReservas()
    {
        try {
            $stmt = $this->pdo->prepare("CALL TablaReservas()");
            $stmt->execute();
            $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $reservas;

        } catch (\PDOException $e) {
            return ["error" => "Error al obtener las reservas: " . $e->getMessage()];
        }
    }
}
