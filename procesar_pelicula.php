
<?php
// Conexión a la base de datos
try {
    $conexion = new PDO('mysql:host=127.0.0.1:3307;dbname=cineplanet', 'root', '');
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para obtener todas las películas
    $sql = "SELECT * FROM PELICULA";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p>Error de conexión: " . $e->getMessage() . "</p>";
    $peliculas = [];
}

// Mostrar las películas en formato HTML (puedes incluir este archivo en pelicula.php)
foreach ($peliculas as $p) {
    echo '<div class="pelicula">';
    if (!empty($p['portada'])) {
        echo '<img src="' . htmlspecialchars($p['portada']) . '" alt="' . htmlspecialchars($p['titulo']) . '" />';
    }
    echo '<h4>' . htmlspecialchars($p['titulo']) . '</h4>';
    echo '<p>';
    echo htmlspecialchars($p['genero']);
    if (!empty($p['duracion'])) {
        echo ', ' . htmlspecialchars($p['duracion']);
    }
    if (!empty($p['clasificacion'])) {
        echo ', ' . htmlspecialchars($p['clasificacion']);
    }
    echo '.</p>';
    if (!empty($p['descripcion'])) {
        echo '<small>' . htmlspecialchars($p['descripcion']) . '</small>';
    }
    echo '</div>';
}
?>
