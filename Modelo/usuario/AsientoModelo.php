<?php

require_once __DIR__ . '/../../config/db.php';

class AsientoModelo {
    private $db;

    public function __construct() {
        $this->db = conectarBD();
    }

    public function obtenerPorFuncion($funcion_id) {
        $stmt = $this->db->prepare("
            SELECT 
                a.id, 
                a.numero, 
                a.fila, 
                CASE 
                    WHEN r.id IS NOT NULL THEN 1
                    ELSE 0
                END AS ocupado
            FROM asientos a
            LEFT JOIN reservas r ON r.asiento_id = a.id
            WHERE a.funcion_id = ?
            ORDER BY a.fila, a.numero
        ");
        $stmt->execute([$funcion_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verificarDisponibilidad($asiento_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM reservas WHERE asiento_id = ?");
        $stmt->execute([$asiento_id]);
        return $stmt->fetchColumn() == 0;
    }

    public function obtenerInfoCompleta($asiento_id) {
        $stmt = $this->db->prepare("
            SELECT a.*, f.fecha, f.hora, f.precio, p.titulo as pelicula, s.formato as sala
            FROM asientos a
            JOIN funcion f ON a.funcion_id = f.id
            JOIN peliculas p ON f.id_pelicula = p.id
            JOIN SALA s ON f.id_sala = s.id_sala
            WHERE a.id = ?
        ");
        $stmt->execute([$asiento_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}