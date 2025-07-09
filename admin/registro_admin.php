<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>Registrar Administrador</h2>

    <form action="procesar_registro_admin.php" method="POST">
        <label>Nombre completo:</label><br>
        <input type="text" name="nombre" required><br>

        <label>Usuario:</label><br>
        <input type="text" name="usuario" required><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Registrar</button>
    </form>


</body>

</html>