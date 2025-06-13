<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/e.scss">
    <title>Document</title>
</head>
<body>
    <section>
        <div class="box">
            <div class="container">
                <div class="formulario">
                    <h1>Iniciar sesión</h1>
                    <p class="p1">Ingresa a tu cuenta para disfrutar de tus beneficios, acumular</p>
                    <p class="p1">puntos y vivir al máximo la experiencia Cineplanet.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                        <div class="inputbox">
                            <input type="text" name="nrosocio" id="nrosocio" placeholder=" N° de Socio Cineplanet" required>
                        </div>
                        <div class="texto">
                            <p class="p2">DNI, RUT, CE o Pasaporte</p>
                        </div>
                        <div class="inputbox">
                            <input type="password" name="password" placeholder="Contraseña" required>
                        </div>
                        <a href="" class="olvidar">
                            <p>¿Olvidaste tu contraseña?</p>
                        </a>
                        <div class="boton">
                            <button class="boton1">Ingresar</button>
                        </div>
                        <?php if(!empty($errores)): ?>
                            <div class="error">
                            <?php echo $errores; ?>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <div class="contenido">
                <strong>¿No eres socio?</strong>
                <p class="p3">Registrándote en nuestro programa Socio Cineplanet podrás acumular</p>
                <p class="p3">puntos en cada visita que realices y gozar de grandes beneficios.</p>
                <div class="botonrojo">
                    <button class="boton2"><a href="auth_register.php">Únete</a></button>
                </div>
            </div>
        </div>
    </section>
</body>
</html>

