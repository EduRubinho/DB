<?php
require_once __DIR__ . '/../../../config/session.php';

if (!isset($_SESSION['admin'])) {
    header('Location: ../../admin/login_admin.php');
    exit;
}

require_once __DIR__ . '/../../../Controlador/admin/BoletaControlador.php';

$boletaControlador = new BoletaControlador();
$estadisticas = $boletaControlador->obtenerEstadisticas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Cineplanet</title>
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>🎬 Admin</h2>
                <p>Cineplanet</p>
            </div>
            
            <ul class="sidebar-menu">
                <li class="active">
                    <a href="inicioadmin.php">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="../../admin/cliente/index.php">
                        <i class="fas fa-users"></i>
                        Clientes
                    </a>
                </li>
                <li>
                    <a href="../../admin/pelicula/index.php">
                        <i class="fas fa-film"></i>
                        Películas
                    </a>
                </li>
                <li>
                    <a href="../../admin/funcion/index.php">
                        <i class="fas fa-calendar-alt"></i>
                        Funciones
                    </a>
                </li>
                <li>
                    <a href="../../admin/dulceria/index.php">
                        <i class="fas fa-candy-cane"></i>
                        Dulcería
                    </a>
                </li>
                <li>
                    <a href="../../admin/boleta/index.php">
                        <i class="fas fa-ticket-alt"></i>
                        Boletas
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        Cerrar Sesión
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <header class="content-header">
                <h1>📊 Dashboard Administrativo</h1>
                <div class="user-info">
                    <span>Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['admin']['usuario'] ?? 'Admin'); ?></strong></span>
                    <small><?php echo date('d/m/Y H:i'); ?></small>
                </div>
            </header>

            <!-- Estadísticas Cards -->
            <div class="stats-grid">
                <div class="stat-card primary">
                    <div class="stat-icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $estadisticas['hoy']['total'] ?? 0; ?></h3>
                        <p>Boletas Vendidas Hoy</p>
                        <span class="stat-amount">S/ <?php echo number_format($estadisticas['hoy']['ingresos'] ?? 0, 2); ?></span>
                    </div>
                </div>

                <div class="stat-card success">
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $estadisticas['mes']['total'] ?? 0; ?></h3>
                        <p>Ventas Este Mes</p>
                        <span class="stat-amount">S/ <?php echo number_format($estadisticas['mes']['ingresos'] ?? 0, 2); ?></span>
                    </div>
                </div>

                <div class="stat-card warning">
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $estadisticas['pelicula_top']['ventas'] ?? 0; ?></h3>
                        <p>Película Más Vendida</p>
                        <span class="stat-movie"><?php echo htmlspecialchars($estadisticas['pelicula_top']['titulo'] ?? 'N/A'); ?></span>
                    </div>
                </div>

                <div class="stat-card info">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo date('H:i'); ?></h3>
                        <p>Hora Actual</p>
                        <span class="stat-date"><?php echo date('d/m/Y'); ?></span>
                    </div>
                </div>
            </div>

            <!-- Resumen del Sistema -->
            <div class="system-overview">
                <h2>📈 Resumen del Sistema</h2>
                <div class="overview-grid">
                    <div class="overview-card">
                        <div class="overview-header">
                            <i class="fas fa-users"></i>
                            <h3>Clientes Registrados</h3>
                        </div>
                        <div class="overview-content">
                            <span class="overview-number"><?php 
                                require_once __DIR__ . '/../../../Controlador/admin/ClienteRegistradoControlador.php';
                                $clienteControlador = new ClienteRegistradoControlador();
                                echo $clienteControlador->contarTotal();
                            ?></span>
                            <span class="overview-label">Total de clientes</span>
                        </div>
                    </div>

                    <div class="overview-card">
                        <div class="overview-header">
                            <i class="fas fa-film"></i>
                            <h3>Películas en Cartelera</h3>
                        </div>
                        <div class="overview-content">
                            <span class="overview-number"><?php 
                                require_once __DIR__ . '/../../../Controlador/admin/PeliculaControlador.php';
                                $peliculaControlador = new PeliculaControlador();
                                echo $peliculaControlador->contarTotal();
                            ?></span>
                            <span class="overview-label">Películas activas</span>
                        </div>
                    </div>

                    <div class="overview-card">
                        <div class="overview-header">
                            <i class="fas fa-calendar-alt"></i>
                            <h3>Funciones Programadas</h3>
                        </div>
                        <div class="overview-content">
                            <span class="overview-number"><?php 
                                require_once __DIR__ . '/../../../Controlador/admin/FuncionControlador.php';
                                $funcionControlador = new FuncionControlador();
                                echo $funcionControlador->contarTotal();
                            ?></span>
                            <span class="overview-label">Funciones totales</span>
                        </div>
                    </div>

                    <div class="overview-card">
                        <div class="overview-header">
                            <i class="fas fa-candy-cane"></i>
                            <h3>Productos Dulcería</h3>
                        </div>
                        <div class="overview-content">
                            <span class="overview-number"><?php 
                                require_once __DIR__ . '/../../../Controlador/admin/DulceriaControlador.php';
                                $dulceriaControlador = new DulceriaControlador();
                                echo $dulceriaControlador->contarTotal();
                            ?></span>
                            <span class="overview-label">Productos disponibles</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="quick-actions">
                <h2>🚀 Acciones Rápidas</h2>
                <div class="actions-grid">
                    <a href="../../admin/cliente/crear.php" class="action-card">
                        <i class="fas fa-user-plus"></i>
                        <h3>Nuevo Cliente</h3>
                        <p>Registrar nuevo cliente en el sistema</p>
                    </a>

                    <a href="../../admin/pelicula/crear.php" class="action-card">
                        <i class="fas fa-plus-circle"></i>
                        <h3>Nueva Película</h3>
                        <p>Agregar película a la cartelera</p>
                    </a>

                    <a href="../../admin/funcion/crear.php" class="action-card">
                        <i class="fas fa-calendar-plus"></i>
                        <h3>Nueva Función</h3>
                        <p>Programar función de película</p>
                    </a>

                    <a href="../../admin/dulceria/crear.php" class="action-card">
                        <i class="fas fa-shopping-cart"></i>
                        <h3>Nuevo Producto</h3>
                        <p>Agregar producto a dulcería</p>
                    </a>

                    <a href="../../admin/boleta/index.php" class="action-card">
                        <i class="fas fa-file-export"></i>
                        <h3>Ver Boletas</h3>
                        <p>Gestionar ventas y reportes</p>
                    </a>

                    <a href="../inicio.php" target="_blank" class="action-card">
                        <i class="fas fa-external-link-alt"></i>
                        <h3>Ver Sitio Web</h3>
                        <p>Ir a la página pública del cine</p>
                    </a>
                </div>
            </div>

            <!-- Actividad Reciente -->
            <div class="recent-activity">
                <h2>📋 Actividad Reciente</h2>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="activity-content">
                            <h4>Última venta realizada</h4>
                            <p>Hace <?php echo rand(5, 60); ?> minutos</p>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="activity-content">
                            <h4>Nuevo cliente registrado</h4>
                            <p>Hace <?php echo rand(1, 3); ?> horas</p>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-film"></i>
                        </div>
                        <div class="activity-content">
                            <h4>Película actualizada</h4>
                            <p>Hace <?php echo rand(2, 24); ?> horas</p>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="activity-content">
                            <h4>Nueva función programada</h4>
                            <p>Hace <?php echo rand(1, 5); ?> días</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enlaces Útiles -->
            <div class="useful-links">
                <h2>🔗 Enlaces Útiles</h2>
                <div class="links-grid">
                    <a href="../../admin/cliente/index.php" class="link-card">
                        <i class="fas fa-users"></i>
                        <span>Gestionar Clientes</span>
                    </a>
                    
                    <a href="../../admin/pelicula/index.php" class="link-card">
                        <i class="fas fa-film"></i>
                        <span>Gestionar Películas</span>
                    </a>
                    
                    <a href="../../admin/funcion/index.php" class="link-card">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Gestionar Funciones</span>
                    </a>
                    
                    <a href="../../admin/dulceria/index.php" class="link-card">
                        <i class="fas fa-candy-cane"></i>
                        <span>Gestionar Dulcería</span>
                    </a>
                    
                    <a href="../../admin/boleta/index.php" class="link-card">
                        <i class="fas fa-ticket-alt"></i>
                        <span>Ver Boletas</span>
                    </a>
                    
                    <a href="../usuario/peliculas.php" class="link-card" target="_blank">
                        <i class="fas fa-eye"></i>
                        <span>Vista de Usuario</span>
                    </a>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Actualizar hora cada minuto
        setInterval(function() {
            const now = new Date();
            const timeElement = document.querySelector('.stat-card.info .stat-content h3');
            const dateElement = document.querySelector('.stat-card.info .stat-date');
            
            if (timeElement) {
                timeElement.textContent = now.toLocaleTimeString('es-PE', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }
            
            if (dateElement) {
                dateElement.textContent = now.toLocaleDateString('es-PE');
            }
        }, 60000);

        // Efectos hover para las cards
        document.querySelectorAll('.action-card, .link-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.15)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
            });
        });
    </script>
</body>
</html>