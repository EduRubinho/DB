<?php
// Si quieres usar sesión para cachear resultados, descomenta la siguiente línea:
// session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Películas en Cartelera</title>
    <link rel="stylesheet" href="../../pelicula.css" />
</head>
<body>
    <header>
        <h1>🎬 Películas en Cartelera</h1>
        <nav>
            <ul>
                <li class="activo">En cartelera</li>
                <li>Próximos estrenos</li>
            </ul>
        </nav>
    </header>
    <main class="contenedor">
        <aside class="filtros">
            <h3>Filtrar Por:</h3>
            <ul>
                <li>Ciudad</li>
                <li>Cine</li>
                <li>Día</li>
                <li>Género</li>
                <li>Idioma</li>
                <li>Formato</li>
                <li>Censura</li>
            </ul>
        </aside>
        <section class="cartelera">
            <?php include 'procesar_pelicula.php'; ?>
        </section>
    </main>
</body>
</html>