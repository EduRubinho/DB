<?php
require_once __DIR__ . '/../../config/db.php';

class DulceriaModelo {
    private $conexion;

    public function __construct() {
        $this->conexion = conectarBD();
    }

    public function obtenerTodosLosProductos() {
        $sql = "SELECT * FROM productos_dulceria ORDER BY categoria, nombre";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductosPorCategoria($categoria) {
        $sql = "SELECT * FROM productos_dulceria WHERE categoria = ? ORDER BY nombre";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$categoria]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductoPorId($id) {
        $sql = "SELECT * FROM productos_dulceria WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function agregarProductosABoleta($boleta_id, $productos) {
        try {
            $this->conexion->beginTransaction();
            
            foreach ($productos as $producto) {
                $sql = "INSERT INTO boleta_productos (boleta_id, producto_id, cantidad, precio_unitario) 
                        VALUES (?, ?, ?, ?)";
                $stmt = $this->conexion->prepare($sql);
                $stmt->execute([
                    $boleta_id,
                    $producto['id'],
                    $producto['cantidad'],
                    $producto['precio']
                ]);
            }
            
            $this->conexion->commit();
            return true;
        } catch (Exception $e) {
            $this->conexion->rollBack();
            return false;
        }
    }
}