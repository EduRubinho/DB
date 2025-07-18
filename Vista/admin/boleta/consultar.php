<?php
require_once __DIR__ . '/../../../Config/session.php';
if (!isset($_SESSION['admin'])) {
    header('Location: ../login_admin.php');
    exit;
}

require_once __DIR__ . '/../../../Controlador/admin/BoletaControlador.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$controlador = new BoletaControlador();
$boleta = $controlador->obtenerPorId($id);

if (!$boleta) {
    $_SESSION['errores'] = 'Boleta no encontrada';
    header('Location: index.php');
    exit;
}

$asientos = $controlador->obtenerAsientosBoleta($id);
$productos = $controlador->obtenerProductosBoleta($id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta #<?php echo str_pad($boleta['id'], 4, '0', STR_PAD_LEFT); ?> - Admin</title>
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
                <h1>🎫 Boleta #<?php echo str_pad($boleta['id'], 4, '0', STR_PAD_LEFT); ?></h1>
                <div class="header-actions">
                    <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
                    <a href="imprimir.php?id=<?php echo $boleta['id']; ?>" class="btn btn-success" target="_blank"><i class="fas fa-print"></i> Imprimir</a>
                </div>
            </header>

            <div class="boleta-details">
                <!-- Información del cliente -->
                <div class="detail-section">
                    <h3><i class="fas fa-user"></i> Información del Cliente</h3>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <strong>Nombre:</strong>
                            <span><?php echo htmlspecialchars($boleta['cliente_nombre'] . ' ' . $boleta['cliente_apellido']); ?></span>
                        </div>
                        <div class="detail-item">
                            <strong>Correo:</strong>
                            <span><?php echo htmlspecialchars($boleta['cliente_correo']); ?></span>
                        </div>
                        <div class="detail-item">
                            <strong>Teléfono:</strong>
                            <span><?php echo htmlspecialchars($boleta['cliente_celular']); ?></span>
                        </div>
                        <div class="detail-item">
                            <strong>ID Cliente:</strong>
                            <span>#<?php echo $boleta['id_cliente']; ?></span>
                        </div>
                    </div>
                </div>

                <!-- Información de la compra -->
                <div class="detail-section">
                    <h3><i class="fas fa-receipt"></i> Información de la Compra</h3>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <strong>Fecha de Compra:</strong>
                            <span><?php echo date('d/m/Y H:i:s', strtotime($boleta['fecha'])); ?></span>
                        </div>
                        <div class="detail-item">
                            <strong>Total:</strong>
                            <span class="total-amount">S/ <?php echo number_format($boleta['total'], 2); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Asientos reservados -->
                <?php if (!empty($asientos)): ?>
                <div class="detail-section">
                    <h3><i class="fas fa-chair"></i> Asientos Reservados</h3>
                    <div class="asientos-grid">
                        <?php 
                        $pelicula_actual = '';
                        $subtotal_asientos = 0;
                        foreach ($asientos as $asiento): 
                            $subtotal_asientos += $asiento['precio'];
                            if ($pelicula_actual != $asiento['pelicula']):
                                if ($pelicula_actual != '') echo '</div>';
                                $pelicula_actual = $asiento['pelicula'];
                        ?>
                            <div class="pelicula-group">
                                <h4><?php echo htmlspecialchars($asiento['pelicula']); ?></h4>
                                <div class="funcion-info">
                                    📅 <?php echo date('d/m/Y', strtotime($asiento['fecha'])); ?> - 
                                    🕐 <?php echo date('H:i', strtotime($asiento['hora'])); ?> - 
                                    🏢 <?php echo htmlspecialchars($asiento['cine']); ?> - 
                                    🎬 Sala <?php echo $asiento['id_sala']; ?> (<?php echo $asiento['formato']; ?>)
                                </div>
                                <div class="asientos-lista">
                        <?php endif; ?>
                                    <div class="asiento-item">
                                        <span class="asiento-codigo">
                                            <?php echo $asiento['fila'] . $asiento['numero']; ?>
                                        </span>
                                        <span class="asiento-precio">
                                            S/ <?php echo number_format($asiento['precio'], 2); ?>
                                        </span>
                                    </div>
                        <?php endforeach; ?>
                                </div>
                            </div>
                    </div>
                    <div class="subtotal">
                        <strong>Subtotal Entradas: S/ <?php echo number_format($subtotal_asientos, 2); ?></strong>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Productos de dulcería -->
                <?php if (!empty($productos)): ?>
                <div class="detail-section">
                    <h3><i class="fas fa-candy-cane"></i> Productos de Dulcería</h3>
                    <div class="productos-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Categoría</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unit.</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $subtotal_productos = 0;
                                foreach ($productos as $producto): 
                                    $subtotal_productos += $producto['subtotal'];
                                ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo $producto['categoria']; ?>">
                                                <?php echo ucfirst($producto['categoria']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo $producto['cantidad']; ?></td>
                                        <td>S/ <?php echo number_format($producto['precio_unitario'], 2); ?></td>
                                        <td><strong>S/ <?php echo number_format($producto['subtotal'], 2); ?></strong></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="subtotal">
                            <strong>Subtotal Dulcería: S/ <?php echo number_format($subtotal_productos, 2); ?></strong>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Total final -->
                <div class="detail-section total-section">
                    <div class="total-final">
                        <h2>💰 Total Final: S/ <?php echo number_format($boleta['total'], 2); ?></h2>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        .boleta-details { padding: 20px; }
        .detail-section { background: white; margin: 20px 0; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .detail-section h3 { margin: 0 0 20px 0; color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        .detail-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; }
        .detail-item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee; }
        .detail-item strong { color: #2c3e50; }
        .total-amount { color: #27ae60; font-weight: bold; font-size: 1.2em; }
        
        .pelicula-group { margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 6px; }
        .pelicula-group h4 { margin: 0 0 10px 0; color: #2c3e50; }
        .funcion-info { color: #666; margin-bottom: 10px; font-size: 14px; }
        .asientos-lista { display: flex; flex-wrap: wrap; gap: 10px; }
        .asiento-item { background: white; padding: 8px 12px; border-radius: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 10px; }
        .asiento-codigo { font-weight: bold; color: #3498db; }
        .asiento-precio { color: #27ae60; font-weight: bold; }
        
        .table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .table th, .table td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        .table th { background: #f8f9fa; font-weight: 600; color: #2c3e50; }
        .table tr:hover { background: #f9f9f9; }
        
        .subtotal { text-align: right; margin-top: 15px; padding: 10px 0; border-top: 2px solid #eee; color: #2c3e50; }
        .total-section { text-align: center; background: linear-gradient(135deg, #3498db, #2ecc71); color: white; }
        .total-final h2 { margin: 0; font-size: 2rem; }
        
        .badge { padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: bold; }
        .badge-bebidas { background: #e3f2fd; color: #1976d2; }
        .badge-snacks { background: #fff3e0; color: #f57c00; }
        .badge-dulces { background: #fce4ec; color: #c2185b; }
        .badge-combos { background: #e8f5e8; color: #388e3c; }
        
        .header-actions { display: flex; gap: 10px; }
        .btn { padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: 500; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn:hover { transform: translateY(-1px); }
    </style>
</body>
</html>