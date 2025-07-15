<?php
$pelicula = $pelicula ?? []; // Asegurar que la variable existe
if (!defined('ROOT_PATH')) {
    header("Location: /DB/Controlador/admin/PeliculaControlador.php?accion=listar");
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Película</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Editar Película</h1>
        <!-- Formulario corregido -->
        <form action="/DB/Controlador/admin/PeliculaControlador.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="accion" value="editar">
            <input type="hidden" name="id_pelicula" value="<?= $pelicula['id_pelicula'] ?>">
            <input type="hidden" name="imagen_actual" value="<?= $pelicula['imagen'] ?>">
            
            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" value="<?= $pelicula['titulo'] ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3" required><?= $pelicula['descripcion'] ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Género</label>
                    <input type="text" name="genero" class="form-control" value="<?= $pelicula['genero'] ?>" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Duración (minutos)</label>
                    <input type="number" name="duracion" class="form-control" value="<?= $pelicula['duracion'] ?>" required>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Director</label>
                    <input type="text" name="director" class="form-control" value="<?= $pelicula['director'] ?>" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Fecha de Estreno</label>
                    <input type="date" name="fecha_estreno" class="form-control" value="<?= $pelicula['fecha_estreno'] ?>" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Imagen Actual</label><br>
                <img src="../../assets/img/<?= $pelicula['imagen'] ?>" alt="Póster" height="150" class="mb-2">
                <label class="form-label">Nueva Imagen (opcional)</label>
                <input type="file" name="imagen" class="form-control" accept="image/*">
            </div>
            
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="/DB/Controlador/admin/PeliculaControlador.php?accion=listar" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>