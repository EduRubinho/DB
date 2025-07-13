
<?php
/**
 * procesar_login_admin.php
 * Procesa el inicio de sesión del administrador.
 * - Valida credenciales y usa variable de sesión.
 * - Buenas prácticas y documentación.
 */
require_once 'db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $errores = '';

    if (empty($usuario) || empty($password)) {
        $errores = 'Por favor, complete todos los campos.';
    } else {
        try {
            $conexion = new PDO('mysql:host=127.0.0.1:3307;dbname=cineplanet', 'root', '');
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conexion->prepare("SELECT * FROM ADMIN WHERE usuario = :usuario");
            $stmt->execute([':usuario' => $usuario]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin['password'])) {
                // Guardar usuario admin en sesión
                $_SESSION['admin'] = $admin['usuario'];
                header('Location: panel_admin.php');
                exit;
            } else {
                $errores = "❌ Usuario o contraseña incorrectos.";
            }
        } catch (PDOException $e) {
            $errores = "❌ Error: " . htmlspecialchars($e->getMessage());
        }
    }
    // Mostrar errores si existen
    if (!empty($errores)) {
        echo '<div class="error">' . $errores . '</div>';
    }
}
// Fin de archivo
?>