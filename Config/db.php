<?php
function conectarBD() {
    try {
        $conexion = new PDO('mysql:host=127.0.0.1:3307;dbname=cineplanet', 'root', 'root');
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    } catch (PDOException $e) {
        die('Error de conexión: ' . $e->getMessage());
    }
}
