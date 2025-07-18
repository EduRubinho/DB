<?php
require_once __DIR__ . '/../../config/session.php';require_once __DIR__ . '/../../Modelo/usuario/ReservaModelo.php';

class ReservaControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new ReservaModelo();
    }

    public function procesarAccion() {
        if (!isset($_SESSION['usuario'])) {
            header("Location: ../../Vista/usuario/login.php");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ../../Vista/usuario/peliculas.php");
            exit;
        }

        $accion = $_POST['accion'] ?? '';

        switch ($accion) {
            case 'reservar_multiple':
                $this->reservarMultiple();
                break;
            default:
                header("Location: ../../Vista/usuario/peliculas.php");
                break;
        }
    }

    private function reservarMultiple() {
        $usuario_id = $_SESSION['usuario']['id'];
        $asientos_ids = $_POST['asientos'] ?? [];
        $precio_unitario = $_POST['precio'] ?? 0;

        if (empty($asientos_ids)) {
            echo "<script>alert('Selecciona al menos un asiento'); window.history.back();</script>";
            exit;
        }

        $boleta_id = $this->modelo->reservarMultiplesAsientos($usuario_id, $asientos_ids, $precio_unitario);

        if ($boleta_id) {
            echo "<script>
                alert('¡Reserva exitosa!'); 
                window.location.href='../../Vista/usuario/dulceria.php?boleta_id=$boleta_id';
            </script>";
        } else {
            echo "<script>alert('Error en la reserva. Algunos asientos pueden estar ocupados'); window.history.back();</script>";
        }
    }

    public function obtenerBoletasPorUsuario($usuario_id) {
        return $this->modelo->obtenerBoletasPorUsuario($usuario_id);
    }

    public function obtenerBoletaPorId($boleta_id) {
        return $this->modelo->obtenerBoletaPorId($boleta_id);
    }

    public function obtenerAsientosPorBoleta($boleta_id) {
        return $this->modelo->obtenerAsientosPorBoleta($boleta_id);
    }


    public function obtenerProductosPorBoleta($boleta_id) {
        return $this->modelo->obtenerProductosPorBoleta($boleta_id);
    }

    public function obtenerTotalBoleta($boleta_id) {
        return $this->modelo->obtenerTotalBoleta($boleta_id);
    }
}

// Ejecutar si es llamada directa
if (basename($_SERVER['PHP_SELF']) === 'ReservaControlador.php') {
    $controlador = new ReservaControlador();
    $controlador->procesarAccion();
}