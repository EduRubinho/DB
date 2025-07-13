<?php
session_start();

// Redirigir si no hay sesión iniciada
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Cierre de sesión
if (isset($_GET['cerrar'])) {
    session_unset();
    session_destroy();
    header("Location: ../usuario/login.php");
    exit();
}

// Obtener el nombre del usuario
if (isset($_SESSION['usuario']['nombre'])) {
    $nombreUsuario = $_SESSION['usuario']['nombre'];
} else {
    $nombreUsuario = 'Usuario';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="shortcut icon" href="cineplanet.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/inicio.css">
    <title>Inicio Cineplanet</title>
</head>

<body>
    <header>
        <a href="#" class="logo">
            <img src="cineplanet.png" alt="logo">
            <h2 class="nombre-empresa">Cineplanet</h2>
        </a>
        <nav>
            <a href="pelicula.php" class="nav-link">Películas</a>
            <a href="#" class="nav-link">Cines</a>
            <a href="#" class="nav-link">Promociones</a>
            <a href="#" class="nav-link">Socios</a>
            <a href="#" class="nav-link">Dulcería</a>
            <a href="#" class="nav-link">Corporativo</a>
            <a href="blog.php" class="nav-link">Blog</a>
            <a href="?cerrar=1" class="nav-link">Cerrar Sesión</a>
        </nav>
        <div class="tercero">
            <span class="material-icons">account_circle</span>
            <span class="usuario-nombre">Hola, <?php echo htmlspecialchars($nombreUsuario); ?></span>
        </div>
    </header>

    <main>
        <h1>Bienvenido a Cineplanet, <?php echo htmlspecialchars($nombreUsuario); ?> 🎬</h1>
    </main>
</body>

</html>
