<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="s.css">
    
</head>
<body>
    <div class="container">
        <h1>Iniciar Sesión</h1>
        <p>Ingresa a tu cuenta para disfrutar de tus beneficios, acumular <br>puntos y vivir al maximo la experiencia Cineplanet.</p>
        <form method="POST" action="validacion.php">
            <div class="campo">
                <input type="text" name="num_socio" placeholder="N° de Socio Cineplanet" required>
                <p class="opcional">DNI, RUT, CE o Pasaporte.</p>
                <input type="password" name="contrasenia" placeholder=Contraseña required>
            </div>

            <div class=add>
                <a href="#">Olvidaste tu contraseña?</a>
            </div>

            <div class=boton>
                <input type="submit" value="Ingresar">
            </div>
            <span><b>¿No eres socio?</b></span>
            <p>Registrándote en nuestro programa Socio Cineplanet podrás acumular <br>puntos en cada visita que realices y gozar de grandes beneficios.</p>
            <div class="submit">
                <input type="submit" value="Unete">
            </div>
        </form>
    </div>
</body>
</html>