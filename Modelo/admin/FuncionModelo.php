<?php
class FuncionModelo {
    private $db;
    
    public function __construct() {
        require_once __DIR__ . '/../../config/db.php';
        $this->db = conectarBD();
    }
    
    public function obtenerTodas() {
        $sql = "SELECT 
                    f.id,
                    f.id_pelicula,
                    f.id_sala,
                    f.fecha,
                    f.hora,
                    f.precio,
                    COALESCE(p.titulo, 'Sin película') as pelicula,
                    COALESCE(s.id_sala, 'Sin sala') as sala,
                    COALESCE(s.formato, '') as formato,
                    COALESCE(c.CP_nombre, '') as cine
                FROM funcion f 
                LEFT JOIN peliculas p ON f.id_pelicula = p.id 
                LEFT JOIN SALA s ON f.id_sala = s.id_sala 
                LEFT JOIN CINE c ON s.id_cine = c.id_cine
                ORDER BY f.fecha DESC, f.hora DESC";
        
        try {
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error en obtenerTodas: " . $e->getMessage());
            $sql_simple = "SELECT id, id_pelicula, id_sala, fecha, hora, precio FROM funcion ORDER BY fecha DESC, hora DESC";
            $stmt = $this->db->query($sql_simple);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    
    public function obtenerPorId($id) {
        $sql = "SELECT 
                    f.*,
                    p.titulo as pelicula,
                    p.genero,
                    p.duracion,
                    s.id_sala as sala,
                    s.formato,
                    s.capacidad,
                    c.CP_nombre as cine_nombre
                FROM funcion f 
                LEFT JOIN peliculas p ON f.id_pelicula = p.id 
                LEFT JOIN SALA s ON f.id_sala = s.id_sala 
                LEFT JOIN CINE c ON s.id_cine = c.id_cine
                WHERE f.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function obtenerSalas() {
        $sql = "SELECT 
                    s.id_sala, 
                    s.capacidad, 
                    s.formato,
                    c.CP_nombre as cine_nombre
                FROM SALA s 
                LEFT JOIN CINE c ON s.id_cine = c.id_cine 
                ORDER BY s.id_sala";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function crear($datos) {
        try {
            $this->db->beginTransaction();
            
            // 1. Insertar la función
            $sql = "INSERT INTO funcion (id_pelicula, id_sala, fecha, hora, precio) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $datos['id_pelicula'],
                $datos['id_sala'],
                $datos['fecha'],
                $datos['hora'],
                $datos['precio']
            ]);
            
            // 2. Obtener el ID de la función recién creada
            $funcion_id = $this->db->lastInsertId();
            
            // 3. Crear automáticamente 30 asientos (5 filas x 6 asientos)
            $filas = ['A', 'B', 'C', 'D', 'E'];
            $asientos_por_fila = 6;
            
            $sql_asiento = "INSERT INTO asientos (funcion_id, fila, numero, estado) VALUES (?, ?, ?, 'libre')";
            $stmt_asiento = $this->db->prepare($sql_asiento);
            
            foreach ($filas as $fila) {
                for ($numero = 1; $numero <= $asientos_por_fila; $numero++) {
                    $stmt_asiento->execute([$funcion_id, $fila, $numero]);
                }
            }
            
            $this->db->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    
    public function actualizar($id, $datos) {
        $sql = "UPDATE funcion SET id_pelicula=?, id_sala=?, fecha=?, hora=?, precio=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $datos['id_pelicula'],
            $datos['id_sala'],
            $datos['fecha'],
            $datos['hora'],
            $datos['precio'],
            $id
        ]);
    }
    
    public function eliminar($id) {
    // ⚡ MUCHO MÁS SIMPLE - Una sola consulta
    $sql = "DELETE FROM funcion WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$id]);
    // Los asientos se eliminan automáticamente por CASCADE
}
    
    // Método para debug - verificar datos
    public function verificarDatos() {
        $resultado = [];
        
        // Contar funciones
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM funcion");
        $resultado['funciones'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Contar películas
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM peliculas");
        $resultado['peliculas'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Contar salas
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM SALA");
        $resultado['salas'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Verificar relaciones
        $stmt = $this->db->query("SELECT f.id, f.id_pelicula, p.titulo FROM funcion f LEFT JOIN peliculas p ON f.id_pelicula = p.id LIMIT 5");
        $resultado['relaciones'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $resultado;
    }
    
    // Método adicional para contar asientos de una función
    public function contarAsientos($funcion_id) {
        $sql = "SELECT COUNT(*) as total FROM asientos WHERE funcion_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$funcion_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function contarTotal() {
        $sql = "SELECT COUNT(*) as total FROM funcion";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    
    // Método adicional para estadísticas más detalladas
    public function obtenerEstadisticas() {
        $stats = [];
        
        // Total de funciones
        $sql = "SELECT COUNT(*) as total FROM funcion";
        $stmt = $this->db->query($sql);
        $stats['total'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Funciones de hoy
        $sql = "SELECT COUNT(*) as hoy FROM funcion WHERE fecha = CURDATE()";
        $stmt = $this->db->query($sql);
        $stats['hoy'] = $stmt->fetch(PDO::FETCH_ASSOC)['hoy'];
        
        // Funciones futuras
        $sql = "SELECT COUNT(*) as futuras FROM funcion WHERE fecha > CURDATE()";
        $stmt = $this->db->query($sql);
        $stats['futuras'] = $stmt->fetch(PDO::FETCH_ASSOC)['futuras'];
        
        return $stats;
    }
}
?>