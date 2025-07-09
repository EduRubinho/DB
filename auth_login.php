<?php
    session_start();
    if (isset($_SESSION['numero_documento'])) {
        header('Location: inicio.php');
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nrosocio = $_POST['nrosocio'];
        $password = $_POST['password'];
        $password = hash('sha512', $password);
        $errores = '';
        try {
            $conexion = new PDO('mysql:host=127.0.0.1:3307;dbname=cineplanet','root','');
        } catch (PDOException $e) {
            echo 'Error de conexión: ' . $e->getMessage();
        }
        
        

        $statement = $conexion->prepare('SELECT * FROM cliente_registrado WHERE DNI = :dni AND password = :password LIMIT 1');
        $statement->execute(array(':dni' => $nrosocio, ':password' => $password));
        $resultado = $statement->fetch();

        if ($resultado !== false) {
    $_SESSION['numero_documento'] = $nrosocio;
    header('Location: inicio.php');
} else {
    $errores .= "El usuario o la contraseña son incorrectos.";
    echo $errores; // <-- agrega esto temporalmente
}
    }
    require 'login.php';
?>