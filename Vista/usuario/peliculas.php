<?php
require_once __DIR__ . '/../../config/session.php';
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../../Controlador/usuario/PeliculaControlador.php';

$controlador = new PeliculaControlador();
$peliculas = $controlador->obtenerTodas();
$genero_filtro = $_GET['genero'] ?? '';

if ($genero_filtro) {
    $peliculas = $controlador->buscarPorGenero($genero_filtro);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartelera - Cineplanet</title>
    <link rel="stylesheet" href="../css/peliculas.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>🎬 Cartelera Cineplanet</h1>
            <div class="user-info">
                Hola, <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?>
            </div>
            <nav class="nav-buttons">
                <a href="mis_boletas.php" class="btn btn-primary">📄 Mis Boletas</a>
                <a href="perfil.php" class="btn btn-secondary">👤 Mi Perfil</a>
                <a href="../web/inicio.php" class="btn btn-secondary">🏠 Inicio</a>
            </nav>
        </header>

        <div class="filtros">
            <form method="GET" class="filter-form">
                <select name="genero" onchange="this.form.submit()">
                    <option value="">Todos los géneros</option>
                    <option value="Romance" <?php echo $genero_filtro === 'Romance' ? 'selected' : ''; ?>>Romance</option>
                    <option value="Ciencia Ficción" <?php echo $genero_filtro === 'Ciencia Ficción' ? 'selected' : ''; ?>>Ciencia Ficción</option>
                    <option value="Animación" <?php echo $genero_filtro === 'Animación' ? 'selected' : ''; ?>>Animación</option>
                    <option value="Acción" <?php echo $genero_filtro === 'Acción' ? 'selected' : ''; ?>>Acción</option>
                    <option value="Comedia" <?php echo $genero_filtro === 'Comedia' ? 'selected' : ''; ?>>Comedia</option>
                    <option value="Drama" <?php echo $genero_filtro === 'Drama' ? 'selected' : ''; ?>>Drama</option>
                    <option value="Terror" <?php echo $genero_filtro === 'Terror' ? 'selected' : ''; ?>>Terror</option>
                    <option value="Aventura" <?php echo $genero_filtro === 'Aventura' ? 'selected' : ''; ?>>Aventura</option>
                </select>
            </form>
        </div>

        <div class="peliculas-grid">
            <?php foreach ($peliculas as $pelicula): ?>
                <div class="pelicula-card">
                    <?php if ($pelicula['imagen']): ?>
                        <img src="<?php echo htmlspecialchars($pelicula['imagen']); ?>" alt="<?php echo htmlspecialchars($pelicula['titulo']); ?>" class="pelicula-img">
                    <?php endif; ?>
                    
                    <div class="pelicula-info">
                        <h3><?php echo htmlspecialchars($pelicula['titulo']); ?></h3>
                        <p class="genero">🎭 <?php echo htmlspecialchars($pelicula['genero']); ?></p>
                        <p class="duracion">⏱️ <?php echo htmlspecialchars($pelicula['duracion']); ?> min</p>
                        <p class="director">🎬 <?php echo htmlspecialchars($pelicula['director']); ?></p>
                        <p class="descripcion"><?php echo htmlspecialchars(substr($pelicula['descripcion'], 0, 100)); ?>...</p>
                        
                        <div class="acciones">
                            <a href="funciones.php?pelicula_id=<?php echo $pelicula['id']; ?>" class="btn btn-primary">
                                Ver Funciones
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($peliculas)): ?>
            <div class="no-peliculas">
                <h3>No hay películas disponibles</h3>
                <p>Intenta con otro filtro o vuelve más tarde.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>