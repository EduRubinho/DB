<?php
require_once __DIR__ . '/../../../Config/session.php';
if (!isset($_SESSION['admin'])) {
    header('Location: ../login_admin.php');
    exit;
}

require_once __DIR__ . '/../../../Controlador/admin/BoletaControlador.php';

$controlador = new BoletaControlador();

// Paginación - valores por defecto seguros
$page = max(1, (int)($_GET['page'] ?? 1));
$per_page = 15;

// Filtro por fecha
$fecha_inicio = $_GET['fecha_inicio'] ?? '';
$fecha_fin = $_GET['fecha_fin'] ?? '';

try {
    if ($fecha_inicio && $fecha_fin) {
        $boletas = $controlador->buscarPorFecha($fecha_inicio, $fecha_fin);
    } else {
        $boletas = $controlador->obtenerTodas($page, $per_page);
    }
    
    $total_boletas = $controlador->contarTotal();
    $estadisticas = $controlador->obtenerEstadisticas();
} catch (Exception $e) {
    $boletas = [];
    $total_boletas = 0;
    $estadisticas = [
        'hoy' => ['total' => 0, 'ingresos' => 0],
        'mes' => ['total' => 0, 'ingresos' => 0]
    ];
    $_SESSION['errores'] = 'Error al cargar boletas: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boletas - Admin</title>
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
                <li><a href="../funcion/index.php"><i class="fas fa-calendar-alt"></i> Funciones</a></li>
                <li><a href="../dulceria/index.php"><i class="fas fa-candy-cane"></i> Dulcería</a></li>
                <li class="active"><a href="index.php"><i class="fas fa-ticket-alt"></i> Boletas</a></li>
                <li><a href="../../../Vista/web/admin/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="content-header">
                <h1>🎫 Gestión de Boletas</h1>
                <div class="header-stats">
                    <span class="stat-badge success">💰 S/ <?php echo number_format($estadisticas['mes']['ingresos'], 2); ?> este mes</span>
                    <span class="stat-badge info">📊 <?php echo $total_boletas; ?> boletas totales</span>
                </div>
            </header>

            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['errores'])): ?>
                <div class="alert alert-error"><?php echo $_SESSION['errores']; unset($_SESSION['errores']); ?></div>
            <?php endif; ?>

            <!-- Resumen de estadísticas -->
            <div class="stats-summary">
                <div class="stat-box">
                    <i class="fas fa-calendar-day"></i>
                    <div class="stat-info">
                        <h3><?php echo $estadisticas['hoy']['total']; ?></h3>
                        <p>Ventas Hoy</p>
                        <span>S/ <?php echo number_format($estadisticas['hoy']['ingresos'], 2); ?></span>
                    </div>
                </div>
                <div class="stat-box">
                    <i class="fas fa-calendar-month"></i>
                    <div class="stat-info">
                        <h3><?php echo $estadisticas['mes']['total']; ?></h3>
                        <p>Ventas Este Mes</p>
                        <span>S/ <?php echo number_format($estadisticas['mes']['ingresos'], 2); ?></span>
                    </div>
                </div>
                <div class="stat-box">
                    <i class="fas fa-chart-line"></i>
                    <div class="stat-info">
                        <h3><?php 
                        $promedio = $estadisticas['mes']['total'] > 0 ? $estadisticas['mes']['ingresos'] / $estadisticas['mes']['total'] : 0;
                        echo number_format($promedio, 2); 
                        ?></h3>
                        <p>Promedio por Boleta</p>
                        <span>S/ por venta</span>
                    </div>
                </div>
            </div>

            <!-- Tabla de boletas simplificada -->
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($boletas)): ?>
                            <tr>
                                <td colspan="5" style="text-align:center; padding:40px;">
                                    <i class="fas fa-ticket-alt" style="font-size:48px; color:#ccc;"></i>
                                    <p>No hay boletas registradas</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($boletas as $boleta): ?>
                                <tr>
                                    <td>
                                        <strong>#<?php echo str_pad($boleta['id'], 4, '0', STR_PAD_LEFT); ?></strong>
                                    </td>
                                    <td>
                                        <div class="cliente-info">
                                            <strong><?php echo htmlspecialchars($boleta['cliente_nombre']); ?></strong>
                                            <?php if (!empty($boleta['cliente_apellido'])): ?>
                                                <?php echo htmlspecialchars($boleta['cliente_apellido']); ?>
                                            <?php endif; ?>
                                            <br>
                                            <small style="color: #666;"><?php echo htmlspecialchars($boleta['cliente_correo']); ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fecha-info">
                                            📅 <?php echo date('d/m/Y', strtotime($boleta['fecha'])); ?>
                                            <br>
                                            <small>🕐 <?php echo date('H:i', strtotime($boleta['fecha'])); ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <strong style="color: #27ae60; font-size: 1.1em;">
                                            S/ <?php echo number_format($boleta['total'], 2); ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <a href="consultar.php?id=<?php echo $boleta['id']; ?>" class="btn btn-sm btn-info" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button onclick="eliminarBoleta(<?php echo $boleta['id']; ?>)" class="btn btn-sm btn-danger" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="info-footer">
                <p><i class="fas fa-info-circle"></i> Mostrando <?php echo count($boletas); ?> boletas de un total de <?php echo $total_boletas; ?></p>
            </div>
        </main>
    </div>

    <!-- Formulario oculto para eliminar -->
    <form id="eliminarForm" method="POST" action="../../../Controlador/admin/BoletaControlador.php" style="display: none;">
        <input type="hidden" name="accion" value="eliminar">
        <input type="hidden" name="id" id="eliminarId">
    </form>

    <style>
        .stats-summary { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 20px; }
        .stat-box { background: white; padding: 20px; border-radius: 8px; display: flex; align-items: center; gap: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .stat-box i { font-size: 2rem; color: #3498db; }
        .stat-info h3 { margin: 0; font-size: 1.5rem; color: #2c3e50; }
        .stat-info p { margin: 5px 0; color: #666; }
        .stat-info span { font-size: 0.9rem; color: #27ae60; font-weight: bold; }
        
        .table-container { background: white; margin: 20px; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background: #2c3e50; color: white; padding: 15px 12px; text-align: left; font-weight: 600; }
        .data-table td { padding: 12px; border-bottom: 1px solid #eee; vertical-align: top; }
        .data-table tr:hover { background: #f9f9f9; }
        
        .cliente-info { line-height: 1.4; }
        .fecha-info { line-height: 1.4; }
        
        .btn-sm { padding: 6px 10px; margin: 0 2px; text-decoration: none; border-radius: 4px; font-size: 12px; display: inline-block; border: none; cursor: pointer; }
        .btn-info { background: #17a2b8; color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .btn:hover { opacity: 0.8; transform: translateY(-1px); }
        
        .header-stats { display: flex; gap: 10px; }
        .stat-badge { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .stat-badge.success { background: #e8f5e8; color: #388e3c; }
        .stat-badge.info { background: #e3f2fd; color: #1976d2; }
        
        .info-footer { text-align: center; padding: 20px; color: #666; }
        .alert { margin: 20px; padding: 15px; border-radius: 8px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
    </style>

    <script>
        function eliminarBoleta(id) {
            if (confirm('¿Estás seguro de eliminar esta boleta? Esta acción no se puede deshacer.')) {
                document.getElementById('eliminarId').value = id;
                document.getElementById('eliminarForm').submit();
            }
        }
    </script>
</body>
</html>