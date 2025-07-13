<?php
session_start();
$errores = $_SESSION['errores'] ?? '';
unset($_SESSION['errores']);
?>

<h2>Iniciar sesión como administrador</h2>

<form action="../../Controlador/admin/AdminControlador.php" method="POST">
    <input type="hidden" name="accion" value="login">
    <label>Usuario:</label><br>
    <input type="text" name="usuario" required><br>
    <label>Contraseña:</label><br>
    <input type="password" name="password" required><br><br>
    <button type="submit">Ingresar</button>
</form>

<?php if ($errores): ?>
    <div style="color:red"><?= $errores ?></div>
<?php endif; ?>
