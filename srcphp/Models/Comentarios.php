<?php

namespace proyecto\Models;

use proyecto\Response\Error;
use proyecto\Response\Success;

class Comentarios extends Models
{
    protected $filleable = ["ComentarioID", "UsuarioID", "Comentario", "FechaYHora"];
    protected $table = "Comentarios";

    
    public function agregarComentario($usuarioID, $comentario)
    {
        if ($this->contienePalabrasAntisonantes($comentario)) {
            $error = new Error("El comentario contiene palabras inapropiadas.");
            return $error->send();
        }

        $this->create([
            'UsuarioID' => $usuarioID,
            'Comentario' => $comentario,
        ]);

        $success = new Success("Comentario agregado exitosamente.");
        return $success->send();
    }

    private function contienePalabrasAntisonantes($comentario)
    {
        foreach ($this->badWordsPatterns as $pattern) {
            if (preg_match($pattern, $comentario)) {
                return true;
            }
        }
        return false;
    }

    public function mostrarComentarios()
    {
        $comentarios = Comentarios::all();

        $success = new Success($comentarios);
        return $success->send();
    }
}
