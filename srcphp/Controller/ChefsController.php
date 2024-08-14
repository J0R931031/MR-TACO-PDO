<?php

namespace proyecto\Controller;

use PDO;
use proyecto\Conexion;

class ChefsController
{
    protected $pdo;

    public function __construct()
    {
        $cc = new Conexion("mrtacotrc", "localhost", "root", "12345678");
        $this->pdo = $cc->getPDO();
    }

    public function getChefsInfo()
    {
        try {
            $stmt = $this->pdo->prepare("CALL GetChefsInfo()");
            $stmt->execute();
            $chefs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $chefs;

        } catch (\PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
