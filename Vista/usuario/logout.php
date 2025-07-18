<?php
require_once __DIR__ . '/../../config/session.php';

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al login
header('Location: ../usuario/login.php');
exit;