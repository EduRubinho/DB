<?php
require_once __DIR__ . '/../../../config/session.php';
if (!isset($_SESSION['admin'])) {
    header('Location: ../login_admin.php');
    exit;
}

require_once __DIR__ . '/../../../Controlador/admin/FuncionControlador.php';
$controlador = new FuncionControlador();
$funciones = $controlador->obtenerTodas();

// Debug temporal
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Funciones - Admin</title>
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
                <h1>📅 Gestión de Funciones</h1>
                <a href="crear.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nueva Función
                </a>
            </header>

            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['errores'])): ?>
                <div class="alert alert-error"><?php echo $_SESSION['errores']; unset($_SESSION['errores']); ?></div>
            <?php endif; ?>

            

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Película</th>
                            <th>Sala</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($funciones)): ?>
                            <tr>
                                <td colspan="7" style="text-align:center; padding:40px;">
                                    <i class="fas fa-calendar-times" style="font-size:48px; color:#ccc;"></i>
                                    <p>No hay funciones registradas</p>
                                    <a href="crear.php" class="btn btn-primary">Crear primera función</a>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($funciones as $funcion): ?>
                                <tr>
                                    <td><?php echo $funcion['id']; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($funcion['pelicula'] ?? 'Sin película'); ?></strong>
                                        <?php if (!empty($funcion['formato'])): ?>
                                            <br><small style="color: #666;"><?php echo $funcion['formato']; ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        Sala <?php echo $funcion['sala'] ?? 'N/A'; ?>
                                        <?php if (!empty($funcion['cine'])): ?>
                                            <br><small style="color: #666;"><?php echo $funcion['cine']; ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo date('d/m/Y', strtotime($funcion['fecha'])); ?></td>
                                    <td><?php echo date('H:i', strtotime($funcion['hora'])); ?></td>
                                    <td>
                                        <strong style="color: #27ae60;">S/ <?php echo number_format($funcion['precio'], 2); ?></strong>
                                    </td>
                                    <td>
                                        <a href="consultar.php?id=<?php echo $funcion['id']; ?>" class="btn btn-sm btn-info" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="actualizar.php?id=<?php echo $funcion['id']; ?>" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="eliminar.php?id=<?php echo $funcion['id']; ?>" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Eliminar esta función?')">
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
        .table-container { background: white; margin: 20px; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background: #2c3e50; color: white; padding: 15px 12px; text-align: left; font-weight: 600; }
        .data-table td { padding: 12px; border-bottom: 1px solid #eee; vertical-align: top; }
        .data-table tr:hover { background: #f9f9f9; }
        .data-table tr:nth-child(even) { background: #f8f9fa; }
        .btn-sm { padding: 6px 10px; margin: 0 2px; text-decoration: none; border-radius: 4px; font-size: 12px; display: inline-block; }
        .btn-info { background: #17a2b8; color: white; }
        .btn-warning { background: #ffc107; color: #212529; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-sm:hover { opacity: 0.8; transform: translateY(-1px); }
        .alert { margin: 20px; padding: 15px; border-radius: 8px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
        .debug-info { border-left: 4px solid #007bff; }
    </style>
</body>
</html>