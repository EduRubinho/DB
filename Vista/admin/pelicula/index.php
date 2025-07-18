<?php
require_once __DIR__ . '/../../../config/session.php';
if (!isset($_SESSION['admin'])) {
    header('Location: ../login_admin.php');
    exit;
}

require_once __DIR__ . '/../../../Controlador/admin/PeliculaControlador.php';
$controlador = new PeliculaControlador();
$peliculas = $controlador->obtenerTodas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Películas - Admin</title>
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>🎬 Admin</h2>
                <p>Cineplanet</p>
            </div>
            <ul class="sidebar-menu">
                <li><a href="../../../Vista/web/admin/inicioadmin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="../cliente/index.php"><i class="fas fa-users"></i> Clientes</a></li>
                <li class="active"><a href="index.php"><i class="fas fa-film"></i> Películas</a></li>
                <li><a href="../funcion/index.php"><i class="fas fa-calendar-alt"></i> Funciones</a></li>
                <li><a href="../dulceria/index.php"><i class="fas fa-candy-cane"></i> Dulcería</a></li>
                <li><a href="../boleta/index.php"><i class="fas fa-ticket-alt"></i> Boletas</a></li>
                <li><a href="../../../Vista/web/admin/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="content-header">
                <h1>🎬 Gestión de Películas</h1>
                <a href="crear.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nueva Película
                </a>
            </header>

            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?>
                </div>
            <?php endif; ?>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Duración</th>
                            <th>Clasificación</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($peliculas)): ?>
                            <tr>
                                <td colspan="6" style="text-align:center; padding:40px;">
                                    <i class="fas fa-inbox" style="font-size:48px; color:#ccc;"></i>
                                    <p>No hay películas registradas</p>
                                    <a href="crear.php" class="btn btn-primary">Agregar primera película</a>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($peliculas as $pelicula): ?>
                                <tr>
                                    <td><?php echo $pelicula['id']; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($pelicula['titulo']); ?></strong>
                                        <br><small><?php echo htmlspecialchars($pelicula['genero']); ?></small>
                                    </td>
                                    <td><?php echo $pelicula['duracion']; ?> min</td>
                                    <td>
                                        <span class="badge"><?php echo $pelicula['clasificacion']; ?></span>
                                    </td>
                                    <td>
                                        <span class="status <?php echo $pelicula['estado']; ?>">
                                            <?php echo ucfirst($pelicula['estado']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="consultar.php?id=<?php echo $pelicula['id']; ?>" class="btn btn-sm btn-info" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="actualizar.php?id=<?php echo $pelicula['id']; ?>" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="eliminar.php?id=<?php echo $pelicula['id']; ?>" class="btn btn-sm btn-danger" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <style>
        .table-container { background: white; margin: 20px; border-radius: 8px; overflow: hidden; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background: #2c3e50; color: white; padding: 12px; text-align: left; }
        .data-table td { padding: 12px; border-bottom: 1px solid #eee; }
        .data-table tr:hover { background: #f9f9f9; }
        .btn-sm { padding: 6px 10px; margin: 0 2px; text-decoration: none; border-radius: 4px; }
        .badge { background: #3498db; color: white; padding: 2px 8px; border-radius: 12px; font-size: 12px; }
        .status.activa { color: #27ae60; font-weight: bold; }
        .status.inactiva { color: #e74c3c; font-weight: bold; }
        .alert { margin: 20px; padding: 15px; border-radius: 8px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</body>
</html>