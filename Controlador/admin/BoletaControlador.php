<?php
require_once __DIR__ . '/../../Modelo/admin/BoletaModelo.php';

class BoletaControlador {
    private $modelo;
    
    public function __construct() {
        $this->modelo = new BoletaModelo();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['accion'] ?? '';
            switch ($accion) {
                case 'eliminar':
                    $this->eliminar();
                    break;
            }
        }
    }
    
    public function obtenerTodas($page = 1, $per_page = 20) {
        // Asegurar que sean enteros
        $page = max(1, (int)$page);
        $per_page = max(5, min(100, (int)$per_page)); // Entre 5 y 100
        $offset = ($page - 1) * $per_page;
        
        return $this->modelo->obtenerTodas($per_page, $offset);
    }
    
    public function obtenerPorId($id) {
        return $this->modelo->obtenerPorId($id);
    }
    
    public function obtenerAsientosBoleta($boleta_id) {
        return $this->modelo->obtenerAsientosBoleta($boleta_id);
    }
    
    public function obtenerProductosBoleta($boleta_id) {
        return $this->modelo->obtenerProductosBoleta($boleta_id);
    }
    
    public function contarTotal() {
        return $this->modelo->contarTotal();
    }
    
    public function obtenerEstadisticas() {
        return $this->modelo->obtenerEstadisticas();
    }
    
    public function buscarPorFecha($fecha_inicio, $fecha_fin) {
        return $this->modelo->buscarPorFecha($fecha_inicio, $fecha_fin);
    }
    
    private function eliminar() {
        try {
            $id = (int)$_POST['id'];
            
            if ($this->modelo->eliminar($id)) {
                $_SESSION['mensaje'] = 'Boleta eliminada exitosamente';
            } else {
                $_SESSION['errores'] = 'Error al eliminar boleta';
            }
        } catch (Exception $e) {
            $_SESSION['errores'] = 'Error: ' . $e->getMessage();
        }
        header('Location: ../../Vista/admin/boleta/index.php');
        exit;
    }
}

if (basename($_SERVER['PHP_SELF']) === 'BoletaControlador.php') {
    new BoletaControlador();
}
?>