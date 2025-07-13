<?php
/**
 * db.php
 * Maneja la conexión a la base de datos usando PDO para el panel de administración.
 * Si hay un error, detiene la ejecución y muestra el mensaje.
 */

$host = '127.0.0.1:3307';
$db = 'cineplanet';
$user = 'root';
$pass = '';

try {
    $conexion = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>