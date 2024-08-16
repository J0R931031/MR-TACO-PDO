<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use proyecto\Response\Failure;
use proyecto\Response\Response;
use proyecto\Response\Success;
use function json_encode;

class User extends Models
{

    public $user = "";
    public $contrasena = "";
    public $nombre = "";
    public $edad = "";
    public $correo = "";
    public $apellido = "";

    public $id = "";

    /**
     * @var array
     */
    protected $filleable = [
        "nombre",
        "edad",
        "correo",
        "apellido",
        "contrasena",
        "user"
    ];
    protected    $table = "usuarios";



    public static function auth($correo, $contrasena)
{
    $class = get_called_class();
    $c = new $class();

    // Define la clave de encriptación utilizada para AES
    $clave_encriptacion = 'BARBAROS'; // Asegúrate de que coincida con la clave utilizada en el procedimiento almacenado

    try {
        // Consulta SQL para autenticar al usuario utilizando su nombre completo
        $stmt = self::$pdo->prepare("
            SELECT
                Personas.Nombre,        -- Nombre completo del usuario
                Usuarios.Correo,                -- Correo electrónico del usuario
                Usuarios.ID_U,       -- ID del usuario
                CONVERT(AES_DECRYPT(Usuarios.Contraseña, :clave_encriptacion) AS CHAR) as Contrasena
            FROM {$c->table} Usuarios
            INNER JOIN Personas  ON Usuarios.UsuarioID = Personas.UsuarioID
            WHERE Usuarios.correo = :correo
        ");

        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':clave_encriptacion', $clave_encriptacion);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_OBJ);

        if ($resultado && $resultado->Contrasena === $Contrasena) {
            // Usuario encontrado, retornar éxito con datos completos
            return [
                'success' => true,
                'usuario' => [
                    'Nombre' => $resultado->Nombre,
                    'Correo' => $resultado->Correo,
                    'UsuarioID' => $resultado->UsuarioID
                ],
                '_token' => Auth::generateToken([$resultado->UsuarioID])
            ];
        }

    public function find_name($name)
    {
        $stmt = self::$pdo->prepare("select *  from $this->table  where  nombre=:name");
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($resultados == null) {
            return json_encode([]);
        }
        return json_encode($resultados[0]);
    }

    public  function reportecitas(){
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);

        $name=$dataObject->name;
        $d=Table::query("select * from users  where name='".$name."'");
        $r=new Success($d);

    }

}
