<?php

namespace proyecto\Controller;

use proyecto\Models\User;
use proyecto\Response\Failure;
use proyecto\Response\Success;

class LoginController
{
    public function login($data)
    {
        $usuario = $data['usuario'];
        $contrasena = $data['contrasena'];

        $authResponse = User::auth($usuario, $contrasena);

        if ($authResponse['success']) {
            return [
                'success' => true,
                'message' => 'Login exitoso',
                'usuario' => $authResponse['usuario'],
                '_token' => $authResponse['_token']
            ];
        } else {
            return [
                'success' => false,
                'message' => $authResponse['msg']
            ];
        }
    }
}
