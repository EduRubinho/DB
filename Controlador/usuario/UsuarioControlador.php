<?php
session_start();
require_once __DIR__ . '/../../Modelo/usuario/UsuarioModelo.php';

$modelo = new UsuarioModelo();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'registro') {
        $dni = $_POST['numero_documento'];
        $errores = '';

        if ($modelo->usuarioExiste($dni)) {
            $errores .= "El usuario ya está registrado.<br>";
        }

        if ($_POST['password'] !== $_POST['confirm_password']) {
            $errores .= "Las contraseñas no coinciden.<br>";
        }

        if (empty($errores)) {
            $passwordHashed = hash('sha512', $_POST['password']);

            $datos = [
                'nombre' => $_POST['nombre'],
                'apellido_paterno' => $_POST['apellido_paterno'],
                'apellido_materno' => $_POST['apellido_materno'],
                'correo' => $_POST['correo'],
                'password' => $passwordHashed,
                'tipo_documento' => $_POST['tipo_documento'],
                'DNI' => $dni,
                'dv' => $_POST['dv'],
                'fecha_nacimiento' => $_POST['fecha_nacimiento'],
                'celular' => $_POST['celular'],
                'departamento' => $_POST['departamento'],
                'provincia' => $_POST['provincia'],
                'distrito' => $_POST['distrito'],
                'cineplanet' => $_POST['cineplanet_favorito'] ?? '',
                'genero' => $_POST['genero']
            ];

            $modelo->registrarCliente($datos);
            header('Location: ../../Vista/usuario/login.php');
            exit();
        } else {
            $_SESSION['errores'] = $errores;
            header('Location: ../../Vista/usuario/registro.php');
            exit();
        }

    } elseif ($accion === 'login') {
        $dni = $_POST['nrosocio'];
        $password = hash('sha512', $_POST['password']);

        $usuario = $modelo->login($dni, $password);

        if ($usuario) {
            $_SESSION['usuario'] = $usuario;
            header('Location: ../../Vista/web/inicio.php');
            exit();
        } else {
            $_SESSION['errores'] = 'El usuario o la contraseña son incorrectos.';
            header('Location: ../../Vista/usuario/login.php');
            exit();
        }
    }
}
