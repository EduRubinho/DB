
<?php
/**
 * procesar_registro_admin.php
 * Procesa el registro de un nuevo administrador.
 * - Valida datos y usa conexión centralizada.
 * - Buenas prácticas y documentación.
 */
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $errores = '';

    if (empty($usuario) || empty($nombre) || empty($password)) {
        $errores = 'Por favor, complete todos los campos.';
    } else {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        try {
            // Usar la conexión centralizada
            global $conexion;
            $sql = "INSERT INTO ADMIN (usuario, password, nombre_completo) VALUES (:usuario, :password, :nombre)";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                ':usuario' => $usuario,
                ':password' => $passwordHash,
                ':nombre' => $nombre
            ]);

            echo "✅ Administrador registrado correctamente. <a href='login_admin.php'>Iniciar sesión</a>";
        } catch (PDOException $e) {
            $errores = "❌ Error: " . htmlspecialchars($e->getMessage());
        }
    }
    if (!empty($errores)) {
        echo '<div class="error">' . $errores . '</div>';
    }
}
// Fin de archivo
?>