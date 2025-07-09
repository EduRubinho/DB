<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    try {
        $conexion = new PDO('mysql:host=127.0.0.1:3307;dbname=cineplanet', 'root', '');
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conexion->prepare("SELECT * FROM ADMIN WHERE usuario = :usuario");
        $stmt->execute([':usuario' => $usuario]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = $admin['usuario'];
            header('Location: panel_admin.php');
            exit;
        } else {
            echo "❌ Usuario o contraseña incorrectos.";
        }
    } catch (PDOException $e) {
        echo "❌ Error: " . $e->getMessage();
    }
}
?>