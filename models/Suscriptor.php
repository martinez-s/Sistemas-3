<?php

class Suscriptor
{
    public $email;
    public $pais;
    public $fechaRegistro;

    private PDO $conexion;

    public function __construct(PDO $db, string $email, string $pais)
    {
        $this->conexion = $db;
        $this->email = $email;
        $this->pais = $pais;
        $this->fechaRegistro = date('Y-m-d H:i:s');
    }

    public function registrar(): string|bool
    {
        try {
            $sql = "INSERT INTO suscriptores (email, pais, fechaRegistro) VALUES (:email, :pais, :fechaRegistro)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':pais', $this->pais);
            $stmt->bindParam(':fechaRegistro', $this->fechaRegistro);

            return $stmt->execute();
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return "duplicado";
            }
            throw $e;
        }
    }

    public function enviarNewsletter($noticia)
    {
        return true;
    }
}
