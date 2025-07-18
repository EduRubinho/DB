<?php
require_once __DIR__ . '/../../../config/session.php';
if (!isset($_SESSION['admin'])) {
    header('Location: ../login_admin.php');
    exit;
}

require_once __DIR__ . '/../../../Controlador/admin/PeliculaControlador.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$controlador = new PeliculaControlador();
$pelicula = $controlador->obtenerPorId($id);

if (!$pelicula) {
    $_SESSION['errores'] = 'Película no encontrada';
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Película - Admin</title>
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
                <h1>🗑️ Eliminar Película</h1>
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </header>

            <div class="delete-container">
                <div class="delete-card">
                    <div class="warning-header">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h2>⚠️ Confirmar Eliminación</h2>
                        <p>¿Estás seguro de eliminar esta película?</p>
                        <strong>Esta acción no se puede deshacer.</strong>
                    </div>

                    <div class="movie-summary">
                        <h3>Película a eliminar:</h3>
                        
                        <div class="summary-content">
                            <?php if (!empty($pelicula['imagen'])): ?>
                                <img src="../../../uploads/peliculas/<?php echo $pelicula['imagen']; ?>" 
                                     alt="<?php echo htmlspecialchars($pelicula['titulo']); ?>" 
                                     class="summary-image">
                            <?php endif; ?>
                            
                            <div class="summary-details">
                                <p><strong>ID:</strong> <?php echo $pelicula['id']; ?></p>
                                <p><strong>Título:</strong> <?php echo htmlspecialchars($pelicula['titulo']); ?></p>
                                <p><strong>Género:</strong> <?php echo htmlspecialchars($pelicula['genero']); ?></p>
                                <p><strong>Duración:</strong> <?php echo $pelicula['duracion']; ?> minutos</p>
                                <p><strong>Estado:</strong> <?php echo ucfirst($pelicula['estado']); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="delete-actions">
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                        
                        <form method="POST" action="../../../Controlador/admin/PeliculaControlador.php" style="display: inline;">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="id" value="<?php echo $pelicula['id']; ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Confirmas eliminar esta película?')">
                                <i class="fas fa-trash"></i> Eliminar Película
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        .delete-container { padding: 20px; display: flex; justify-content: center; }
        .delete-card { background: white; border-radius: 8px; max-width: 600px; width: 100%; }
        .warning-header { background: #e74c3c; color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .warning-header i { font-size: 48px; margin-bottom: 15px; }
        .warning-header h2 { margin: 0 0 10px 0; }
        .warning-header p { margin: 5px 0; opacity: 0.9; }
        .movie-summary { padding: 30px; }
        .movie-summary h3 { color: #2c3e50; margin-bottom: 20px; }
        .summary-content { display: flex; gap: 20px; background: #f8f9fa; padding: 20px; border-radius: 8px; }
        .summary-image { width: 100px; height: 150px; object-fit: cover; border-radius: 4px; }
        .summary-details p { margin: 8px 0; color: #333; }
        .summary-details strong { color: #2c3e50; }
        .delete-actions { padding: 30px; text-align: center; border-top: 1px solid #eee; }
        .btn { padding: 12px 20px; margin: 0 10px; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-danger { background: #e74c3c; color: white; }
        @media (max-width: 768px) { 
            .summary-content { flex-direction: column; text-align: center; }
            .delete-actions { padding: 20px; }
        }
    </style>
</body>
</html>