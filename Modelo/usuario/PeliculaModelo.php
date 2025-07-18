<?php
require_once __DIR__ . '/../../config/db.php';

class PeliculaModelo {
    private $db;

    public function __construct() {
        $this->db = conectarBD();
    }

    public function obtenerPeliculas() {
        $stmt = $this->db->query("SELECT * FROM peliculas ORDER BY fecha_estreno DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPeliculaPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM peliculas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Métodos adicionales que necesitas
    public function obtenerTodas() {
        return $this->obtenerPeliculas();
    }

    public function obtenerPorId($id) {
        return $this->obtenerPeliculaPorId($id);
    }

    public function buscarPorGenero($genero) {
        $stmt = $this->db->prepare("SELECT * FROM peliculas WHERE genero LIKE ? ORDER BY titulo");
        $stmt->execute(["%$genero%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEstrenos() {
        $stmt = $this->db->prepare("SELECT * FROM peliculas WHERE fecha_estreno >= CURDATE() ORDER BY fecha_estreno ASC LIMIT 5");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorTitulo($titulo) {
        $stmt = $this->db->prepare("SELECT * FROM peliculas WHERE titulo LIKE ? ORDER BY titulo");
        $stmt->execute(["%$titulo%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}