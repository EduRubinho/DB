<?php
require_once __DIR__ . '/../../config/session.php';
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../../Controlador/usuario/FuncionControlador.php';
require_once __DIR__ . '/../../Controlador/usuario/PeliculaControlador.php';

$pelicula_id = $_GET['pelicula_id'] ?? null;
if (!$pelicula_id) {
    header('Location: peliculas.php');
    exit;
}

$funcionControlador = new FuncionControlador();
$peliculaControlador = new PeliculaControlador();

$pelicula = $peliculaControlador->obtenerPorId($pelicula_id);
$funciones = $funcionControlador->obtenerPorPelicula($pelicula_id);

if (!$pelicula) {
    header('Location: peliculas.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funciones - <?php echo htmlspecialchars($pelicula['titulo']); ?></title>
    <link rel="stylesheet" href="../css/funciones.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="nav-back">
                <a href="peliculas.php" class="btn btn-back">← Volver a Cartelera</a>
                <a href="mis_boletas.php" class="btn btn-primary">📄 Mis Boletas</a>
            </div>
            <h1>Funciones Disponibles</h1>
        </header>

        <div class="pelicula-banner">
            <div class="pelicula-poster">
                <?php if ($pelicula['imagen']): ?>
                    <img src="<?php echo htmlspecialchars($pelicula['imagen']); ?>" alt="<?php echo htmlspecialchars($pelicula['titulo']); ?>">
                <?php endif; ?>
            </div>
            <div class="pelicula-detalles">
                <h2><?php echo htmlspecialchars($pelicula['titulo']); ?></h2>
                <div class="meta-info">
                    <span class="genero">🎭 <?php echo htmlspecialchars($pelicula['genero']); ?></span>
                    <span class="duracion">⏱️ <?php echo htmlspecialchars($pelicula['duracion']); ?> min</span>
                    <span class="director">🎬 <?php echo htmlspecialchars($pelicula['director']); ?></span>
                </div>
                <p class="descripcion"><?php echo htmlspecialchars($pelicula['descripcion']); ?></p>
            </div>
        </div>

        <div class="funciones-container">
            <h3>🎪 Selecciona una función:</h3>
            
            <?php if (empty($funciones)): ?>
                <div class="no-funciones">
                    <h4>😕 No hay funciones disponibles</h4>
                    <p>Esta película no tiene funciones programadas en este momento.</p>
                    <a href="peliculas.php" class="btn btn-primary">Ver otras películas</a>
                </div>
            <?php else: ?>
                <div class="funciones-grid">
                    <?php 
                    $funcionesPorFecha = [];
                    foreach ($funciones as $funcion) {
                        $fecha = $funcion['fecha'];
                        if (!isset($funcionesPorFecha[$fecha])) {
                            $funcionesPorFecha[$fecha] = [];
                        }
                        $funcionesPorFecha[$fecha][] = $funcion;
                    }
                    ?>

                    <?php foreach ($funcionesPorFecha as $fecha => $funcionesDia): ?>
                        <div class="fecha-grupo">
                            <h4 class="fecha-titulo">
                                📅 <?php echo date('l, d/m/Y', strtotime($fecha)); ?>
                            </h4>
                            <div class="horarios-grid">
                                <?php foreach ($funcionesDia as $funcion): ?>
                                    <div class="funcion-card">
                                        <div class="hora-principal">
                                            🕐 <?php echo date('H:i', strtotime($funcion['hora'])); ?>
                                        </div>
                                        <div class="funcion-info">
                                            <div class="sala">🎭 <?php echo htmlspecialchars($funcion['sala_nombre']); ?></div>
                                            <div class="precio">💰 S/ <?php echo number_format($funcion['precio'], 2); ?></div>
                                            <div class="capacidad">👥 <?php echo $funcion['capacidad']; ?> asientos</div>
                                        </div>
                                        <div class="funcion-acciones">
                                            <a href="asientos.php?funcion_id=<?php echo $funcion['id']; ?>&pelicula_id=<?php echo $pelicula_id; ?>" 
                                               class="btn btn-reservar">
                                                🎫 Seleccionar Asientos
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>