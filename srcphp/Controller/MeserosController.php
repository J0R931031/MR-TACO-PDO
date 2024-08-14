<?php

namespace proyecto\Controller;

use PDO;
use proyecto\Conexion;

class MeserosController
{
    protected $pdo;

    public function __construct()
    {
        $cc = new Conexion("mrtacotrc", "localhost", "root", "12345678");
        $this->pdo = $cc->getPDO();
    }

    public function getMeserosInfo()
    {
        try {
            $stmt = $this->pdo->prepare("CALL GetMeserosInfo()");
            $stmt->execute();
            $meseros = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $meseros;

        } catch (\PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
