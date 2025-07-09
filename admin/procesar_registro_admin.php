<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $nombre = $_POST['nombre'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encripta seguro

    try {
        $conexion = new PDO('mysql:host=127.0.0.1:3307;dbname=cineplanet', 'root', '');
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO ADMIN (usuario, password, nombre_completo) VALUES (:usuario, :password, :nombre)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':usuario' => $usuario,
            ':password' => $password,
            ':nombre' => $nombre
        ]);

        echo "✅ Administrador registrado correctamente. <a href='login_admin.php'>Iniciar sesión</a>";
    } catch (PDOException $e) {
        echo "❌ Error: " . $e->getMessage();
    }
}
?>