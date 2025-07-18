<?php
require_once __DIR__ . '/../../../config/session.php';
if (!isset($_SESSION['admin'])) {
    header('Location: ../login_admin.php');
    exit;
}

require_once __DIR__ . '/../../../Controlador/admin/FuncionControlador.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$controlador = new FuncionControlador();
$funcion = $controlador->obtenerPorId($id);

if (!$funcion) {
    $_SESSION['errores'] = 'Función no encontrada';
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Función - Admin</title>
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
                <li><a href="../pelicula/index.php"><i class="fas fa-film"></i> Películas</a></li>
                <li class="active"><a href="index.php"><i class="fas fa-calendar-alt"></i> Funciones</a></li>
                <li><a href="../dulceria/index.php"><i class="fas fa-candy-cane"></i> Dulcería</a></li>
                <li><a href="../boleta/index.php"><i class="fas fa-ticket-alt"></i> Boletas</a></li>
                <li><a href="../../../Vista/web/admin/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="content-header">
                <h1>📅 Ver Función</h1>
                <div>
                    <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
                    <a href="actualizar.php?id=<?php echo $funcion['id']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Editar</a>
                </div>
            </header>

            <div class="view-container">
                <div class="info-card">
                    <h2>Detalles de la Función</h2>
                    
                    <div class="info-grid">
                        <div class="info-item">
                            <strong>ID:</strong>
                            <span><?php echo $funcion['id']; ?></span>
                        </div>
                        
                        <div class="info-item">
                            <strong>Película:</strong>
                            <span><?php echo htmlspecialchars($funcion['pelicula'] ?? 'N/A'); ?></span>
                        </div>
                        
                        <div class="info-item">
                            <strong>Sala:</strong>
                            <span>Sala <?php echo $funcion['sala'] ?? 'N/A'; ?></span>
                        </div>
                        
                        <div class="info-item">
                            <strong>Fecha:</strong>
                            <span><?php echo date('d/m/Y', strtotime($funcion['fecha'])); ?></span>
                        </div>
                        
                        <div class="info-item">
                            <strong>Hora:</strong>
                            <span><?php echo date('H:i', strtotime($funcion['hora'])); ?></span>
                        </div>
                        
                        <div class="info-item">
                            <strong>Precio:</strong>
                            <span>S/ <?php echo number_format($funcion['precio'], 2); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        .view-container { padding: 20px; }
        .info-card { background: white; border-radius: 8px; padding: 30px; }
        .info-card h2 { margin: 0 0 20px 0; color: #2c3e50; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .info-item { display: flex; justify-content: space-between; padding: 10px; background: #f8f9fa; border-radius: 4px; }
        .info-item strong { color: #2c3e50; }
        @media (max-width: 768px) { .info-grid { grid-template-columns: 1fr; } }
    </style>
</body>
</html>