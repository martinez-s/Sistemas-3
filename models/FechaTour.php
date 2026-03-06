<?php

class FechaTour
{
    public string $ciudad;
    public string $pais;
    public string $recinto;
    public string $fechaHora;
    public string $estadoTicket;
    public string $urlVentaExterna;

    private PDO $conexion;

    public function __construct(PDO $db)
    {
        $this->conexion = $db;
    }

    public function obtenerProximas(): array
    {
        $stmt = $this->conexion->query(
            "SELECT ft.*, t.nombreTour 
             FROM fechas_Tour ft
             LEFT JOIN tours t ON ft.tourId = t.id
             WHERE t.activo = 1
             ORDER BY ft.fechaHora ASC"
        );
        return $stmt->fetchAll();
    }

    public function verificarDisponibilidad(int $fechaId): string
    {
        $stmt = $this->conexion->prepare(
            "SELECT estadoTicket FROM fechas_tour WHERE id = :id"
        );
        $stmt->execute([':id' => $fechaId]);
        $row = $stmt->fetch();
        return $row ? $row['estadoTicket'] : 'desconocido';
    }
}