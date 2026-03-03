<?php

$host = "localhost";
$dbname = "cms_sabrina_carpenter";
$username = "root";
$password = "";

try {

    $dsn = "mysql:host=" . $host . ";dbname=" . $dbname . ";charset=utf8mb4";
    $conexion = new PDO($dsn, $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Error crítico de conexión a la base de datos: " . $e->getMessage());
}
?>