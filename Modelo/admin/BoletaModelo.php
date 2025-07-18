<?php
class BoletaModelo {
    private $db;
    
    public function __construct() {
        require_once __DIR__ . '/../../Config/db.php';
        $this->db = conectarBD();
    }
    
    public function obtenerTodas($limit = 50, $offset = 0) {
        // Convertir a enteros para evitar el error
        $limit = (int)$limit;
        $offset = (int)$offset;
        
        $sql = "SELECT 
                    b.id,
                    b.fecha,
                    b.total,
                    b.id_cliente,
                    COALESCE(cr.nombre, i.nombre_invitado, 'Cliente N/A') as cliente_nombre,
                    COALESCE(cr.apellido_paterno, '') as cliente_apellido,
                    COALESCE(cr.correo, 'N/A') as cliente_correo,
                    COUNT(r.id) as total_asientos
                FROM BOLETA b
                LEFT JOIN CLIENTE_REGISTRADO cr ON b.id_cliente = cr.id
                LEFT JOIN INVITADO i ON b.id_cliente = i.id_temp
                LEFT JOIN reservas r ON b.id = r.boleta_id
                GROUP BY b.id, b.fecha, b.total, b.id_cliente, cliente_nombre, cliente_apellido, cliente_correo
                ORDER BY b.fecha DESC, b.id DESC
                LIMIT $limit OFFSET $offset";
        
        try {
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Fallback con query más simple
            $sql_simple = "SELECT 
                            b.id,
                            b.fecha,
                            b.total,
                            b.id_cliente,
                            'Cliente' as cliente_nombre,
                            '' as cliente_apellido,
                            'N/A' as cliente_correo,
                            0 as total_asientos
                        FROM BOLETA b
                        ORDER BY b.fecha DESC, b.id DESC
                        LIMIT $limit OFFSET $offset";
            
            $stmt = $this->db->query($sql_simple);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    
    public function obtenerPorId($id) {
        $sql = "SELECT 
                    b.*,
                    COALESCE(cr.nombre, i.nombre_invitado, 'Cliente N/A') as cliente_nombre,
                    COALESCE(cr.apellido_paterno, '') as cliente_apellido,
                    COALESCE(cr.correo, 'N/A') as cliente_correo,
                    COALESCE(cr.celular, 'N/A') as cliente_celular
                FROM BOLETA b
                LEFT JOIN CLIENTE_REGISTRADO cr ON b.id_cliente = cr.id
                LEFT JOIN INVITADO i ON b.id_cliente = i.id_temp
                WHERE b.id = ?";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Fallback simple
            $sql_simple = "SELECT *, 'Cliente' as cliente_nombre, '' as cliente_apellido, 'N/A' as cliente_correo, 'N/A' as cliente_celular FROM BOLETA WHERE id = ?";
            $stmt = $this->db->prepare($sql_simple);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
    
    public function obtenerAsientosBoleta($boleta_id) {
        $sql = "SELECT 
                    a.fila,
                    a.numero,
                    f.fecha,
                    f.hora,
                    f.precio,
                    COALESCE(p.titulo, 'Película N/A') as pelicula,
                    f.id_sala,
                    'Estándar' as formato,
                    'Cine Central' as cine
                FROM reservas r
                INNER JOIN asientos a ON r.asiento_id = a.id
                INNER JOIN funcion f ON a.funcion_id = f.id
                LEFT JOIN peliculas p ON f.id_pelicula = p.id
                WHERE r.boleta_id = ?
                ORDER BY a.fila, a.numero";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$boleta_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }
    
    public function obtenerProductosBoleta($boleta_id) {
        $sql = "SELECT 
                    bp.cantidad,
                    bp.precio_unitario,
                    COALESCE(pd.nombre, 'Producto N/A') as nombre,
                    COALESCE(pd.categoria, 'general') as categoria,
                    (bp.cantidad * bp.precio_unitario) as subtotal
                FROM boleta_productos bp
                LEFT JOIN productos_dulceria pd ON bp.producto_id = pd.id
                WHERE bp.boleta_id = ?
                ORDER BY pd.categoria, pd.nombre";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$boleta_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }
    
    public function eliminar($id) {
        try {
            $this->db->beginTransaction();
            
            // Eliminar productos de boleta (si existe la tabla)
            try {
                $sql = "DELETE FROM boleta_productos WHERE boleta_id = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$id]);
            } catch (Exception $e) {
                // Tabla no existe, continuar
            }
            
            // Eliminar reservas (si existe la tabla)
            try {
                $sql = "DELETE FROM reservas WHERE boleta_id = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$id]);
            } catch (Exception $e) {
                // Tabla no existe, continuar
            }
            
            // Eliminar boleta
            $sql = "DELETE FROM BOLETA WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$id]);
            
            $this->db->commit();
            return $result;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    
    public function contarTotal() {
        try {
            $sql = "SELECT COUNT(*) as total FROM BOLETA";
            $stmt = $this->db->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }
    
    public function obtenerEstadisticas() {
        $stats = [
            'hoy' => ['total' => 0, 'ingresos' => 0],
            'mes' => ['total' => 0, 'ingresos' => 0],
            'pelicula_top' => ['titulo' => 'N/A', 'ventas' => 0]
        ];
        
        try {
            // Estadísticas de hoy
            $sql = "SELECT COUNT(*) as total, COALESCE(SUM(total), 0) as ingresos 
                    FROM BOLETA 
                    WHERE DATE(fecha) = CURDATE()";
            $stmt = $this->db->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $stats['hoy'] = [
                    'total' => $result['total'] ?? 0,
                    'ingresos' => $result['ingresos'] ?? 0
                ];
            }
            
            // Estadísticas del mes
            $sql = "SELECT COUNT(*) as total, COALESCE(SUM(total), 0) as ingresos 
                    FROM BOLETA 
                    WHERE MONTH(fecha) = MONTH(CURDATE()) AND YEAR(fecha) = YEAR(CURDATE())";
            $stmt = $this->db->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $stats['mes'] = [
                    'total' => $result['total'] ?? 0,
                    'ingresos' => $result['ingresos'] ?? 0
                ];
            }
            
        } catch (Exception $e) {
            // Mantener valores por defecto
        }
        
        return $stats;
    }
    
    public function buscarPorFecha($fecha_inicio, $fecha_fin) {
        try {
            $sql = "SELECT 
                        b.id,
                        b.fecha,
                        b.total,
                        b.id_cliente,
                        COALESCE(cr.nombre, 'Cliente') as cliente_nombre,
                        COALESCE(cr.apellido_paterno, '') as cliente_apellido,
                        COALESCE(cr.correo, 'N/A') as cliente_correo,
                        0 as total_asientos
                    FROM BOLETA b
                    LEFT JOIN CLIENTE_REGISTRADO cr ON b.id_cliente = cr.id
                    WHERE DATE(b.fecha) BETWEEN ? AND ?
                    ORDER BY b.fecha DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$fecha_inicio, $fecha_fin]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }
}
?>