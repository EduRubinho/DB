<?php
require_once __DIR__ . '/../../config/db.php';

class UsuarioModelo {
    private $db;

    public function __construct() {
        $this->db = conectarBD();
    }

    public function usuarioExiste($dni) {
        $query = $this->db->prepare("SELECT * FROM CLIENTE_REGISTRADO WHERE DNI = ? LIMIT 1");
        $query->execute([$dni]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function registrarCliente($datos) {
        try {
            $this->db->beginTransaction();
            
            // Insertar en tabla CLIENTE primero
            $this->db->prepare("INSERT INTO CLIENTE() VALUES ()")->execute();
            $id = $this->db->lastInsertId();

            // Insertar en CLIENTE_REGISTRADO
            $stmt = $this->db->prepare("
                INSERT INTO CLIENTE_REGISTRADO 
                (id, nombre, apellido_paterno, apellido_materno, correo, password, tipo_documento, DNI, dv, fecha_nacimiento, celular, departamento, provincia, distrito, cineplanet, genero)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $resultado = $stmt->execute([
                $id,
                $datos['nombre'],
                $datos['apellido_paterno'],
                $datos['apellido_materno'],
                $datos['correo'],
                $datos['password'],
                $datos['tipo_documento'],
                $datos['DNI'],
                $datos['dv'],
                $datos['fecha_nacimiento'],
                $datos['celular'],
                $datos['departamento'],
                $datos['provincia'],
                $datos['distrito'],
                $datos['cineplanet'],
                $datos['genero']
            ]);
            
            $this->db->commit();
            return $resultado;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function login($dni, $password) {
        $stmt = $this->db->prepare("SELECT * FROM CLIENTE_REGISTRADO WHERE DNI = ? AND password = ? LIMIT 1");
        $stmt->execute([$dni, $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM CLIENTE_REGISTRADO WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarPerfil($id, $datos) {
        $stmt = $this->db->prepare("
            UPDATE CLIENTE_REGISTRADO 
            SET nombre = ?, apellido_paterno = ?, apellido_materno = ?, correo = ?, celular = ?, departamento = ?, provincia = ?, distrito = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $datos['nombre'],
            $datos['apellido_paterno'],
            $datos['apellido_materno'],
            $datos['correo'],
            $datos['celular'],
            $datos['departamento'],
            $datos['provincia'],
            $datos['distrito'],
            $id
        ]);
    }
}