<?php

class Album
{
    public int $id;
    public string $titulo;
    public string $fechaLanzamiento;
    public string $portadaURL;
    public string $descripcion;
    public string $spotifyUrl;
    public string $youtubeUrl;

    private PDO $conexion;

    public function __construct(PDO $db)
    {
        $this->conexion = $db;
    }

    public function obtenerTodos(): array
    {;
        $stmt = $this->conexion->query(
            "SELECT a.*, e.nombreEra
            FROM albums a
            LEFT JOIN eras_musicales e ON a.eraId = e.id
            ORDER BY fechaLanzamiento DESC"
            );
        return $stmt->fetchAll();
    }

    public function obtenerPorId(int $id): ?array
    {
        $stmt = $this->conexion->prepare(
            "SELECT a.*, e.nombreEra
            FROM albums a
            LEFT JOIN eras_musicales e ON a.eraId = e.id
            WHERE a.id = :id"
        );
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $resultado = $stmt->fetch();
        return $resultado ?: null;
    }

    public function obtenerTracklist(int $albumId): array
    {
        $stmt = $this->conexion->prepare(
            "SELECT * FROM canciones
             WHERE albumId = :id
             ORDER BY numeroPista ASC"
        );
        $stmt->execute([':id' => $albumId]);
        return $stmt->fetchAll();
    }
}
