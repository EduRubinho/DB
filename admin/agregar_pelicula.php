<?php
session_start();
// Verifica si es admin (puedes validar con un rol más adelante)
if (!isset($_SESSION['admin'])) {
    header('Location: login_admin.php');
    exit;
}
?>

<h2>Agregar Nueva Película</h2>

<form action="procesar_agregar_pelicula.php" method="POST" enctype="multipart/form-data">
    <label>Título:</label>
    <input type="text" name="titulo" required><br>

    <label>Género:</label>
    <input type="text" name="genero" required><br>

    <label>Descripción:</label>
    <textarea name="descripcion"></textarea><br>

    <label>Duración (hh:mm:ss):</label>
    <input type="time" name="duracion" required><br>

    <label>Clasificación (APT, +14, +18):</label>
    <input type="text" name="clasificacion" required><br>

    <label>Idioma:</label>
    <input type="text" name="idioma"><br>

    <label>Portada (imagen):</label>
    <input type="file" name="portada" accept="image/*"><br><br>

    <button type="submit">Agregar Película</button>
</form>