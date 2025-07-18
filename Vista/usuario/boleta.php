<?php
require_once __DIR__ . '/../../config/session.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../../Controlador/usuario/ReservaControlador.php';

$boleta_id = $_GET['id'] ?? null;
if (!$boleta_id) {
    header('Location: mis_boletas.php');
    exit;
}

$reservaControlador = new ReservaControlador();
$boleta = $reservaControlador->obtenerBoletaPorId($boleta_id);
$asientos = $reservaControlador->obtenerAsientosPorBoleta($boleta_id);
$productos = $reservaControlador->obtenerProductosPorBoleta($boleta_id);
$totales = $reservaControlador->obtenerTotalBoleta($boleta_id);

if (!$boleta || $boleta['id_cliente'] != $_SESSION['usuario']['id']) {
    header('Location: mis_boletas.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta N° <?php echo str_pad($boleta['id'], 6, '0', STR_PAD_LEFT); ?> - Cineplanet</title>
    <link rel="stylesheet" href="../css/boleta.css">
</head>
<body>
    <div class="container">
        <div class="no-print">
            <header class="header">
                <div class="nav-buttons">
                    <a href="mis_boletas.php" class="btn btn-back">← Mis Boletas</a>
                    <a href="peliculas.php" class="btn btn-secondary">🎬 Cartelera</a>
                </div>
                <h1>🎫 Detalle de Boleta</h1>
            </header>
        </div>

        <div class="boleta-container">
            <!-- Header de la boleta -->
            <div class="boleta-header">
                <div class="cinema-logo">
                    <h2>🎬 CINEPLANET</h2>
                    <p>Tu experiencia cinematográfica</p>
                </div>
                <div class="boleta-info">
                    <div class="boleta-numero">
                        BOLETA N° <?php echo str_pad($boleta['id'], 6, '0', STR_PAD_LEFT); ?>
                    </div>
                    <div class="fecha-emision">
                        Emitida: <?php echo date('d/m/Y H:i', strtotime($boleta['fecha'])); ?>
                    </div>
                </div>
            </div>

            <!-- Información del cliente -->
            <div class="cliente-section">
                <h3>👤 Información del Cliente</h3>
                <div class="cliente-grid">
                    <div class="cliente-item">
                        <strong>Nombre:</strong>
                        <?php echo htmlspecialchars($boleta['nombre'] . ' ' . $boleta['apellido_paterno'] . ' ' . $boleta['apellido_materno']); ?>
                    </div>
                    <div class="cliente-item">
                        <strong>DNI:</strong>
                        <?php echo htmlspecialchars($boleta['DNI']); ?>
                    </div>
                    <div class="cliente-item">
                        <strong>Email:</strong>
                        <?php echo htmlspecialchars($boleta['correo']); ?>
                    </div>
                </div>
            </div>

            <!-- Información de la función -->
            <?php if (!empty($asientos)): ?>
                <?php $primerAsiento = $asientos[0]; ?>
                <div class="funcion-section">
                    <h3>🎭 Detalles de la Función</h3>
                    <div class="funcion-banner">
                        <div class="pelicula-info">
                            <h4><?php echo htmlspecialchars($primerAsiento['pelicula_titulo']); ?></h4>
                            <div class="funcion-details">
                                <div class="detail-item">
                                    <span class="icon">📅</span>
                                    <span>Fecha: <?php echo date('l, d/m/Y', strtotime($primerAsiento['fecha'])); ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="icon">🕐</span>
                                    <span>Hora: <?php echo date('H:i', strtotime($primerAsiento['hora'])); ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="icon">🎪</span>
                                    <span>Sala: <?php echo htmlspecialchars($primerAsiento['sala_nombre']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Asientos -->
                <div class="asientos-section">
                    <h3>💺 Asientos Reservados</h3>
                    <div class="asientos-container">
                        <div class="asientos-grid">
                            <?php foreach ($asientos as $asiento): ?>
                                <div class="asiento-ticket">
                                    <div class="asiento-numero">
                                        Fila <?php echo htmlspecialchars($asiento['fila']); ?>
                                    </div>
                                    <div class="asiento-detalle">
                                        Asiento <?php echo htmlspecialchars($asiento['numero']); ?>
                                    </div>
                                    <div class="asiento-precio">
                                        S/ <?php echo number_format($asiento['precio'], 2); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Productos de Dulcería -->
            <?php if (!empty($productos)): ?>
                <div class="dulceria-section">
                    <h3>🍿 Productos de Dulcería</h3>
                    <div class="productos-container">
                        <div class="productos-tabla">
                            <table class="tabla-productos">
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
                                    <?php foreach ($productos as $producto): ?>
                                        <tr>
                                            <td class="producto-nombre">
                                                <?php echo htmlspecialchars($producto['producto_nombre']); ?>
                                            </td>
                                            <td class="producto-categoria">
                                                <?php 
                                                $iconos = [
                                                    'combos' => '🎭',
                                                    'bebidas' => '🥤', 
                                                    'snacks' => '🍿',
                                                    'dulces' => '🍭'
                                                ];
                                                echo $iconos[$producto['categoria']] ?? '🍽️';
                                                echo ' ' . ucfirst($producto['categoria']);
                                                ?>
                                            </td>
                                            <td class="producto-cantidad">
                                                <?php echo $producto['cantidad']; ?>
                                            </td>
                                            <td class="producto-precio">
                                                S/ <?php echo number_format($producto['precio_unitario'], 2); ?>
                                            </td>
                                            <td class="producto-subtotal">
                                                S/ <?php echo number_format($producto['cantidad'] * $producto['precio_unitario'], 2); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Resumen de pago MEJORADO -->
            <div class="pago-section">
                <div class="pago-desglose">
                    <!-- Subtotal Asientos -->
                    <div class="pago-categoria">
                        <h4>🎫 Entradas de Cine</h4>
                        <div class="pago-row">
                            <span>Cantidad de asientos:</span>
                            <span><?php echo count($asientos); ?> asiento<?php echo count($asientos) > 1 ? 's' : ''; ?></span>
                        </div>
                        <?php if (!empty($asientos)): ?>
                            <div class="pago-row">
                                <span>Precio unitario:</span>
                                <span>S/ <?php echo number_format($asientos[0]['precio'], 2); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="pago-row subtotal-categoria">
                            <span><strong>Subtotal Entradas:</strong></span>
                            <span><strong>S/ <?php echo number_format($totales['total_asientos'], 2); ?></strong></span>
                        </div>
                    </div>

                    <!-- Subtotal Dulcería -->
                    <?php if (!empty($productos)): ?>
                        <div class="pago-categoria">
                            <h4>🍿 Dulcería</h4>
                            <?php foreach ($productos as $producto): ?>
                                <div class="pago-row">
                                    <span><?php echo htmlspecialchars($producto['producto_nombre']); ?> (x<?php echo $producto['cantidad']; ?>):</span>
                                    <span>S/ <?php echo number_format($producto['cantidad'] * $producto['precio_unitario'], 2); ?></span>
                                </div>
                            <?php endforeach; ?>
                            <div class="pago-row subtotal-categoria">
                                <span><strong>Subtotal Dulcería:</strong></span>
                                <span><strong>S/ <?php echo number_format($totales['total_productos'], 2); ?></strong></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Total General -->
                    <div class="pago-row total">
                        <span>TOTAL GENERAL:</span>
                        <span>S/ <?php echo number_format($totales['total_general'], 2); ?></span>
                    </div>
                </div>
            </div>

            <!-- QR Code y footer (sin cambios) -->
            <div class="boleta-footer">
                <div class="qr-section">
                    <div class="qr-code">
                        <div class="qr-placeholder">
                            📱<br>
                            QR CODE<br>
                            <small>Código: <?php echo strtoupper(substr(md5($boleta['id']), 0, 8)); ?></small>
                        </div>
                    </div>
                    <div class="qr-info">
                        <p><strong>Presenta este QR en el cine</strong></p>
                        <p>Código de verificación: <strong><?php echo strtoupper(substr(md5($boleta['id']), 0, 8)); ?></strong></p>
                        <p>Válido hasta: <?php echo date('d/m/Y', strtotime($primerAsiento['fecha'] ?? 'now')); ?></p>
                    </div>
                </div>
                
                <div class="footer-info">
                    <p>🎬 <strong>CINEPLANET</strong> - Tu experiencia cinematográfica</p>
                    <p>www.cineplanet.com.pe | 📞 (01) 700-0000</p>
                    <p class="terminos">Esta boleta es válida únicamente para la función indicada. No reembolsable.</p>
                </div>
            </div>
        </div>

        <!-- Botones de acción (sin cambios) -->
        <div class="no-print">
            <div class="action-buttons">
                <button onclick="window.print()" class="btn btn-print">
                    🖨️ Imprimir Boleta
                </button>
                <a href="mis_boletas.php" class="btn btn-primary">
                    📋 Ver Todas mis Boletas
                </a>
                <a href="peliculas.php" class="btn btn-secondary">
                    🎬 Comprar más Entradas
                </a>
            </div>
        </div>
    </div>

    <script>
        // Auto-print si se especifica en la URL
        if (window.location.search.includes('print=1')) {
            window.onload = function() {
                window.print();
            };
        }
    </script>
</body>
</html>