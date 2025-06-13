<?php
    session_start();
    if (isset($_SESSION['numero_documento'])) {
        header('Location: inicio.php');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $apellido_paterno = $_POST['apellido_paterno'];
        $apellido_materno = $_POST['apellido_materno'];
        $correo = $_POST['correo'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $tipo_documento = $_POST['tipo_documento'];
        $DNI = $_POST['numero_documento'];
        $dv = $_POST['dv'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $celular = $_POST['celular'];
        $departamento = $_POST['departamento'];
        $provincia = $_POST['provincia'];
        $distrito = $_POST['distrito'];
        $cineplanet = isset($_POST['cineplanet']);
        $genero = $_POST['genero'];

        $errores='';
        try {
            $conexion = new PDO('mysql:host=127.0.0.1:3307;dbname=','root','');

            
        } catch (PDOException $e) {
            echo 'Error de conexión: ' . $e->getMessage();
        }
        $statement= $conexion->prepare('SELECT *  FROM cliente_registrado WHERE DNI = :dni LIMIT 1');
        $statement->execute(array(':dni' => $DNI));
        $resultado= $statement->fetch();

        if($resultado != false){
            $errores .= "El usuario ya está registrado. <br>";
        }
        $password=hash('sha512', $password); 
        $confirm_password=hash('sha512', $confirm_password);
        if ($password !== $confirm_password) {
            $errores .= "Las contraseñas no coinciden. <br>";
        }
        if (empty($errores)) {
            $statement = $conexion->prepare('INSERT INTO cliente_registrado (nombre, apellido_paterno, apellido_materno, correo, password, tipo_documento, DNI, dv, fecha_nacimiento, celular, departamento, provincia, distrito, cineplanet, genero) VALUES (:nombre, :apellido_paterno, :apellido_materno, :correo, :password, :tipo_documento, :dni, :dv, :fecha_nacimiento, :celular, :departamento, :provincia, :distrito, :cineplanet, :genero)');
            $statement->execute(array(
                ':nombre' => $nombre,
                ':apellido_paterno' => $apellido_paterno,
                ':apellido_materno' => $apellido_materno,
                ':correo' => $correo,
                ':password' => $password,
                ':tipo_documento' => $tipo_documento,
                ':dni' => $DNI,
                ':dv' => $dv,
                ':fecha_nacimiento' => $fecha_nacimiento,
                ':celular' => $celular,
                ':departamento' => $departamento,
                ':provincia' => $provincia,
                ':distrito' => $distrito,
                ':cineplanet' => $cineplanet,
                ':genero' => $genero
            ));
            header('Location: login.php');
        } else {
            echo "<div class='error'>$errores</div>";
        }

    }
    require 'Registrate.php';
?>