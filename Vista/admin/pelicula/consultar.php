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
    <title>Ver Película - Admin</title>
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
                <h1>🎬 Ver Película</h1>
                <div>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <a href="actualizar.php?id=<?php echo $pelicula['id']; ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                </div>
            </header>

            <div class="view-container">
                <div class="movie-card">
                    <?php if (!empty($pelicula['imagen'])): ?>
                        <div class="movie-poster">
                            <img src="../../../uploads/peliculas/<?php echo $pelicula['imagen']; ?>" alt="<?php echo htmlspecialchars($pelicula['titulo']); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="movie-info">
                        <h2><?php echo htmlspecialchars($pelicula['titulo']); ?></h2>
                        
                        <div class="info-grid">
                            <div class="info-item">
                                <strong>Duración:</strong>
                                <span><?php echo $pelicula['duracion']; ?> minutos</span>
                            </div>
                            
                            <div class="info-item">
                                <strong>Género:</strong>
                                <span><?php echo htmlspecialchars($pelicula['genero']); ?></span>
                            </div>
                            
                            <div class="info-item">
                                <strong>Clasificación:</strong>
                                <span class="badge"><?php echo $pelicula['clasificacion']; ?></span>
                            </div>
                            
                            <div class="info-item">
                                <strong>Estado:</strong>
                                <span class="status <?php echo $pelicula['estado']; ?>">
                                    <?php echo ucfirst($pelicula['estado']); ?>
                                </span>
                            </div>
                        </div>

                    
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        .view-container { padding: 20px; }
        .movie-card { background: white; border-radius: 8px; overflow: hidden; display: flex; gap: 20px; }
        .movie-poster { flex: 0 0 200px; }
        .movie-poster img { width: 100%; height: 300px; object-fit: cover; }
        .movie-info { flex: 1; padding: 20px; }
        .movie-info h2 { margin: 0 0 20px 0; color: #2c3e50; font-size: 24px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; }
        .info-item { display: flex; justify-content: space-between; padding: 10px; background: #f8f9fa; border-radius: 4px; }
        .info-item strong { color: #2c3e50; }
        .badge { background: #3498db; color: white; padding: 2px 8px; border-radius: 12px; font-size: 12px; }
        .status.activa { color: #27ae60; font-weight: bold; }
        .status.inactiva { color: #e74c3c; font-weight: bold; }
        .synopsis { margin-top: 20px; }
        .synopsis h3 { color: #2c3e50; margin-bottom: 10px; }
        .synopsis p { line-height: 1.6; color: #666; }
        @media (max-width: 768px) { 
            .movie-card { flex-direction: column; }
            .info-grid { grid-template-columns: 1fr; }
        }
    </style>
</body>
</html>