<?php

    namespace proyecto\Controller;

    use PDO;
    use proyecto\Conexion;
    
    class EstadoReservaController
    {
        protected $pdo;
    
        public function __construct()
        {
            $cc = new Conexion("mrtacotrc", "localhost", "root", "1234");
            $this->pdo = $cc->getPDO();
        }
    
        public function cambiarEstadoReserva($reservaId)
        {
            try {
                $stmt = $this->pdo->prepare("CALL CambiarEstadoReserva(:reservaID)");
                $stmt->bindParam(':reservaID', $reservaId, PDO::PARAM_INT);
                $stmt->execute();
    
                return ["success" => true, "message" => "Estado de la reserva cambiado exitosamente."];
            } catch (\PDOException $e) {
                return ["success" => false, "message" => "Error al cambiar el estado: " . $e->getMessage()];
            }
        }
    
        public function obtenerEstadoReservas()
        {
            try {
                $stmt = $this->pdo->prepare("CALL ObtenerEstadoReservas()");
                $stmt->execute();
                $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                return $reservas;
            } catch (\PDOException $e) {
                return ["success" => false, "message" => "Error al obtener reservas: " . $e->getMessage()];
            }
        }
    }
    





