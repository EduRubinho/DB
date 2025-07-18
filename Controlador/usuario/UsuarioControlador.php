<?php
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../Modelo/usuario/UsuarioModelo.php';

class UsuarioControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new UsuarioModelo();
    }

    public function procesarAccion() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ../../Vista/usuario/login.php');
            exit;
        }

        $accion = $_POST['accion'] ?? '';

        switch ($accion) {
            case 'registro':
                $this->registrar();
                break;
            case 'login':
                $this->login();
                break;
            case 'actualizar_perfil':
                $this->actualizarPerfil();
                break;
            default:
                header('Location: ../../Vista/usuario/login.php');
                break;
        }
    }

    private function registrar() {
        $dni = $_POST['numero_documento'] ?? '';
        $errores = [];

        // Validaciones
        if (empty($dni)) {
            $errores[] = "El DNI es obligatorio";
        }

        if ($this->modelo->usuarioExiste($dni)) {
            $errores[] = "El usuario ya está registrado";
        }

        if ($_POST['password'] !== $_POST['confirm_password']) {
            $errores[] = "Las contraseñas no coinciden";
        }

        if (!empty($errores)) {
            $_SESSION['errores'] = implode('<br>', $errores);
            header('Location: ../../Vista/usuario/registro.php');
            exit;
        }

        $datos = [
            'nombre' => $_POST['nombre'],
            'apellido_paterno' => $_POST['apellido_paterno'],
            'apellido_materno' => $_POST['apellido_materno'],
            'correo' => $_POST['correo'],
            'password' => hash('sha512', $_POST['password']),
            'tipo_documento' => $_POST['tipo_documento'],
            'DNI' => $dni,
            'dv' => $_POST['dv'] ?? '',
            'fecha_nacimiento' => $_POST['fecha_nacimiento'],
            'celular' => $_POST['celular'],
            'departamento' => $_POST['departamento'],
            'provincia' => $_POST['provincia'],
            'distrito' => $_POST['distrito'],
            'cineplanet' => $_POST['cineplanet_favorito'] ?? '',
            'genero' => $_POST['genero']
        ];

        try {
            $this->modelo->registrarCliente($datos);
            $_SESSION['mensaje'] = 'Registro exitoso. Inicia sesión.';
            header('Location: ../../Vista/usuario/login.php');
        } catch (Exception $e) {
            $_SESSION['errores'] = 'Error al registrar usuario';
            header('Location: ../../Vista/usuario/registro.php');
        }
        exit;
    }

    private function login() {
        $dni = $_POST['nrosocio'] ?? '';
        $password = hash('sha512', $_POST['password'] ?? '');

        $usuario = $this->modelo->login($dni, $password);

        if ($usuario) {
            $_SESSION['usuario'] = $usuario;
            header('Location: ../../Vista/web/inicio.php');
        } else {
            $_SESSION['errores'] = 'DNI o contraseña incorrectos';
            header('Location: ../../Vista/usuario/login.php');
        }
        exit;
    }

    private function actualizarPerfil() {
        if (!isset($_SESSION['usuario'])) {
            header('Location: ../../Vista/usuario/login.php');
            exit;
        }

        $datos = [
            'nombre' => $_POST['nombre'],
            'apellido_paterno' => $_POST['apellido_paterno'],
            'apellido_materno' => $_POST['apellido_materno'],
            'correo' => $_POST['correo'],
            'celular' => $_POST['celular'],
            'departamento' => $_POST['departamento'],
            'provincia' => $_POST['provincia'],
            'distrito' => $_POST['distrito']
        ];

        if ($this->modelo->actualizarPerfil($_SESSION['usuario']['id'], $datos)) {
            // Actualizar sesión
            $_SESSION['usuario'] = array_merge($_SESSION['usuario'], $datos);
            $_SESSION['mensaje'] = 'Perfil actualizado correctamente';
        } else {
            $_SESSION['errores'] = 'Error al actualizar perfil';
        }

        header('Location: ../../Vista/usuario/perfil.php');
        exit;
    }
}

// Ejecutar controlador
$controlador = new UsuarioControlador();
$controlador->procesarAccion();