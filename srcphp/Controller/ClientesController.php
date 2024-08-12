<?php

namespace proyecto\Controller;

use PDO;
use proyecto\Conexion;
use proyecto\Exception;

class ClientesController
{
    protected $pdo;

    public function __construct()
    {
        $cc = new Conexion("mrtacotrc", "localhost", "root", "12345678");
        $this->pdo = $cc->getPDO();
    }

    public function register($data)
    {
        try {
            $stmt = $this->pdo->prepare
            ("CALL RegisterClient
            (:nombre,
             :apellidoPaterno, 
             :apellidoMaterno, 
             :sexo, 
             :telefono, 
             :fechaNacimiento, 
             :correo, 
             :contrasena, 
             @message)");
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':apellidoPaterno', $data['apellidoPaterno']);
            $stmt->bindParam(':apellidoMaterno', $data['apellidoMaterno']);
            $stmt->bindParam(':sexo', $data['sexo']);
            $stmt->bindParam(':telefono', $data['telefono']);
            $stmt->bindParam(':fechaNacimiento', $data['fechaNacimiento']);
            $stmt->bindParam(':correo', $data['correo']);
            $stmt->bindParam(':contrasena', $data['contrasena']);

            $stmt->execute();

            $outputStmt = $this->pdo->query("SELECT @message")->fetch(PDO::FETCH_ASSOC);
            $message = $outputStmt['@message'];

            return $message;

        } catch (\PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}