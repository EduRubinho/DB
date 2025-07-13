<?php
session_start(); // Importante: siempre al inicio
echo '<pre>';
print_r($_SESSION); // Muestra todo el contenido de la sesión
echo '</pre>';
?>
