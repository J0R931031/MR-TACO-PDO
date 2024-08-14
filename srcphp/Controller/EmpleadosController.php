<?php

namespace proyecto\Controller;

use PDO;
use proyecto\Conexion;
use proyecto\Exception;

class EmpleadosController
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
            $stmt = $this->pdo->prepare("CALL RegisterEmployee(
            :nombre, 
            :apellidoPaterno, 
            :apellidoMaterno, 
            :sexo, 
            :telefono, 
            :fechaNacimiento, 
            :direccion, 
            :CURP,
            :RFC, 
            :correo, 
            :contrasena, 
            :rolID, 
            @message)");
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':apellidoPaterno', $data['apellidoPaterno']);
            $stmt->bindParam(':apellidoMaterno', $data['apellidoMaterno']);
            $stmt->bindParam(':sexo', $data['sexo']);
            $stmt->bindParam(':telefono', $data['telefono']);
            $stmt->bindParam(':fechaNacimiento', $data['fechaNacimiento']);
            $stmt->bindParam(':direccion', $data['direccion']);
            $stmt->bindParam(':CURP', $data['CURP']);
            $stmt->bindParam(':RFC', $data['RFC']);
            $stmt->bindParam(':correo', $data['correo']);
            $stmt->bindParam(':contrasena', $data['contrasena']);
            $stmt->bindParam(':rolID', $data['rolID']);

            $stmt->execute();

            $outputStmt = $this->pdo->query("SELECT @message")->fetch(PDO::FETCH_ASSOC);
            $message = $outputStmt['@message'];

            return ['message' => $message];

        } catch (\PDOException $e) {
            // Capturar el error detallado de la base de datos y devolverlo
            return ['error' => 'Error en la base de datos: ' . $e->getMessage()];
        } catch (\Exception $e) {
            // Capturar cualquier otro error y devolverlo
            return ['error' => $e->getMessage()];
        }
    }
}
