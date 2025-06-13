<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="shortcut icon" href="cineplanet.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <title>Menu Basico</title>
</head>
<body>
    <header>
        <a href="" class="logo">
            <img src="cineplanet.png" alt="logo">
            <h2 class="nombre-empresa">cineplanet</h2>
        </a>
        <nav>
            <a href="" class="nav-link">Películas</a>
            <a href="" class="nav-link">Cines</a>
            <a href="" class="nav-link">Promociones</a>
            <a href="" class="nav-link">Socios</a>
            <a href="" class="nav-link">Dulcería</a>
            <a href="" class="nav-link">Corporativo</a>
            <a href="" class="nav-link">Blog</a>
            <?php
            session_start();
            if (isset($_GET['cerrar'])) {
                session_unset();
                session_destroy();
                header("Location: inicio.php");
                exit();
            }
            ?>
            <a href="?cerrar=1" class="nav-link">Cerrar Sesión</a>
        </nav>
        <div class="tercero">
            <button>
                <a href="auth_login.php"><span class="material-icons">account_circle</span></a>
            </button>
            <button>
                <a href=""><span class="material-icons">search</span></a>
            </button>
            <button>
                <a href=""><span class="material-icons">help</span></a>
            </button>
            
        </div>
    </header>
</body>