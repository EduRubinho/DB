<?php
/**
 * procesar_agregar_pelicula.php
 * Procesa el alta de una nueva película (solo admin).
 * - Valida datos y protege la subida de archivos.
 * - Buenas prácticas y documentación.
 */
require_once 'db.php';
require_once 'auth.php';
require_admin();

try {
    // Subida de imagen
    $ruta_imagen = '';
    if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
        $nombre_tmp = $_FILES['portada']['tmp_name'];
        $nombre_archivo = basename($_FILES['portada']['name']);
        $ruta_destino = '../img_pelicula/' . $nombre_archivo;
        // Validar tipo de archivo (solo imágenes)
        $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (in_array(mime_content_type($nombre_tmp), $tipos_permitidos)) {
            move_uploaded_file($nombre_tmp, $ruta_destino);
            $ruta_imagen = $ruta_destino;
        } else {
            throw new Exception('Tipo de archivo no permitido.');
        }
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
} catch (Exception $e) {
    echo "❌ Error: " . htmlspecialchars($e->getMessage());
}
?>