<?php
require_once __DIR__ . '/../../config/db.php';

class ReservaModelo {
    private $db;

    public function __construct() {
        $this->db = conectarBD();
    }

    public function reservarMultiplesAsientos($usuario_id, $asientos_ids, $precio_unitario) {
        try {
            $this->db->beginTransaction();
            
            // Verificar disponibilidad
            foreach ($asientos_ids as $asiento_id) {
                $stmt = $this->db->prepare("SELECT COUNT(*) FROM reservas WHERE asiento_id = ?");
                $stmt->execute([$asiento_id]);
                if ($stmt->fetchColumn() > 0) {
                    throw new Exception("El asiento ID $asiento_id ya está reservado");
                }
            }
            
            // Crear boleta
            $total = count($asientos_ids) * $precio_unitario;
            $stmt = $this->db->prepare("INSERT INTO BOLETA (fecha, id_cliente, total) VALUES (NOW(), ?, ?)");
            $stmt->execute([$usuario_id, $total]);
            $boleta_id = $this->db->lastInsertId();
            
            // Crear reservas
            foreach ($asientos_ids as $asiento_id) {
                $stmt = $this->db->prepare("INSERT INTO reservas (usuario_id, asiento_id, boleta_id) VALUES (?, ?, ?)");
                $stmt->execute([$usuario_id, $asiento_id, $boleta_id]);
            }
            
            $this->db->commit();
            return $boleta_id;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function obtenerBoletasPorUsuario($usuario_id) {
        $stmt = $this->db->prepare("
            SELECT 
                b.id,
                b.fecha,
                b.total,
                p.id as pelicula_id,
                p.titulo as pelicula_titulo,
                p.genero,
                p.duracion,
                f.fecha as fecha_funcion,
                f.hora as hora_funcion,
                s.formato as sala_nombre,
                COUNT(r.id) as cantidad_asientos,
                GROUP_CONCAT(
                    CONCAT('Fila ', a.fila, '-', a.numero) 
                    ORDER BY a.fila, a.numero 
                    SEPARATOR ', '
                ) as asientos
            FROM BOLETA b
            JOIN reservas r ON b.id = r.boleta_id
            JOIN asientos a ON r.asiento_id = a.id
            JOIN funcion f ON a.funcion_id = f.id
            JOIN peliculas p ON f.id_pelicula = p.id
            JOIN SALA s ON f.id_sala = s.id_sala
            WHERE b.id_cliente = ?
            GROUP BY b.id, p.id, f.id
            ORDER BY b.fecha DESC
        ");
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerBoletaPorId($boleta_id) {
        $stmt = $this->db->prepare("
            SELECT 
                b.*,
                cr.nombre,
                cr.apellido_paterno,
                cr.apellido_materno,
                cr.DNI,
                cr.correo
            FROM BOLETA b
            JOIN CLIENTE_REGISTRADO cr ON b.id_cliente = cr.id
            WHERE b.id = ?
        ");
        $stmt->execute([$boleta_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerAsientosPorBoleta($boleta_id) {
        $stmt = $this->db->prepare("
            SELECT 
                a.fila,
                a.numero,
                f.fecha,
                f.hora,
                f.precio,
                p.titulo as pelicula_titulo,
                s.formato as sala_nombre
            FROM reservas r
            JOIN asientos a ON r.asiento_id = a.id
            JOIN funcion f ON a.funcion_id = f.id
            JOIN peliculas p ON f.id_pelicula = p.id
            JOIN SALA s ON f.id_sala = s.id_sala
            WHERE r.boleta_id = ?
        ");
        $stmt->execute([$boleta_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductosPorBoleta($boleta_id) {
        $sql = "SELECT bp.*, pd.nombre as producto_nombre, pd.categoria
                FROM boleta_productos bp
                INNER JOIN productos_dulceria pd ON bp.producto_id = pd.id
                WHERE bp.boleta_id = ?
                ORDER BY pd.categoria, pd.nombre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$boleta_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerTotalBoleta($boleta_id) {
    // Total de asientos - CORREGIDO
    $sql_asientos = "SELECT COUNT(r.id) as cantidad_asientos, f.precio
                    FROM reservas r
                    INNER JOIN asientos a ON r.asiento_id = a.id
                    INNER JOIN funcion f ON a.funcion_id = f.id
                    WHERE r.boleta_id = ?
                    GROUP BY f.precio";
    
    // Total de productos
    $sql_productos = "SELECT COALESCE(SUM(bp.cantidad * bp.precio_unitario), 0) as total_productos
                     FROM boleta_productos bp
                     WHERE bp.boleta_id = ?";
    
    $stmt1 = $this->db->prepare($sql_asientos);
    $stmt1->execute([$boleta_id]);
    $asientos_data = $stmt1->fetch(PDO::FETCH_ASSOC);
    
    // Calcular correctamente: cantidad × precio
    $total_asientos = 0;
    if ($asientos_data) {
        $total_asientos = $asientos_data['cantidad_asientos'] * $asientos_data['precio'];
    }
    
    $stmt2 = $this->db->prepare($sql_productos);
    $stmt2->execute([$boleta_id]);
    $total_productos = $stmt2->fetch(PDO::FETCH_ASSOC)['total_productos'] ?? 0;
    
    return [
        'total_asientos' => (float)$total_asientos,
        'total_productos' => (float)$total_productos,
        'total_general' => (float)$total_asientos + (float)$total_productos
    ];
}
}