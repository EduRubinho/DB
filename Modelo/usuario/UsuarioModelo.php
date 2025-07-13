<?php
require_once __DIR__ . '/../../Config/db.php';

class UsuarioModelo {
    private $db;

    public function __construct() {
        $this->db = conectarBD();
    }

    public function usuarioExiste($dni) {
        $query = $this->db->prepare("SELECT * FROM cliente_registrado WHERE DNI = :dni LIMIT 1");
        $query->execute([':dni' => $dni]);
        return $query->fetch();
    }

    public function registrarCliente($datos) {
        $this->db->prepare("INSERT INTO cliente() VALUES ()")->execute();
        $id = $this->db->lastInsertId();

        $stmt = $this->db->prepare("INSERT INTO cliente_registrado 
        (id, nombre, apellido_paterno, apellido_materno, correo, password, tipo_documento, DNI, dv, fecha_nacimiento, celular, departamento, provincia, distrito, cineplanet, genero)
        VALUES 
        (:id, :nombre, :apellido_paterno, :apellido_materno, :correo, :password, :tipo_documento, :DNI, :dv, :fecha_nacimiento, :celular, :departamento, :provincia, :distrito, :cineplanet, :genero)");

        $datos['id'] = $id;
        return $stmt->execute($datos);
    }

    public function login($dni, $password) {
        $stmt = $this->db->prepare("SELECT * FROM cliente_registrado WHERE DNI = :dni AND password = :password LIMIT 1");
        $stmt->execute([':dni' => $dni, ':password' => $password]);
        return $stmt->fetch();
    }
}
