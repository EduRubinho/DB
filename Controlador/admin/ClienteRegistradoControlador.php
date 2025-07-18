<?php
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../Modelo/admin/ClienteRegistradoModelo.php';

class ClienteRegistradoControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new ClienteRegistradoModelo();
    }

    public function verificarAdmin() {
        if (!isset($_SESSION['admin'])) {
            header('Location: ../../Vista/admin/login_admin.php');
            exit;
        }
    }

    public function procesarAccion() {
        $this->verificarAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['accion'] ?? '';
            
            switch ($accion) {
                case 'crear':
                    $this->crear();
                    break;
                case 'actualizar':
                    $this->actualizar();
                    break;
                case 'eliminar':
                    $this->eliminar();
                    break;
                default:
                    header('Location: ../../Vista/admin/cliente_registrado/index.php');
                    break;
            }
        }
    }

    private function crear() {
        $errores = $this->validarDatos($_POST);
        
        if (!empty($errores)) {
            $_SESSION['errores'] = implode('<br>', $errores);
            header('Location: ../../Vista/admin/cliente_registrado/crear.php');
            exit;
        }

        $datos = [
            'nombre' => $_POST['nombre'],
            'apellido_paterno' => $_POST['apellido_paterno'],
            'apellido_materno' => $_POST['apellido_materno'],
            'correo' => $_POST['correo'],
            'password' => hash('sha512', $_POST['password']),
            'tipo_documento' => $_POST['tipo_documento'],
            'DNI' => $_POST['DNI'],
            'dv' => $_POST['dv'] ?? '',
            'fecha_nacimiento' => $_POST['fecha_nacimiento'],
            'celular' => $_POST['celular'],
            'departamento' => $_POST['departamento'],
            'provincia' => $_POST['provincia'],
            'distrito' => $_POST['distrito'],
            'cineplanet' => $_POST['cineplanet'] ?? '',
            'genero' => $_POST['genero']
        ];

        try {
            $this->modelo->crear($datos);
            $_SESSION['mensaje'] = 'Cliente creado correctamente';
            header('Location: ../../Vista/admin/cliente/index.php');
        } catch (Exception $e) {
            $_SESSION['errores'] = 'Error al crear cliente: ' . $e->getMessage();
            header('Location: ../../Vista/admin/cliente/index.php');
        }
        exit;
    }

    private function actualizar() {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            $_SESSION['errores'] = 'ID no válido';
            header('Location: ../../Vista/admin/cliente_registrado/index.php');
            exit;
        }

        $errores = $this->validarDatos($_POST, $id);
        
        if (!empty($errores)) {
            $_SESSION['errores'] = implode('<br>', $errores);
            header("Location: ../../Vista/admin/cliente_registrado/editar.php?id=$id");
            exit;
        }

        $datos = [
            'nombre' => $_POST['nombre'],
            'apellido_paterno' => $_POST['apellido_paterno'],
            'apellido_materno' => $_POST['apellido_materno'],
            'correo' => $_POST['correo'],
            'tipo_documento' => $_POST['tipo_documento'],
            'DNI' => $_POST['DNI'],
            'dv' => $_POST['dv'] ?? '',
            'fecha_nacimiento' => $_POST['fecha_nacimiento'],
            'celular' => $_POST['celular'],
            'departamento' => $_POST['departamento'],
            'provincia' => $_POST['provincia'],
            'distrito' => $_POST['distrito'],
            'cineplanet' => $_POST['cineplanet'] ?? '',
            'genero' => $_POST['genero']
        ];

        try {
            $this->modelo->actualizar($id, $datos);
            $_SESSION['mensaje'] = 'Cliente actualizado correctamente';
            header('Location: ../../Vista/admin/cliente/index.php');
        } catch (Exception $e) {
            $_SESSION['errores'] = 'Error al actualizar cliente: ' . $e->getMessage();
            header('Location: ../../Vista/admin/cliente/index.php');
        }
        exit;
    }

    private function eliminar() {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            $_SESSION['errores'] = 'ID no válido';
            header('Location: ../../Vista/admin/cliente/index.php');
            exit;
        }

        try {
            $this->modelo->eliminar($id);
            $_SESSION['mensaje'] = 'Cliente eliminado correctamente';
        } catch (Exception $e) {
            $_SESSION['errores'] = 'Error al eliminar cliente: ' . $e->getMessage();
        }
        
            header('Location: ../../Vista/admin/cliente/index.php');
        exit;
    }

    private function validarDatos($datos, $excluir_id = null) {
        $errores = [];

        if (empty($datos['nombre'])) {
            $errores[] = 'El nombre es obligatorio';
        }

        if (empty($datos['apellido_paterno'])) {
            $errores[] = 'El apellido paterno es obligatorio';
        }

        if (empty($datos['correo']) || !filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'El correo es obligatorio y debe ser válido';
        }

        if (empty($datos['DNI'])) {
            $errores[] = 'El DNI es obligatorio';
        } elseif ($this->modelo->dniExiste($datos['DNI'], $excluir_id)) {
            $errores[] = 'El DNI ya está registrado';
        }

        if (!$excluir_id && empty($datos['password'])) {
            $errores[] = 'La contraseña es obligatoria';
        }

        return $errores;
    }

    public function obtenerTodos($page = 1, $per_page = 20) {
        $offset = ($page - 1) * $per_page;
        return $this->modelo->obtenerTodos($per_page, $offset);
    }

    public function obtenerPorId($id) {
        return $this->modelo->obtenerPorId($id);
    }

    public function buscar($termino) {
        return $this->modelo->buscar($termino);
    }

    public function contarTotal() {
        return $this->modelo->contarTotal();
    }
}

// Ejecutar si es llamada directa
if (basename($_SERVER['PHP_SELF']) === 'ClienteRegistradoControlador.php') {
    $controlador = new ClienteRegistradoControlador();
    $controlador->procesarAccion();
}