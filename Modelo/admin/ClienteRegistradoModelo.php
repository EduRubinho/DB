<?php
require_once __DIR__ . '/../../config/db.php';

class ClienteRegistradoModelo {
    private $db;

    public function __construct() {
        $this->db = conectarBD();
    }

    public function obtenerTodos($limit = null, $offset = null) {
        $sql = "SELECT cr.*, c.id as cliente_id 
                FROM CLIENTE_REGISTRADO cr 
                INNER JOIN CLIENTE c ON cr.id = c.id 
                ORDER BY cr.nombre, cr.apellido_paterno";
        
        if ($limit) {
            $sql .= " LIMIT $limit";
            if ($offset) {
                $sql .= " OFFSET $offset";
            }
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT cr.*, c.id as cliente_id 
                FROM CLIENTE_REGISTRADO cr 
                INNER JOIN CLIENTE c ON cr.id = c.id 
                WHERE cr.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($datos) {
        try {
            $this->db->beginTransaction();
            
            // Crear cliente base
            $this->db->prepare("INSERT INTO CLIENTE() VALUES ()")->execute();
            $id = $this->db->lastInsertId();

            // Crear cliente registrado
            $sql = "INSERT INTO CLIENTE_REGISTRADO 
                    (id, nombre, apellido_paterno, apellido_materno, correo, password, 
                     tipo_documento, DNI, dv, fecha_nacimiento, celular, departamento, 
                     provincia, distrito, cineplanet, genero)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->db->prepare($sql);
            $resultado = $stmt->execute([
                $id,
                $datos['nombre'],
                $datos['apellido_paterno'],
                $datos['apellido_materno'],
                $datos['correo'],
                $datos['password'],
                $datos['tipo_documento'],
                $datos['DNI'],
                $datos['dv'] ?? '',
                $datos['fecha_nacimiento'],
                $datos['celular'],
                $datos['departamento'],
                $datos['provincia'],
                $datos['distrito'],
                $datos['cineplanet'] ?? '',
                $datos['genero']
            ]);
            
            $this->db->commit();
            return $resultado;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function actualizar($id, $datos) {
        $sql = "UPDATE CLIENTE_REGISTRADO 
                SET nombre = ?, apellido_paterno = ?, apellido_materno = ?, correo = ?, 
                    tipo_documento = ?, DNI = ?, dv = ?, fecha_nacimiento = ?, celular = ?, 
                    departamento = ?, provincia = ?, distrito = ?, cineplanet = ?, genero = ?
                WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $datos['nombre'],
            $datos['apellido_paterno'],
            $datos['apellido_materno'],
            $datos['correo'],
            $datos['tipo_documento'],
            $datos['DNI'],
            $datos['dv'] ?? '',
            $datos['fecha_nacimiento'],
            $datos['celular'],
            $datos['departamento'],
            $datos['provincia'],
            $datos['distrito'],
            $datos['cineplanet'] ?? '',
            $datos['genero'],
            $id
        ]);
    }

    public function eliminar($id) {
        // El CASCADE eliminará automáticamente el CLIENTE_REGISTRADO
        $sql = "DELETE FROM CLIENTE WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function buscar($termino) {
        $sql = "SELECT cr.*, c.id as cliente_id 
                FROM CLIENTE_REGISTRADO cr 
                INNER JOIN CLIENTE c ON cr.id = c.id 
                WHERE cr.nombre LIKE ? OR cr.apellido_paterno LIKE ? OR cr.DNI LIKE ? OR cr.correo LIKE ?
                ORDER BY cr.nombre, cr.apellido_paterno";
        
        $termino = "%$termino%";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$termino, $termino, $termino, $termino]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarTotal() {
        $sql = "SELECT COUNT(*) as total FROM CLIENTE_REGISTRADO";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function dniExiste($dni, $excluir_id = null) {
        $sql = "SELECT id FROM CLIENTE_REGISTRADO WHERE DNI = ?";
        $params = [$dni];
        
        if ($excluir_id) {
            $sql .= " AND id != ?";
            $params[] = $excluir_id;
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
}