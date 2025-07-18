<?php
require_once __DIR__ . '/../../config/session.php';

// Redirigir si no hay sesión iniciada
if (!isset($_SESSION['usuario'])) {
    header("Location: ../usuario/login.php");
    exit();
}

// Cierre de sesión
if (isset($_GET['cerrar'])) {
    session_unset();
    session_destroy();
    header("Location: ../usuario/login.php");
    exit();
}

// Obtener información del usuario
$usuario = $_SESSION['usuario'];
$nombreCompleto = $usuario['nombre'] . ' ' . $usuario['apellido_paterno'];

// Simular datos para el dashboard (en un proyecto real vendría de la BD)
require_once __DIR__ . '/../../Controlador/usuario/PeliculaControlador.php';
$peliculaControlador = new PeliculaControlador();
$peliculasDestacadas = array_slice($peliculaControlador->obtenerTodas(), 0, 6);
$peliculasEstrenos = array_slice($peliculaControlador->obtenerTodas(), 0, 4);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="cineplanet.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/inicio.css">
    <title>Inicio - Cineplanet</title>
</head>

<body>
    <!-- Header Navigation -->
    <header class="header">
        <div class="container">
            <div class="nav-brand">
                <img src="cineplanet.png" alt="Cineplanet Logo" class="logo">
                <h2 class="brand-name">Cineplanet</h2>
            </div>
            
            <nav class="nav-menu">
                <a href="../usuario/peliculas.php" class="nav-link active">
                    <span class="material-icons">movie</span>
                    Películas
                </a>
                <a href="#cines" class="nav-link">
                    <span class="material-icons">location_on</span>
                    Cines
                </a>
                <a href="#promociones" class="nav-link">
                    <span class="material-icons">local_offer</span>
                    Promociones
                </a>
                <a href="../usuario/mis_boletas.php" class="nav-link">
                    <span class="material-icons">confirmation_number</span>
                    Mis Boletas
                </a>
                <a href="#dulceria" class="nav-link">
                    <span class="material-icons">fastfood</span>
                    Dulcería
                </a>
            </nav>

            <div class="user-section">
                <div class="user-info">
                    <span class="material-icons user-avatar">account_circle</span>
                    <div class="user-details">
                        <span class="user-greeting">¡Hola!</span>
                        <span class="user-name"><?php echo htmlspecialchars($nombreCompleto); ?></span>
                    </div>
                </div>
                <div class="user-menu">
                    <a href="../usuario/perfil.php" class="menu-item">
                        <span class="material-icons">person</span>
                        Mi Perfil
                    </a>
                    <a href="?cerrar=1" class="menu-item logout">
                        <span class="material-icons">logout</span>
                        Cerrar Sesión
                    </a>
                </div>
            </div>

            <button class="mobile-menu-btn">
                <span class="material-icons">menu</span>
            </button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-background">
            <div class="hero-overlay"></div>
        </div>
        <div class="hero-content">
            <div class="container">
                <h1 class="hero-title">
                    ¡Bienvenido de vuelta, <span class="highlight"><?php echo htmlspecialchars($usuario['nombre']); ?>!</span>
                </h1>
                <p class="hero-subtitle">
                    Descubre las mejores películas y vive la experiencia cinematográfica más increíble
                </p>
                <div class="hero-actions">
                    <a href="../usuario/peliculas.php" class="btn btn-primary btn-large">
                        <span class="material-icons">movie</span>
                        Ver Cartelera
                    </a>
                    <a href="../usuario/mis_boletas.php" class="btn btn-secondary btn-large">
                        <span class="material-icons">confirmation_number</span>
                        Mis Boletas
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <span class="material-icons">movie</span>
                    </div>
                    <div class="stat-info">
                        <h3>50+</h3>
                        <p>Películas Disponibles</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <span class="material-icons">theaters</span>
                    </div>
                    <div class="stat-info">
                        <h3>25+</h3>
                        <p>Salas de Cine</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <span class="material-icons">people</span>
                    </div>
                    <div class="stat-info">
                        <h3>1M+</h3>
                        <p>Clientes Satisfechos</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <span class="material-icons">star</span>
                    </div>
                    <div class="stat-info">
                        <h3>4.8/5</h3>
                        <p>Calificación Promedio</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Movies -->
    <section class="featured-movies">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">🎬 Películas Destacadas</h2>
                <p class="section-subtitle">Las películas más populares del momento</p>
            </div>
            
            <div class="movies-grid">
                <?php foreach ($peliculasDestacadas as $pelicula): ?>
                    <div class="movie-card">
                        <div class="movie-poster">
                            <?php if ($pelicula['imagen']): ?>
                                <img src="<?php echo htmlspecialchars($pelicula['imagen']); ?>" 
                                     alt="<?php echo htmlspecialchars($pelicula['titulo']); ?>">
                            <?php else: ?>
                                <div class="no-image">🎬</div>
                            <?php endif; ?>
                            <div class="movie-overlay">
                                <a href="../usuario/funciones.php?pelicula_id=<?php echo $pelicula['id']; ?>" 
                                   class="btn btn-primary">
                                    <span class="material-icons">play_arrow</span>
                                    Ver Funciones
                                </a>
                            </div>
                        </div>
                        <div class="movie-info">
                            <h3 class="movie-title"><?php echo htmlspecialchars($pelicula['titulo']); ?></h3>
                            <div class="movie-meta">
                                <span class="genre">🎭 <?php echo htmlspecialchars($pelicula['genero']); ?></span>
                                <span class="duration">⏱️ <?php echo htmlspecialchars($pelicula['duracion']); ?> min</span>
                            </div>
                            <p class="movie-description">
                                <?php echo htmlspecialchars(substr($pelicula['descripcion'], 0, 100)); ?>...
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="section-footer">
                <a href="../usuario/peliculas.php" class="btn btn-outline btn-large">
                    Ver Todas las Películas
                    <span class="material-icons">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="quick-actions">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">⚡ Acciones Rápidas</h2>
                <p class="section-subtitle">Todo lo que necesitas a un clic de distancia</p>
            </div>
            
            <div class="actions-grid">
                <a href="../usuario/peliculas.php" class="action-card">
                    <div class="action-icon">
                        <span class="material-icons">movie</span>
                    </div>
                    <h3>Comprar Entradas</h3>
                    <p>Reserva tus asientos para la función que prefieras</p>
                    <span class="action-arrow">→</span>
                </a>

                <a href="../usuario/mis_boletas.php" class="action-card">
                    <div class="action-icon">
                        <span class="material-icons">confirmation_number</span>
                    </div>
                    <h3>Mis Boletas</h3>
                    <p>Consulta y descarga tus boletas de cine</p>
                    <span class="action-arrow">→</span>
                </a>

                <a href="../usuario/perfil.php" class="action-card">
                    <div class="action-icon">
                        <span class="material-icons">person</span>
                    </div>
                    <h3>Mi Perfil</h3>
                    <p>Actualiza tu información personal</p>
                    <span class="action-arrow">→</span>
                </a>

                <a href="#promociones" class="action-card">
                    <div class="action-icon">
                        <span class="material-icons">local_offer</span>
                    </div>
                    <h3>Promociones</h3>
                    <p>Descubre las mejores ofertas y descuentos</p>
                    <span class="action-arrow">→</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Coming Soon -->
    <section class="coming-soon">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">🎭 Próximos Estrenos</h2>
                <p class="section-subtitle">Las películas que no te puedes perder</p>
            </div>
            
            <div class="estrenos-grid">
                <?php foreach ($peliculasEstrenos as $estreno): ?>
                    <div class="estreno-card">
                        <div class="estreno-badge">Próximamente</div>
                        <div class="estreno-poster">
                            <?php if ($estreno['imagen']): ?>
                                <img src="<?php echo htmlspecialchars($estreno['imagen']); ?>" 
                                     alt="<?php echo htmlspecialchars($estreno['titulo']); ?>">
                            <?php else: ?>
                                <div class="no-image">🎬</div>
                            <?php endif; ?>
                        </div>
                        <div class="estreno-info">
                            <h4><?php echo htmlspecialchars($estreno['titulo']); ?></h4>
                            <p class="estreno-date">
                                📅 <?php echo date('d/m/Y', strtotime($estreno['fecha_estreno'])); ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-brand">
                        <img src="cineplanet.png" alt="Cineplanet" class="footer-logo">
                        <h3>Cineplanet</h3>
                    </div>
                    <p>Tu experiencia cinematográfica perfecta te espera</p>
                </div>
                
                <div class="footer-section">
                    <h4>Enlaces Rápidos</h4>
                    <ul>
                        <li><a href="../usuario/peliculas.php">Películas</a></li>
                        <li><a href="../usuario/mis_boletas.php">Mis Boletas</a></li>
                        <li><a href="../usuario/perfil.php">Mi Perfil</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Contacto</h4>
                    <ul>
                        <li>📞 (01) 700-0000</li>
                        <li>📧 info@cineplanet.com.pe</li>
                        <li>📍 Lima, Perú</li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Síguenos</h4>
                    <div class="social-links">
                        <a href="#" class="social-link">📘 Facebook</a>
                        <a href="#" class="social-link">📷 Instagram</a>
                        <a href="#" class="social-link">🐦 Twitter</a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 Cineplanet. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const navMenu = document.querySelector('.nav-menu');
        
        mobileMenuBtn.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            mobileMenuBtn.classList.toggle('active');
        });

        // User menu toggle
        const userSection = document.querySelector('.user-section');
        const userMenu = document.querySelector('.user-menu');
        
        userSection.addEventListener('click', (e) => {
            e.stopPropagation();
            userMenu.classList.toggle('active');
        });

        document.addEventListener('click', () => {
            userMenu.classList.remove('active');
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll effect to header
        window.addEventListener('scroll', () => {
            const header = document.querySelector('.header');
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>