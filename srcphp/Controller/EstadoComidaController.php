<?php

namespace proyecto\Controller;

use PDO;
use proyecto\Conexion;
use proyecto\Exception;

class EstadoComidaController
{
    protected $pdo;

    public function __construct()
    {
        $cc = new Conexion("mrtacotrc", "localhost", "root", "1234");
        $this->pdo = $cc->getPDO();
    }

    public function cambiarEstadoComida($comidaId)
    {
        try {
            $stmt = $this->pdo->prepare("CALL CambiarEstadoComida(:comidaId, @message)");
            $stmt->bindParam(':comidaId', $comidaId);
            $stmt->execute();

            $outputStmt = $this->pdo->query("SELECT @message")->fetch(PDO::FETCH_ASSOC);
            $message = $outputStmt['@message'];

            return ["message" => $message];

        } catch (\PDOException $e) {
            return ["error" => "Error: " . $e->getMessage()];
        }
    }

    public function obtenerComida()
    {
        try {
            $stmt = $this->pdo->prepare("CALL GetComidas()");
            $stmt->execute();
            $comida = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $comida;

        } catch (\PDOException $e) {
            return ["error" => "Error: " . $e->getMessage()];
        }
    }
}