<?php
/**
 * agregar_pelicula.php
 * Formulario para agregar una nueva película (solo admin).
 * - Requiere sesión de admin activa.
 * - Buenas prácticas y documentación.
 */
require_once 'db.php';
require_once 'auth.php';
require_admin();
?>

<h2>Agregar Nueva Película</h2>

<form action="funciones_admin.php" method="POST" enctype="multipart/form-data">
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

<a href="logout_admin.php">Cerrar sesión</a>