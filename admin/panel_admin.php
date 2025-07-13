<?php
/**
 * panel_admin.php
 * Panel principal del administrador.
 * - Requiere sesión de admin activa.
 * - Muestra opciones administrativas.
 */
require_once 'db.php';
require_once 'auth.php';
require_admin();
?>

<h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['admin']); ?></h2>
<a href="agregar_pelicula.php">➕ Agregar Película</a><br>
<a href="logout_admin.php">Cerrar sesión</a>