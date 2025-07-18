<?php
function iniciarSesionSegura() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Llamar automáticamente
iniciarSesionSegura();