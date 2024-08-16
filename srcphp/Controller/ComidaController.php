<?php

namespace proyecto\Controller;

use PDO;
use proyecto\Conexion;

class ComidaController
{
    protected $pdo;

    public function __construct()
    {
        $cc = new Conexion("mrtacotrc", "localhost", "root", "1234");
        $this->pdo = $cc->getPDO();
    }

    public function getComida()
    {
        try {
            $stmt = $this->pdo->prepare("CALL GetComida()");
            $stmt->execute();
            $comida = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $comida;

        } catch (\PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
