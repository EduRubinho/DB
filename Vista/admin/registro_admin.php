<?php
session_start();
$errores = $_SESSION['errores'] ?? '';
$mensajes = $_SESSION['mensajes'] ?? '';
unset($_SESSION['errores'], $_SESSION['mensajes']);
?>

<h2>Registrar nuevo administrador</h2>

<form action="../../Controlador/admin/AdminControlador.php" method="POST">
    <input type="hidden" name="accion" value="registrar">
    <label>Nombre completo:</label><br>
    <input type="text" name="nombre" required><br>
    <label>Usuario:</label><br>
    <input type="text" name="usuario" required><br>
    <label>Contraseña:</label><br>
    <input type="password" name="password" required><br><br>
    <button type="submit">Registrar</button>
</form>

<?php if ($errores): ?>
    <div style="color:red"><?= $errores ?></div>
<?php endif; ?>
<?php if ($mensajes): ?>
    <div style="color:green"><?= $mensajes ?></div>
<?php endif; ?>
