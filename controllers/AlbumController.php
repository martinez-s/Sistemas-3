<?php

require_once '../db/conexion.php';
require_once '../models/Album.php';

class AlbumController
{
    private PDO $db;

    public function __construct(PDO $conexion)
    {
        $this->db = $conexion;
    }

    public function listarAlbumes(): array
    {
        $album = new Album($this->db);
        return $album->obtenerTodos();
    }

    public function detalle(int $id): array
    {
        $albumModel = new Album($this->db);
        $album      = $albumModel->obtenerPorId($id);

        if (!$album) {
            header("Location: ../views/discografia.php");
            exit();
        }

        $tracklist = $albumModel->obtenerTracklist($id);
        return compact('album', 'tracklist');
    }
}
