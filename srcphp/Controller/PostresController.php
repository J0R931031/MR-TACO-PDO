<?php

namespace proyecto\Controller;

use PDO;
use proyecto\Conexion;

class PostresController
{
    protected $pdo;

    public function __construct()
    {
        $cc = new Conexion("mrtacotrc", "localhost", "root", "1234");
        $this->pdo = $cc->getPDO();
    }

    public function getPostres()
    {
        try {
            $stmt = $this->pdo->prepare("CALL GetPostres()");
            $stmt->execute();
            $postres = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $postres;

        } catch (\PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
