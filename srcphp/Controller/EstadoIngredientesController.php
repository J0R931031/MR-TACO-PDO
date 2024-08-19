<?php

namespace proyecto\Controller;

use PDO;
use proyecto\Conexion;

class EstadoIngredientesController
{
    protected $pdo;

    public function __construct()
    {
        $cc = new Conexion("mrtacotrc", "localhost", "root", "1234");
        $this->pdo = $cc->getPDO();
    }

    public function obtenerIngredientes()
    {
        try {
            // Llamar al procedimiento almacenado para obtener los ingredientes
            $stmt = $this->pdo->query("CALL ObtenerIngredientes()");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function cambiarEstadoIngrediente($ingredienteId)
    {
        try {
            // Llamar al procedimiento almacenado para cambiar el estado del ingrediente
            $stmt = $this->pdo->prepare("CALL CambiarEstadoIngrediente(:ingrediente_id)");
            $stmt->bindParam(':ingrediente_id', $ingredienteId, PDO::PARAM_INT);
            $stmt->execute();

            return ['success' => true, 'message' => 'Estado cambiado correctamente.'];

        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
}
