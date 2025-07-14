<?php
require_once __DIR__ . '/../../Config/db.php';

class AdminModelo {
    private $db;

    public function __construct() {
        $this->db = conectarBD();
    }

    public function adminExiste($usuario) {
        $query = $this->db->prepare("SELECT * FROM admin WHERE usuario = :usuario LIMIT 1");
        $query->execute([':usuario' => $usuario]);
        return $query->fetch();
    }

    public function registrarAdmin($datos) {
        $stmt = $this->db->prepare("INSERT INTO admin (usuario, password, nombre_completo)
                                    VALUES (:usuario, :password, :nombre)");
        return $stmt->execute($datos);
    }

    public function login($usuario) {
        $stmt = $this->db->prepare("SELECT * FROM admin WHERE usuario = :usuario LIMIT 1");
        $stmt->execute([':usuario' => $usuario]);
        return $stmt->fetch();
    }

    
}
