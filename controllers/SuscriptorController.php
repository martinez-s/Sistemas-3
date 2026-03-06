<?php

require_once '../conexion.php';
require_once '../models/Suscriptor.php';

class SuscriptorController
{
    private $db;

    public function __construct(PDO $conexion)
    {
        $this->db = $conexion;
    }

    public function procesarSuscripcion($postData) : void
    {
        $email = filter_var(trim($postData["email"]), FILTER_SANITIZE_EMAIL);
        $pais = htmlspecialchars(trim($postData["pais"]));

        if (empty($email) || empty($pais) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->redirigirConMensaje("error", "Datos inválidos", "Por favor, asegúrate de ingresar un correo válido y seleccionar tu país.");
            return;
        }

        try {
            $suscriptor = new Suscriptor($this->db, $email, $pais);
            $resultado = $suscriptor->registrar();

            if ($resultado === "duplicado") {
                $this->redirigirConMensaje("info","Correo ya registrado", "Parece que este correo ya está suscrito. ¡Gracias por tu interés!");
                
            } elseif ($resultado === true) {
                $this->redirigirConMensaje("success","¡Suscripción exitosa!", "Gracias por suscribirte a nuestro boletín desde {$pais}. ¡Pronto recibirás las últimas novedades de Sabrina Carpenter!");
            }
        } catch (Exception $e) {
            $this->redirigirConMensaje("error","Error del servidor", "Lo sentimos, ocurrió un error al procesar tu solicitud. Por favor, inténtalo de nuevo más tarde.");
        }
    }

    private function redirigirConMensaje(string $tipo, string $mensaje):void
    {
        if (session_status() == PHP_SESSION_NONE) {session_start();}

        $_SESSION['flash'] = ['tipo' => $tipo,'mensaje' => $mensaje];
        header("Location: ../views/index.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $controlador = new SuscriptorController($conexion);
    $controlador->procesarSuscripcion($_POST);
} else {
    header("Location: ../index.php");
    exit();
}
