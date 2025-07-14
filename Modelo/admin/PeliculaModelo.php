<?php
require_once __DIR__ . '/../../Config/db.php';

class PeliculaModelo {
    private $db;

    public function __construct() {
        $this->db = conectarBD();
    }

    public function obtenerPeliculas() {
    try {
        $query = $this->db->query("SELECT * FROM peliculas");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        if (!$result) {
            error_log("La consulta no retornó resultados");
        }
        
        return $result;
    } catch (PDOException $e) {
        error_log("Error en obtenerPeliculas: " . $e->getMessage());
        return [];
    }
}

    public function obtenerPeliculaPorId($id_pelicula) {
        $stmt = $this->db->prepare("SELECT * FROM peliculas WHERE id_pelicula = :id_pelicula");
        $stmt->execute(['id_pelicula' => $id_pelicula]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crearPelicula($datos) {
        $stmt = $this->db->prepare(
            "INSERT INTO peliculas (titulo, descripcion, genero, duracion, director, fecha_estreno, imagen) 
             VALUES (:titulo, :descripcion, :genero, :duracion, :director, :fecha_estreno, :imagen)"
        );
        return $stmt->execute($datos);
    }

    public function actualizarPelicula($id_pelicula, $datos) {
        $stmt = $this->db->prepare(
            "UPDATE peliculas SET 
                titulo = :titulo, 
                descripcion = :descripcion, 
                genero = :genero, 
                duracion = :duracion, 
                director = :director, 
                fecha_estreno = :fecha_estreno, 
                imagen = :imagen 
             WHERE id_pelicula = :id_pelicula"
        );
        $datos['id_pelicula'] = $id_pelicula;
        return $stmt->execute($datos);
    }

    public function eliminarPelicula($id_pelicula) {
        $stmt = $this->db->prepare("DELETE FROM peliculas WHERE id_pelicula = :id_pelicula");
        return $stmt->execute(['id_pelicula' => $id_pelicula]);
    }
}