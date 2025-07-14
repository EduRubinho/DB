

<?php
session_start();
require_once __DIR__ . '/../../Modelo/admin/AdminModelo.php';

$modelo = new AdminModelo();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'registrar') {
        $usuario = trim($_POST['usuario']);
        $nombre = trim($_POST['nombre']);
        $password = $_POST['password'];
        $errores = '';

        if (empty($usuario) || empty($nombre) || empty($password)) {
            $errores = 'Todos los campos son obligatorios.';
        }

        if ($modelo->adminExiste($usuario)) {
            $errores .= 'El administrador ya está registrado.<br>';
        }

        if (empty($errores)) {
            $datos = [
                'usuario' => $usuario,
                'nombre' => $nombre,
                'password' => password_hash($password, PASSWORD_BCRYPT)
            ];
            $modelo->registrarAdmin($datos);
            $_SESSION['mensajes'] = 'Administrador registrado correctamente.';
            header('Location: ../../Vista/admin/login_admin.php');
            exit;
        } else {
            $_SESSION['errores'] = $errores;
            header('Location: ../../Vista/admin/registro_admin.php');
            exit;
        }

    } elseif ($accion === 'login') {
        $usuario = $_POST['usuario'] ?? '';
        $password = $_POST['password'] ?? '';
        $errores = '';

        $admin = $modelo->login($usuario);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = $admin;
            header('Location: ../../Vista/web/admin/inicioadmin.php');
            exit;
        } else {
            $_SESSION['errores'] = 'Usuario o contraseña incorrectos.';
            header('Location: ../../Vista/admin/login_admin.php');
            exit;
        }
    }
}
