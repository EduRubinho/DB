<?php
require_once __DIR__ . '/../../config/session.php';
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../../Controlador/usuario/ReservaControlador.php';

$reservaControlador = new ReservaControlador();
$boletas = $reservaControlador->obtenerBoletasPorUsuario($_SESSION['usuario']['id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Boletas - Cineplanet</title>
    <link rel="stylesheet" href="../css/boletas.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="header-content">
                <h1>🎬 Mis Boletas</h1>
                <div class="user-welcome">
                    Hola, <?php echo htmlspecialchars($_SESSION['usuario']['nombre'] . ' ' . $_SESSION['usuario']['apellido_paterno']); ?>
                </div>
            </div>
            <nav class="header-nav">
                <a href="peliculas.php" class="btn btn-primary">🎭 Ver Cartelera</a>
                <a href="perfil.php" class="btn btn-secondary">👤 Mi Perfil</a>
                <a href="../web/inicio.php" class="btn btn-secondary">🏠 Inicio</a>
            </nav>
        </header>

        <div class="stats-banner">
            <div class="stat-item">
                <div class="stat-number"><?php echo count($boletas); ?></div>
                <div class="stat-label">Boletas Totales</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">
                    <?php 
                    $totalAsientos = array_sum(array_column($boletas, 'cantidad_asientos'));
                    echo $totalAsientos;
                    ?>
                </div>
                <div class="stat-label">Asientos Comprados</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">
                    S/ <?php 
                    $totalGastado = array_sum(array_column($boletas, 'total'));
                    echo number_format($totalGastado, 2);
                    ?>
                </div>
                <div class="stat-label">Total Gastado</div>
            </div>
        </div>

        <div class="boletas-container">
            <?php if (empty($boletas)): ?>
                <div class="no-boletas">
                    <div class="no-boletas-icon">🎫</div>
                    <h3>No tienes boletas registradas</h3>
                    <p>¡Ve a la cartelera y compra tus entradas para disfrutar del mejor cine!</p>
                    <a href="peliculas.php" class="btn btn-primary btn-large">🎬 Ver Películas Disponibles</a>
                </div>
            <?php else: ?>
                <?php foreach ($boletas as $boleta): ?>
                    <div class="boleta-card">
                        <div class="boleta-header">
                            <div class="boleta-info">
                                <div class="boleta-numero">
                                    📄 Boleta N° <?php echo str_pad($boleta['id'], 6, '0', STR_PAD_LEFT); ?>
                                </div>
                                <div class="boleta-fecha">
                                    📅 <?php echo date('d/m/Y H:i', strtotime($boleta['fecha'])); ?>
                                </div>
                            </div>
                            <div class="boleta-estado">
                                <span class="estado-badge activa">✅ Activa</span>
                            </div>
                        </div>

                        <div class="pelicula-section">
                            <div class="pelicula-banner">
                                <div class="pelicula-info">
                                    <h3 class="pelicula-titulo">
                                        🎬 <?php echo htmlspecialchars($boleta['pelicula_titulo']); ?>
                                    </h3>
                                    <div class="pelicula-meta">
                                        <span class="meta-item">🎭 <?php echo htmlspecialchars($boleta['genero']); ?></span>
                                        <span class="meta-item">⏱️ <?php echo htmlspecialchars($boleta['duracion']); ?> min</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="funcion-details">
                                <div class="detail-row">
                                    <div class="detail-item">
                                        <strong>📅 Función:</strong> 
                                        <?php echo date('l, d/m/Y', strtotime($boleta['fecha_funcion'])); ?>
                                    </div>
                                    <div class="detail-item">
                                        <strong>🕐 Hora:</strong> 
                                        <?php echo date('H:i', strtotime($boleta['hora_funcion'])); ?>
                                    </div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-item">
                                        <strong>🎪 Sala:</strong> 
                                        <?php echo htmlspecialchars($boleta['sala_nombre']); ?>
                                    </div>
                                    <div class="detail-item">
                                        <strong>💺 Asientos:</strong> 
                                        <?php echo $boleta['cantidad_asientos']; ?> asiento<?php echo $boleta['cantidad_asientos'] > 1 ? 's' : ''; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="asientos-section">
                            <h4 class="asientos-titulo">💺 Asientos Reservados:</h4>
                            <div class="asientos-grid">
                                <?php 
                                $asientos = explode(',', $boleta['asientos']); 
                                foreach ($asientos as $asiento): 
                                ?>
                                    <span class="asiento-badge"><?php echo trim($asiento); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="boleta-footer">
                            <div class="total-section">
                                <div class="total-label">Total Pagado:</div>
                                <div class="total-amount">S/ <?php echo number_format($boleta['total'], 2); ?></div>
                            </div>
                            <div class="acciones-section">
                                <a href="boleta.php?id=<?php echo $boleta['id']; ?>" 
                                   class="btn btn-primary">
                                    🖨️ Ver/Imprimir
                                </a>
                                <a href="funciones.php?pelicula_id=<?php echo $boleta['pelicula_id']; ?>" 
                                   class="btn btn-outline">
                                    🎬 Ver más funciones
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="footer-actions">
            <a href="../web/inicio.php" class="btn btn-secondary">← Volver al Inicio</a>
        </div>
    </div>
</body>
</html>