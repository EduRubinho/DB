<?php
session_start();

// Define la ruta raíz del proyecto
define('ROOT_PATH', dirname(__DIR__, 2));

// Ruta para el modelo
require_once ROOT_PATH . '/Modelo/admin/PeliculaModelo.php';

$modelo = new PeliculaModelo();


$accion = $_GET['accion'] ?? $_POST['accion'] ?? '';

switch ($accion) {
    case 'listar':
        $peliculas = $modelo->obtenerPeliculas();
        // RUTA CORREGIDA (usa 3 niveles para subir)
        include ROOT_PATH . '/Vista/admin/peliculas/index.php';
        break;

    case 'crear':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'genero' => $_POST['genero'],
                'duracion' => $_POST['duracion'],
                'director' => $_POST['director'],
                'fecha_estreno' => $_POST['fecha_estreno'],
                'imagen' => $_FILES['imagen']['name']
            ];
            
            // Ruta absoluta corregida para imágenes
            $directorio = $_SERVER['DOCUMENT_ROOT'] . '/DB/assets/img/';
            move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $datos['imagen']);
            
            if ($modelo->crearPelicula($datos)) {
                $_SESSION['mensaje'] = 'Película creada correctamente.';
            } else {
                $_SESSION['error'] = 'Error al crear la película.';
            }
            header('Location: /DB/Controlador/admin/PeliculaControlador.php?accion=listar');
            exit;
        } else {
            // RUTA CORREGIDA
            include ROOT_PATH . '/Vista/admin/peliculas/crear.php';
        }
        break;

    case 'editar':
        $id_pelicula = $_GET['id_pelicula'] ?? 0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_pelicula = $_POST['id_pelicula'] ?? 0;
            $datos = [
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'genero' => $_POST['genero'],
                'duracion' => $_POST['duracion'],
                'director' => $_POST['director'],
                'fecha_estreno' => $_POST['fecha_estreno'],
                'imagen' => $_FILES['imagen']['name'] ?: $_POST['imagen_actual']
            ];
            
            if (!empty($_FILES['imagen']['name'])) {
                // Ruta absoluta corregida para imágenes
                $directorio = $_SERVER['DOCUMENT_ROOT'] . '/DB/assets/img/';
                move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $datos['imagen']);
            }
            
            if ($modelo->actualizarPelicula($id_pelicula, $datos)) {
                $_SESSION['mensaje'] = 'Película actualizada correctamente.';
            } else {
                $_SESSION['error'] = 'Error al actualizar la película.';
            }
            header('Location: /DB/Controlador/admin/PeliculaControlador.php?accion=listar');
            exit;
        } else {
            $pelicula = $modelo->obtenerPeliculaPorId($id_pelicula);
            // RUTA CORREGIDA
            include ROOT_PATH . '/Vista/admin/peliculas/editar.php';
        }
        break;

    case 'eliminar':
        $id_pelicula = $_GET['id_pelicula'] ?? 0;
        if ($modelo->eliminarPelicula($id_pelicula)) {
            $_SESSION['mensaje'] = 'Película eliminada correctamente.';
        } else {
            $_SESSION['error'] = 'Error al eliminar la película.';
        }
        header('Location: /DB/Controlador/admin/PeliculaControlador.php?accion=listar');
        exit;

    default:
        $peliculas = $modelo->obtenerPeliculas();
        // RUTA CORREGIDA
        include ROOT_PATH . '/Vista/admin/peliculas/index.php';
        break;
}