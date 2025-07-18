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
    <title>Eliminar Función - Admin</title>
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
                <h1>🗑️ Eliminar Función</h1>
                <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
            </header>

            <div class="delete-container">
                <div class="delete-card">
                    <div class="warning-header">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h2>⚠️ Confirmar Eliminación</h2>
                        <p>¿Estás seguro de eliminar esta función?</p>
                    </div>

                    <div class="function-summary">
                        <h3>Función a eliminar:</h3>
                        <p><strong>ID:</strong> <?php echo $funcion['id']; ?></p>
                        <p><strong>Película:</strong> <?php echo htmlspecialchars($funcion['pelicula'] ?? 'N/A'); ?></p>
                        <p><strong>Sala:</strong> Sala <?php echo $funcion['sala'] ?? 'N/A'; ?></p>
                        <p><strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($funcion['fecha'])); ?></p>
                        <p><strong>Hora:</strong> <?php echo date('H:i', strtotime($funcion['hora'])); ?></p>
                        <p><strong>Precio:</strong> S/ <?php echo number_format($funcion['precio'], 2); ?></p>
                    </div>

                    <div class="delete-actions">
                        <a href="index.php" class="btn btn-secondary"><i class="fas fa-times"></i> Cancelar</a>
                        
                        <form method="POST" action="../../../Controlador/admin/FuncionControlador.php" style="display: inline;">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="id" value="<?php echo $funcion['id']; ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Confirmas eliminar esta función?')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        .delete-container { padding: 20px; display: flex; justify-content: center; }
        .delete-card { background: white; border-radius: 8px; max-width: 500px; width: 100%; }
        .warning-header { background: #e74c3c; color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .warning-header i { font-size: 48px; margin-bottom: 15px; }
        .warning-header h2 { margin: 0 0 10px 0; }
        .function-summary { padding: 30px; }
        .function-summary h3 { color: #2c3e50; margin-bottom: 15px; }
        .function-summary p { margin: 8px 0; color: #333; }
        .delete-actions { padding: 30px; text-align: center; border-top: 1px solid #eee; }
        .btn { padding: 12px 20px; margin: 0 10px; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-danger { background: #e74c3c; color: white; }
    </style>
</body>
</html>