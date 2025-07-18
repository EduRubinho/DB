<?php
require_once __DIR__ . '/../../config/db.php';

class FuncionModelo {
    private $db;

    public function __construct() {
        $this->db = conectarBD();
    }

    public function obtenerPorPelicula($pelicula_id) {
        $stmt = $this->db->prepare("
            SELECT f.*, s.formato AS sala_nombre, s.capacidad
            FROM funcion f
            INNER JOIN SALA s ON f.id_sala = s.id_sala
            WHERE f.id_pelicula = ? AND f.fecha >= CURDATE()
            ORDER BY f.fecha ASC, f.hora ASC
        ");
        $stmt->execute([$pelicula_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("
            SELECT f.*, p.titulo as pelicula_titulo, s.formato as sala_nombre
            FROM funcion f
            JOIN peliculas p ON f.id_pelicula = p.id
            JOIN SALA s ON f.id_sala = s.id_sala
            WHERE f.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerFuncionesHoy() {
        $stmt = $this->db->prepare("
            SELECT f.*, p.titulo, p.genero, s.formato as sala_nombre
            FROM funcion f
            JOIN peliculas p ON f.id_pelicula = p.id
            JOIN SALA s ON f.id_sala = s.id_sala
            WHERE f.fecha = CURDATE()
            ORDER BY f.hora ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}