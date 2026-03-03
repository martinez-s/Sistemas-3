<?php
require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $pais = htmlspecialchars(trim($_POST["pais"]));

    if (!empty($email) && !empty($pais) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        try {

            $sql = "INSERT INTO suscriptores (email, pais) VALUES (:email, :pais)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':pais', $pais);
            $stmt->execute();

            echo "<div style='text-align: center; margin-top: 50px; font-family: sans-serif;'>";
            echo "<h2>¡Gracias por unirte a la comunidad!</h2>";
            echo "<p>Tu correo ha sido registrado exitosamente desde " . $pais . ".</p>";
            echo "<a href='index.php' style='color: #d1495b; text-decoration: none;'>Volver al inicio</a>";
            echo "</div>";

        } catch (PDOException $e) {

            if ($e->getCode() == 23000) {
                echo "<div style='text-align: center; margin-top: 50px; font-family: sans-serif;'>";
                echo "<h2>Ya estás suscrito</h2>";
                echo "<p>El correo que ingresaste ya forma parte de nuestra base de datos.</p>";
                echo "<a href='index.php' style='color: #d1495b; text-decoration: none;'>Volver al inicio</a>";
                echo "</div>";
            } else {
                echo "Error al registrar la suscripción: " . $e->getMessage();
            }
        }

    } else {

        echo "<div style='text-align: center; margin-top: 50px; font-family: sans-serif;'>";
        echo "<h2>Datos inválidos</h2>";
        echo "<p>Por favor, asegúrate de ingresar un correo válido y seleccionar tu país.</p>";
        echo "<a href='index.php' style='color: #d1495b; text-decoration: none;'>Volver e intentar de nuevo</a>";
        echo "</div>";
    }
} else {

    header("Location: index.php");
    exit();
}
?>