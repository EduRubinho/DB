<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
?>

<h1>Bienvenido, <?= $_SESSION['admin']['nombre_completo'] ?></h1>
<a href="logout.php">Cerrar sesión</a>
