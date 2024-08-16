<?php

namespace proyecto\Controller;

use PDO;
use proyecto\Conexion;

class BebidasController
{
    protected $pdo;

    public function __construct()
    {
        $cc = new Conexion("mrtacotrc", "localhost", "root", "1234");
        $this->pdo = $cc->getPDO();
    }

    public function getBebidas()
    {
        try {
            $stmt = $this->pdo->prepare("CALL GetBebidas()");
            $stmt->execute();
            $bebidas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $bebidas;

        } catch (\PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
