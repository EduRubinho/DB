

<?php
session_start();
$mensaje = $_SESSION['mensaje'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['mensaje'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Películas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Películas</h1>
        
        <?php if ($mensaje): ?>
            <div class="alert alert-success"><?= $mensaje ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <a href="crear.php" class="btn btn-primary mb-3">Nueva Película</a>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Género</th>
                    <th>Duración</th>
                    <th>Director</th>
                    <th>Estreno</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
    <?php  if (!empty($peliculas) && is_array($peliculas)): ?>
        <?php foreach ($peliculas as $pelicula): ?>
            <tr>
                <td><?= $pelicula['id_pelicula'] ?></td>
                <td><?= $pelicula['titulo'] ?></td>
                <td><?= $pelicula['genero'] ?></td>
                <td><?= $pelicula['duracion'] ?> min</td>
                <td><?= $pelicula['director'] ?></td>
                <td><?= date('d/m/Y', strtotime($pelicula['fecha_estreno'])) ?></td>
                <td>
                    <a href="/DB/Controlador/admin/PeliculaControlador.php?accion=editar&id_pelicula=<?= $pelicula['id_pelicula'] ?>" 
                        class="btn btn-sm btn-warning">Editar</a>
                    <a href="/DB/Controlador/admin/PeliculaControlador.php?accion=eliminar&id_pelicula=<?= $pelicula['id_pelicula'] ?>" 
                        class="btn btn-sm btn-danger" 
                        onclick="return confirm('¿Eliminar esta película?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="7" class="text-center">No se encontraron películas</td>
        </tr>
    <?php endif; ?>
</tbody>
        </table>
    </div>
</body>
</html>