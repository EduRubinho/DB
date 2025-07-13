<?php
/**
 * logout_admin.php
 * Cierra la sesión del administrador de forma segura.
 * - Destruye la sesión y redirige al login.
 */
session_start();
session_unset();
session_destroy();
header('Location: login_admin.php');
exit;
?>