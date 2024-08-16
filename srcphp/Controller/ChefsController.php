<?php

namespace proyecto\Controller;

use PDO;
use proyecto\Conexion;

class ChefsController
{
    protected $pdo;

    public function __construct()
    {
        $cc = new Conexion("mrtacotrc", "localhost", "root", "1234");
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

    public function deleteChef($usuarioID)
    {
        try {
            // Ejecutar el procedimiento almacenado para eliminar un chef
            $stmt = $this->pdo->prepare("CALL DeleteEmployee(:usuarioID, @message)");
            $stmt->bindParam(':usuarioID', $usuarioID, PDO::PARAM_INT);
            $stmt->execute();

            // Obtener el mensaje de salida del procedimiento almacenado
            $outputStmt = $this->pdo->query("SELECT @message AS message")->fetch(PDO::FETCH_ASSOC);
            $message = $outputStmt['message'];

            return $message;

        } catch (\PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
