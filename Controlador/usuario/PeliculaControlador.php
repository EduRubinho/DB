<?php
require_once __DIR__ . '/../../Modelo/usuario/PeliculaModelo.php';
require_once __DIR__ . '/../../config/session.php';
class PeliculaControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new PeliculaModelo();
    }

    public function obtenerTodas() {
        return $this->modelo->obtenerTodas();
    }

    public function obtenerPorId($id) {
        return $this->modelo->obtenerPorId($id);
    }

    public function buscarPorGenero($genero) {
        return $this->modelo->buscarPorGenero($genero);
    }

    public function obtenerEstrenos() {
        return $this->modelo->obtenerEstrenos();
    }
}