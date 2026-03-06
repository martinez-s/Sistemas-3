<?php
require_once '../db/conexion.php';
require_once '../models/FechaTour.php';

class TourController
{
    private PDO $db;

    public function __construct(PDO $conexion)
    {
        $this->db = $conexion;
    }

    public function listarFechas(): array
    {
        $model = new FechaTour($this->db);
        return $model->obtenerProximas();
    }
}
