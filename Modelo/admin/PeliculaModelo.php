<?php
class PeliculaModelo {
    private $db;
    
    public function __construct() {
        require_once __DIR__ . '/../../config/db.php';
        $this->db = conectarBD();
    }
    
    public function obtenerTodas() {
        $sql = "SELECT * FROM peliculas ORDER BY id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM peliculas WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function crear($datos) {
        $sql = "INSERT INTO peliculas (titulo, descripcion, genero, duracion, director, fecha_estreno, imagen, clasificacion, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $datos['titulo'],
            $datos['descripcion'] ?? '',
            $datos['genero'],
            $datos['duracion'],
            $datos['director'] ?? '',
            $datos['fecha_estreno'] ?? null,
            $datos['imagen'] ?? '',
            $datos['clasificacion'],
            $datos['estado']
        ]);
    }
    
    public function actualizar($id, $datos) {
        $sql = "UPDATE peliculas SET titulo=?, descripcion=?, genero=?, duracion=?, director=?, fecha_estreno=?, clasificacion=?, estado=?";
        $parametros = [
            $datos['titulo'],
            $datos['descripcion'] ?? '',
            $datos['genero'],
            $datos['duracion'],
            $datos['director'] ?? '',
            $datos['fecha_estreno'] ?? null,
            $datos['clasificacion'],
            $datos['estado']
        ];
        
        if (!empty($datos['imagen'])) {
            $sql .= ", imagen=?";
            $parametros[] = $datos['imagen'];
        }
        
        $sql .= " WHERE id=?";
        $parametros[] = $id;
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($parametros);
    }
    
    public function eliminar($id) {
        $sql = "DELETE FROM peliculas WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    public function buscar($termino) {
        $sql = "SELECT * FROM peliculas WHERE titulo LIKE ? OR genero LIKE ? ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $termino = "%{$termino}%";
        $stmt->execute([$termino, $termino]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function contarTotal() {
        $sql = "SELECT COUNT(*) as total FROM peliculas";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    
    public function obtenerActivas() {
        $sql = "SELECT * FROM peliculas WHERE estado = 'activa' ORDER BY fecha_estreno DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function eliminarDependencias($id) {
    try {
        $this->db->beginTransaction();
        
        // Eliminar reservas relacionadas con funciones de esta película
        $sql = "DELETE r FROM reservas r 
                INNER JOIN asientos a ON r.asiento_id = a.id 
                INNER JOIN funcion f ON a.funcion_id = f.id 
                WHERE f.id_pelicula = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        
        // Eliminar asientos de funciones de esta película
        $sql = "DELETE a FROM asientos a 
                INNER JOIN funcion f ON a.funcion_id = f.id 
                WHERE f.id_pelicula = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        
        // Eliminar funciones de esta película
        $sql = "DELETE FROM funcion WHERE id_pelicula = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        
        // Eliminar relación cine-película
        $sql = "DELETE FROM CINE_PELICULA WHERE pelicula_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        
        $this->db->commit();
        return true;
    } catch (Exception $e) {
        $this->db->rollBack();
        throw $e;
    }
}
}
?>