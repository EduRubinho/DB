<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Películas en Cartelera</title>
    <link rel="stylesheet" href="css/pelicula.css" />
</head>

<body>
    <header>
        <h1>Películas</h1>
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
            <div class="pelicula">
                <div class="etiqueta">Estreno</div>
                <img src="poster1.jpg" alt="La Salsa Vive" />
                <h4>La Salsa Vive</h4>
                <p>Documental, 1h 41min, +14.</p>
            </div>

            <div class="pelicula">
                <img src="poster2.jpg" alt="Bailarina" />
                <h4>Bailarina</h4>
                <p>Drama, 2h 5min, +14.</p>
            </div>

            <div class="pelicula">
                <img src="poster3.jpg" alt="Como Entrenar a Tu Dragón" />
                <h4>Como Entrenar a Tu Dragón</h4>
                <p>Familiar, 2h 5min, APT.</p>
            </div>

            <div class="pelicula">
                <img src="poster4.jpg" alt="Cuadrilátero" />
                <h4>Cuadrilátero</h4>
                <p>Suspenso, 1h 25min, +14.</p>
            </div>

            <div class="pelicula">
                <img src="poster5.jpg" alt="Destino Final Lazos de Sangre" />
                <h4>Destino Final Lazos de Sangre</h4>
                <p>Terror, 1h 49min, +14 DNI.</p>
            </div>

            <div class="pelicula">
                <img src="poster6.jpg" alt="Elio" />
                <h4>Elio</h4>
                <p>Animación, 1h 39min, APT.</p>
            </div>
        </section>
    </main>
</body>

</html>