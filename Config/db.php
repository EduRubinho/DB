<?php
function conectarBD() {
    try {
        // Asegúrate de que estos datos sean correctos
        $conexion = new PDO('mysql:host=127.0.0.1:3307;dbname=cineplanet', 'root', '');
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    } catch (PDOException $e) {
        // Registrar el error
        error_log('Error de conexión: ' . $e->getMessage());
        return null;
    }
}
?>
