<?php

namespace proyecto\Models;

use PDO;
use proyecto\Auth;
use proyecto\Response\Failure;
use proyecto\Response\Success;

class User extends Models
{
    protected $table = "usuarios";

    public static function auth($usuario, $contrasena)
    {
        $class = get_called_class();
        $c = new $class();

        // Clave de encriptación que usas en la base de datos
        $clave_encriptacion = 'BARBAROSIDAD';

        try {
            // Consulta para autenticar al usuario con AES_DECRYPT
            $stmt = self::$pdo->prepare("
                SELECT
                    Personas.Nombre AS Nombre,
                    Usuarios.Usuario AS Usuario,
                    CAST(AES_DECRYPT(Usuarios.Contrasena, :clave_encriptacion) AS CHAR) as Contrasena,
                    Usuarios.ID_U AS ID_U
                FROM {$c->table} Usuarios
                INNER JOIN Personas ON Usuarios.ID_U = Personas.UsuarioID
                WHERE Usuarios.Usuario = :usuario
            ");

            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':clave_encriptacion', $clave_encriptacion);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_OBJ);

            if ($resultado && $resultado->Contrasena === $contrasena) {
                // Usuario autenticado correctamente
                return [
                    'success' => true,
                    'usuario' => [
                        'Nombre' => $resultado->Nombre,
                        'Usuario' => $resultado->Usuario,
                        'ID_U' => $resultado->ID_U
                    ],
                    '_token' => Auth::generateToken([$resultado->ID_U])
                ];
            } else {
                // Credenciales incorrectas
                return [
                    'success' => false,
                    'msg' => 'Credenciales incorrectas'
                ];
            }
        } catch (\PDOException $e) {
            // Error en la base de datos
            return [
                'success' => false,
                'msg' => 'Error en el proceso de autenticación: ' . $e->getMessage()
            ];
        }
    }
}
