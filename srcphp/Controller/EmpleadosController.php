<?php

namespace proyecto\Controller;

use proyecto\Models\Personas;
use proyecto\Models\Meseros;
use proyecto\Models\Chefs;
use proyecto\Response\Success;
use proyecto\Response\Failure;

class EmpleadosController {
    public function register() {
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);

        // Validar que todos los campos requeridos están presentes
        if (!isset($dataObject->ID_P, $dataObject->Nombre, $dataObject->ApellidoPaterno, $dataObject->ApellidoMaterno, $dataObject->Sexo, $dataObject->Telefono, $dataObject->Direccion, $dataObject->FechaNacimiento, $dataObject->Edad, $dataObject->UsuarioID)) {
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
            'Direccion' => $dataObject->Direccion,
            'FechaNacimiento' => $dataObject->FechaNacimiento,
            'Edad' => $dataObject->Edad,
            'UsuarioID' => $dataObject->UsuarioID,
        ]);

        if (!$newPersona) {
            return (new Failure(500, "Error al crear la persona"))->Send();
        }

        // Verificar si es mesero
        if (isset($dataObject->ID_Mesero, $dataObject->FechaRegistro)) {
            $newMesero = Meseros::create([
                'ID_Mesero' => $dataObject->ID_Mesero,
                'FechaRegistro' => $dataObject->FechaRegistro,
                'PersonaID' => $newPersona->ID_P,
            ]);

            if (!$newMesero) {
                return (new Failure(500, "Error al crear el mesero"))->Send();
            }

            return (new Success($newMesero))->Send();
        }

        // Verificar si es chef
        if (isset($dataObject->ID_Chef, $dataObject->FechaDeRegistro)) {
            $newChef = Chefs::create([
                'ID_Chef' => $dataObject->ID_Chef,
                'FechaDeRegistro' => $dataObject->FechaDeRegistro,
                'PersonaID' => $newPersona->ID_P,
            ]);

            if (!$newChef) {
                return (new Failure(500, "Error al crear el chef"))->Send();
            }

            return (new Success($newChef))->Send();
        }

        return (new Failure(400, "Tipo de empleado no especificado"))->Send();
    }
}