<?php
require_once __DIR__ . '/../../Modelo\admin\DulceriaModelo.php';

class DulceriaControlador {
    private $modelo;
    
    public function __construct() {
        $this->modelo = new DulceriaModelo();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['accion'] ?? '';
            switch ($accion) {
                case 'crear': $this->crear(); break;
                case 'actualizar': $this->actualizar(); break;
                case 'eliminar': $this->eliminar(); break;
            }
        }
    }
    
    public function obtenerTodos() {
        return $this->modelo->obtenerTodos();
    }
    
    public function obtenerPorId($id) {
        return $this->modelo->obtenerPorId($id);
    }
    
    public function contarTotal() {
        return $this->modelo->contarTotal();
    }
    
    private function crear() {
        try {
            $imagen = $this->procesarImagen();
            
            $datos = [
                'nombre' => trim($_POST['nombre']),
                'precio' => (float)$_POST['precio'],
                'imagen' => $imagen,
                'categoria' => $_POST['categoria']
            ];
            
            if ($this->modelo->crear($datos)) {
                $_SESSION['mensaje'] = 'Producto creado exitosamente';
            } else {
                $_SESSION['errores'] = 'Error al crear producto';
            }
        } catch (Exception $e) {
            $_SESSION['errores'] = 'Error: ' . $e->getMessage();
        }
        header('Location: ../../Vista/admin/dulceria/index.php');
        exit;
    }
    
    private function actualizar() {
        try {
            $id = (int)$_POST['id'];
            $actual = $this->modelo->obtenerPorId($id);
            $imagen = $this->procesarImagen($actual['imagen'] ?? '');
            
            $datos = [
                'nombre' => trim($_POST['nombre']),
                'precio' => (float)$_POST['precio'],
                'imagen' => $imagen,
                'categoria' => $_POST['categoria']
            ];
            
            if ($this->modelo->actualizar($id, $datos)) {
                $_SESSION['mensaje'] = 'Producto actualizado exitosamente';
            } else {
                $_SESSION['errores'] = 'Error al actualizar producto';
            }
        } catch (Exception $e) {
            $_SESSION['errores'] = 'Error: ' . $e->getMessage();
        }
        header('Location: ../../Vista/admin/dulceria/index.php');
        exit;
    }
    
    private function eliminar() {
        try {
            $id = (int)$_POST['id'];
            
            if ($this->modelo->eliminar($id)) {
                $_SESSION['mensaje'] = 'Producto eliminado exitosamente';
            } else {
                $_SESSION['errores'] = 'Error al eliminar producto';
            }
        } catch (Exception $e) {
            $_SESSION['errores'] = 'Error: ' . $e->getMessage();
        }
        header('Location: ../../Vista/admin/dulceria/index.php');
        exit;
    }
    
    private function procesarImagen($actual = '') {
        if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] === UPLOAD_ERR_NO_FILE) {
            return $actual;
        }
        
        $tipos = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['imagen']['type'], $tipos)) {
            throw new Exception('Tipo de imagen no válido');
        }
        
        $dir = __DIR__ . '/../../uploads/dulceria/';
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        
        $nombre = uniqid('dulce_') . '.' . pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $dir . $nombre)) {
            return $nombre;
        }
        
        throw new Exception('Error al subir imagen');
    }
    
}

if (basename($_SERVER['PHP_SELF']) === 'DulceriaControlador.php') {
    new DulceriaControlador();
}
?>