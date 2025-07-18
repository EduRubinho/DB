<?php
require_once __DIR__ . '/../../Modelo/admin/FuncionModelo.php';

class FuncionControlador {
    private $modelo;
    
    public function __construct() {
        $this->modelo = new FuncionModelo();
        
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
            }
        }
    }
    
    public function obtenerTodas() {
        return $this->modelo->obtenerTodas();
    }
    
    public function obtenerPorId($id) {
        return $this->modelo->obtenerPorId($id);
    }
    
    public function obtenerSalas() {
        return $this->modelo->obtenerSalas();
    }
    
    // AGREGAR ESTE MÉTODO
    public function contarTotal() {
        return $this->modelo->contarTotal();
    }
    
    // AGREGAR ESTE MÉTODO TAMBIÉN
    public function obtenerEstadisticas() {
        return $this->modelo->obtenerEstadisticas();
    }
    
    // Método para debug
    public function verificarDatos() {
        return $this->modelo->verificarDatos();
    }
    
    private function crear() {
        try {
            $datos = [
                'id_pelicula' => (int)$_POST['id_pelicula'],
                'id_sala' => (int)$_POST['id_sala'],
                'fecha' => $_POST['fecha'],
                'hora' => $_POST['hora'],
                'precio' => (float)$_POST['precio']
            ];
            
            if ($this->modelo->crear($datos)) {
                $_SESSION['mensaje'] = 'Función creada exitosamente (con 30 asientos automáticos)';
                header('Location: ../../Vista/admin/funcion/index.php');
            } else {
                $_SESSION['errores'] = 'Error al crear la función';
                header('Location: ../../Vista/admin/funcion/crear.php');
            }
        } catch (Exception $e) {
            $_SESSION['errores'] = 'Error al crear función: ' . $e->getMessage();
            header('Location: ../../Vista/admin/funcion/crear.php');
        }
        exit;
    }
    
    private function actualizar() {
        try {
            $id = (int)$_POST['id'];
            $datos = [
                'id_pelicula' => (int)$_POST['id_pelicula'],
                'id_sala' => (int)$_POST['id_sala'],
                'fecha' => $_POST['fecha'],
                'hora' => $_POST['hora'],
                'precio' => (float)$_POST['precio']
            ];
            
            if ($this->modelo->actualizar($id, $datos)) {
                $_SESSION['mensaje'] = 'Función actualizada exitosamente';
                header('Location: ../../Vista/admin/funcion/index.php');
            } else {
                $_SESSION['errores'] = 'Error al actualizar la función';
                header('Location: ../../Vista/admin/funcion/actualizar.php?id=' . $id);
            }
        } catch (Exception $e) {
            $_SESSION['errores'] = 'Error: ' . $e->getMessage();
            header('Location: ../../Vista/admin/funcion/actualizar.php?id=' . ($_POST['id'] ?? 0));
        }
        exit;
    }
    
   private function eliminar() {
    try {
        $id = (int)$_POST['id'];
        
        // ⚡ YA NO NECESITAS eliminar asientos manualmente
        // El CASCADE se encarga automáticamente
        if ($this->modelo->eliminar($id)) {
            $_SESSION['mensaje'] = 'Función eliminada exitosamente (incluyendo asientos)';
        } else {
            $_SESSION['errores'] = 'Error al eliminar la función';
        }
        
        header('Location: ../../Vista/admin/funcion/index.php');
    } catch (Exception $e) {
        $_SESSION['errores'] = 'Error: ' . $e->getMessage();
        header('Location: ../../Vista/admin/funcion/index.php');
    }
    exit;
}
}

if (basename($_SERVER['PHP_SELF']) === 'FuncionControlador.php') {
    new FuncionControlador();
}
?>