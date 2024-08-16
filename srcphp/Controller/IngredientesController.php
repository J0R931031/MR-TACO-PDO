<?php

namespace proyecto\Controller;

use PDO;
use proyecto\Conexion;

class IngredientesController
{
    protected $pdo;

    public function __construct()
    {
        $cc = new Conexion("mrtacotrc", "localhost", "root", "1234");
        $this->pdo = $cc->getPDO();
    }

    public function getIngredientesPorPlatillo($platilloID)
    {
        try {
            $stmt = $this->pdo->prepare("CALL GetIngredientesPorPlatillo(:platilloID)");
            $stmt->bindParam(':platilloID', $platilloID, PDO::PARAM_INT);
            $stmt->execute();
            $ingredientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $ingredientes;

        } catch (\PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
