<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login_admin.php');
    exit;
}
?>

<h2>Bienvenido, <?php echo $_SESSION['admin']; ?></h2>
<a href="agregar_pelicula.php">➕ Agregar Película</a><br>
<a href="logout_admin.php">Cerrar sesión</a>