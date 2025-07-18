<?php
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../Modelo/usuario/DulceriaModelo.php';

class DulceriaControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new DulceriaModelo();
    }

    public function procesarAccion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['accion'] ?? '';
            
            if ($accion === 'agregar_productos') {
                $this->agregarProductos();
            }
        }
    }

    private function agregarProductos() {
        $boleta_id = $_POST['boleta_id'] ?? 0;
        $productos_seleccionados = $_POST['productos'] ?? [];
        
        if (empty($productos_seleccionados)) {
            echo "<script>
                alert('No hay productos seleccionados');
                window.location.href='../../Vista/usuario/boleta.php?id=$boleta_id';
            </script>";
            exit;
        }

        $productos = [];
        foreach ($productos_seleccionados as $producto_id => $cantidad) {
            if ($cantidad > 0) {
                $producto = $this->modelo->obtenerProductoPorId($producto_id);
                if ($producto) {
                    $productos[] = [
                        'id' => $producto_id,
                        'cantidad' => $cantidad,
                        'precio' => $producto['precio']
                    ];
                }
            }
        }

        if ($this->modelo->agregarProductosABoleta($boleta_id, $productos)) {
            echo "<script>
                alert('Productos agregados correctamente');
                window.location.href='../../Vista/usuario/boleta.php?id=$boleta_id';
            </script>";
        } else {
            echo "<script>
                alert('Error al agregar productos');
                window.history.back();
            </script>";
        }
        exit;
    }

    public function obtenerTodos() {
        return $this->modelo->obtenerTodosLosProductos();
    }

    public function obtenerPorCategoria($categoria) {
        return $this->modelo->obtenerProductosPorCategoria($categoria);
    }
}

// Ejecutar si es llamada directa
if (basename($_SERVER['PHP_SELF']) === 'DulceriaControlador.php') {
    $controlador = new DulceriaControlador();
    $controlador->procesarAccion();
}