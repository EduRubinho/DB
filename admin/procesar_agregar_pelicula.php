<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login_admin.php');
    exit;
}

try {
    $conexion = new PDO('mysql:host=127.0.0.1:3307;dbname=cineplanet','root','');
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Subida de imagen
    $ruta_imagen = '';
    if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
        $nombre_tmp = $_FILES['portada']['tmp_name'];
        $nombre_archivo = basename($_FILES['portada']['name']);
        $ruta_destino = 'portadas/' . $nombre_archivo;
        move_uploaded_file($nombre_tmp, $ruta_destino);
        $ruta_imagen = $ruta_destino;
    }

    // Insertar película
    $sql = "INSERT INTO PELICULA (titulo, genero, descripcion, duracion, clasificacion, idioma, portada)
            VALUES (:titulo, :genero, :descripcion, :duracion, :clasificacion, :idioma, :portada)";
    
    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        ':titulo' => $_POST['titulo'],
        ':genero' => $_POST['genero'],
        ':descripcion' => $_POST['descripcion'],
        ':duracion' => $_POST['duracion'],
        ':clasificacion' => $_POST['clasificacion'],
        ':idioma' => $_POST['idioma'],
        ':portada' => $ruta_imagen
    ]);

    echo "✅ Película agregada correctamente.";
    echo "<br><a href='agregar_pelicula.php'>Agregar otra</a>";
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>