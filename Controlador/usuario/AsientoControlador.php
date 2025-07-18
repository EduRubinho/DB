<?php
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../Modelo/usuario/AsientoModelo.php';

class AsientoControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new AsientoModelo();
    }

    public function obtenerPorFuncion($funcion_id) {
        return $this->modelo->obtenerPorFuncion($funcion_id);
    }

    public function verificarDisponibilidad($asiento_id) {
        return $this->modelo->verificarDisponibilidad($asiento_id);
    }

    public function obtenerInfoCompleta($asiento_id) {
        return $this->modelo->obtenerInfoCompleta($asiento_id);
    }
}