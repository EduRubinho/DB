
<?php
/**
 * auth.php
 * Funciones de autenticación para el panel de administración.
 * - Inicia sesión si no está iniciada.
 * - Proporciona función para requerir autenticación de admin.
 * - Buenas prácticas y documentación.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Requiere que el usuario esté autenticado como admin.
 * Si no lo está, redirige al login y detiene la ejecución.
 *
 * Uso: Llamar a require_admin() al inicio de scripts protegidos.
 */
function require_admin() {
    if (empty($_SESSION['admin'])) {
        header('Location: login_admin.php');
        exit;
    }
}

// Fin de archivo
?>