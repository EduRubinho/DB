<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <h2>Login Administrador</h2>

    <form action="procesar_login_admin.php" method="POST">
        <label>Usuario:</label><br>
        <input type="text" name="usuario" required><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Ingresar</button>
    </form>


</body>

</html>