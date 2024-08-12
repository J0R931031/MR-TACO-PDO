<?php

namespace proyecto\Controller;

use proyecto\Models\Personas;
use proyecto\Models\Usuarios;
use proyecto\Models\Chefs;
use proyecto\Models\Meseros;
use proyecto\Response\Success;
use proyecto\Response\Failure;

class EmpleadosController {
    public function registrarcliente() {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData); // Corregido a $dataObject
    
            // Crear el objeto usuario
            $newusuario = new Usuarios();
            $newusuario->ID_U = $dataObject->ID_U;
            $newusuario->Correo = $dataObject->Correo;
            $newusuario->Contrasena = password_hash($dataObject->Contrasena, PASSWORD_DEFAULT);
    
            // Guardar el nuevo usuario para obtener su ID
            $newusuario->save();
    
            // Crear el objeto persona
            $newpersona = new Personas();
            $newpersona->ID_P = $dataObject->ID_P;
            $newpersona->Nombre = $dataObject->Nombre;
            $newpersona->ApellidoPaterno = $dataObject->ApellidoPaterno;
            $newpersona->ApellidoMaterno = $dataObject->ApellidoMaterno;
            $newpersona->Sexo = $dataObject->Sexo;
            $newpersona->Telefono = $dataObject->Telefono;
            $newpersona->FechaNacimiento = $dataObject->FechaNacimiento;
            $newpersona->Edad = $dataObject->Edad;
            $newpersona->UsuarioID = $newusuario->ID_U; // Asegúrate de que $newusuario tenga un ID asignado
            $newpersona->save();
    
            // Obtener el ID de la nueva persona guardada

    
            // Devolver la respuesta de éxito
            return (new Success($newpersona))->Send();
    
        } catch (Exception $e) {
            return (new Error($e->getMessage()))->Send();
        }
    }
}
