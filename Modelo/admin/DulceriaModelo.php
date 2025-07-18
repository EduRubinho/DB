<?php
class DulceriaModelo {
    private $db;
    
    public function __construct() {
        require_once __DIR__ . '/../../Config/db.php';
        $this->db = conectarBD();
    }
    
    public function obtenerTodos() {
        $sql = "SELECT * FROM productos_dulceria ORDER BY id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM productos_dulceria WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function crear($datos) {
        $sql = "INSERT INTO productos_dulceria (nombre, precio, imagen, categoria) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $datos['nombre'],
            $datos['precio'],
            $datos['imagen'],
            $datos['categoria']
        ]);
    }
    
    public function actualizar($id, $datos) {
        $sql = "UPDATE productos_dulceria SET nombre=?, precio=?, categoria=?";
        $params = [$datos['nombre'], $datos['precio'], $datos['categoria']];
        
        if (!empty($datos['imagen'])) {
            $sql .= ", imagen=?";
            $params[] = $datos['imagen'];
        }
        
        $sql .= " WHERE id=?";
        $params[] = $id;
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
    
    public function eliminar($id) {
        $sql = "DELETE FROM productos_dulceria WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    public function contarTotal() {
        $sql = "SELECT COUNT(*) as total FROM productos_dulceria";
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
?>