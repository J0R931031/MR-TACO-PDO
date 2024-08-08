<?php

namespace proyecto\Controller;

use proyecto\Models\Personas;
use proyecto\Models\Clientes;
use proyecto\Response\Success;
use proyecto\Response\Failure;

class ClientesController {
    public function register() {
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);

        // Validar que todos los campos requeridos están presentes
        if (!isset($dataObject->ID_P, $dataObject->Nombre, $dataObject->ApellidoPaterno, $dataObject->ApellidoMaterno, $dataObject->Sexo, $dataObject->Telefono, $dataObject->FechaNacimiento, $dataObject->Edad, $dataObject->UsuarioID, $dataObject->ID_Cliente, $dataObject->FechaDeRegistro)) {
            return (new Failure(400, "Datos incompletos"))->Send();
        }

        // Crear nueva persona
        $newPersona = Personas::create([
            'ID_P' => $dataObject->ID_P,
            'Nombre' => $dataObject->Nombre,
            'ApellidoPaterno' => $dataObject->ApellidoPaterno,
            'ApellidoMaterno' => $dataObject->ApellidoMaterno,
            'Sexo' => $dataObject->Sexo,
            'Telefono' => $dataObject->Telefono,
            'FechaNacimiento' => $dataObject->FechaNacimiento,
            'Edad' => $dataObject->Edad,
            'UsuarioID' => $dataObject->UsuarioID,
        ]);

        if (!$newPersona) {
            return (new Failure(500, "Error al crear la persona"))->Send();
        }

        // Crear nuevo cliente
        $newCliente = Clientes::create([
            'ID_Cliente' => $dataObject->ID_Cliente,
            'FechaDeRegistro' => $dataObject->FechaDeRegistro,
            'PersonaID' => $newPersona->ID_P,
        ]);

        // Llamar al procedimiento almacenado para registrar a la persona
        $query = "CALL RegistrarPersonaLogin(
            '$nombre', 
            '$apellidos', 
            '$fechaNacimiento', 
            '$sexo', 
            '$correo', 
            '$telefono', 
        )";

        // Ejecutar la consulta
        try {
            $resultados = Table::query($query);
            $r = new Success(['success' => true, 'message' => 'Registro exitoso']);
            return $r->send();
        } catch (\Exception $e) 
        {
            echo json_encode(['success' => false, 'message' => 'Error en el registro: ' . $e->getMessage()]);
            return;
        }

        if (!$newCliente) {
            return (new Failure(500, "Error al crear el cliente"))->Send();
        }

        return (new Success($newCliente))->Send();
    }
}

