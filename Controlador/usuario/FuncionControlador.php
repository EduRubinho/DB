<?php
require_once __DIR__ . '/../../Modelo/usuario/FuncionModelo.php';
require_once __DIR__ . '/../../config/session.php';
class FuncionControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new FuncionModelo();
    }

    public function obtenerPorPelicula($pelicula_id) {
        return $this->modelo->obtenerPorPelicula($pelicula_id);
    }

    public function obtenerPorId($id) {
        return $this->modelo->obtenerPorId($id);
    }

    public function obtenerFuncionesHoy() {
        return $this->modelo->obtenerFuncionesHoy();
    }
}