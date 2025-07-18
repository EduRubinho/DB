<?php
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../Modelo/admin/PeliculaModelo.php';

class PeliculaControlador {
    private $modelo;
    
    public function __construct() {
        $this->modelo = new PeliculaModelo();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['accion'] ?? '';
            switch ($accion) {
                case 'crear':
                    $this->crear();
                    break;
                case 'actualizar':
                    $this->actualizar();
                    break;
                case 'eliminar':
                    $this->eliminar();
                    break;
            }
        }
    }
    
    public function obtenerTodas() {
        return $this->modelo->obtenerTodas();
    }
    
    public function obtenerPorId($id) {
        return $this->modelo->obtenerPorId($id);
    }
    
    public function buscar($termino) {
        return $this->modelo->buscar($termino);
    }
    
    public function contarTotal() {
        return $this->modelo->contarTotal();
    }
    
    private function crear() {
        try {
            $errores = $this->validarDatos($_POST);
            if (!empty($errores)) {
                $_SESSION['errores'] = implode('<br>', $errores);
                header('Location: ../../Vista/admin/pelicula/crear.php');
                return;
            }
            
            $imagen = $this->procesarImagen();
            
            $datos = [
                'titulo' => trim($_POST['titulo']),
                'descripcion' => trim($_POST['sinopsis'] ?? ''),
                'genero' => $_POST['genero'],
                'duracion' => (int)$_POST['duracion'],
                'director' => trim($_POST['director'] ?? ''),
                'fecha_estreno' => !empty($_POST['fecha_estreno']) ? $_POST['fecha_estreno'] : null,
                'imagen' => $imagen,
                'clasificacion' => $_POST['clasificacion'],
                'estado' => $_POST['estado']
            ];
            
            if ($this->modelo->crear($datos)) {
                $_SESSION['mensaje'] = 'Película creada exitosamente';
                header('Location: ../../Vista/admin/pelicula/index.php');
            } else {
                $_SESSION['errores'] = 'Error al crear la película';
                header('Location: ../../Vista/admin/pelicula/crear.php');
            }
        } catch (Exception $e) {
            $_SESSION['errores'] = 'Error: ' . $e->getMessage();
            header('Location: ../../Vista/admin/pelicula/crear.php');
        }
        exit;
    }
    
    private function actualizar() {
        try {
            $id = (int)$_POST['id'];
            $errores = $this->validarDatos($_POST);
            if (!empty($errores)) {
                $_SESSION['errores'] = implode('<br>', $errores);
                header('Location: ../../Vista/admin/pelicula/actualizar.php?id=' . $id);
                return;
            }
            
            $pelicula_actual = $this->modelo->obtenerPorId($id);
            if (!$pelicula_actual) {
                $_SESSION['errores'] = 'Película no encontrada';
                header('Location: ../../Vista/admin/pelicula/index.php');
                return;
            }
            
            $imagen = $this->procesarImagen($pelicula_actual['imagen'] ?? '');
            
            $datos = [
                'titulo' => trim($_POST['titulo']),
                'descripcion' => trim($_POST['sinopsis'] ?? ''),
                'genero' => $_POST['genero'],
                'duracion' => (int)$_POST['duracion'],
                'director' => trim($_POST['director'] ?? ''),
                'fecha_estreno' => !empty($_POST['fecha_estreno']) ? $_POST['fecha_estreno'] : null,
                'imagen' => $imagen,
                'clasificacion' => $_POST['clasificacion'],
                'estado' => $_POST['estado']
            ];
            
            if ($this->modelo->actualizar($id, $datos)) {
                $_SESSION['mensaje'] = 'Película actualizada exitosamente';
                header('Location: ../../Vista/admin/pelicula/index.php');
            } else {
                $_SESSION['errores'] = 'Error al actualizar la película';
                header('Location: ../../Vista/admin/pelicula/actualizar.php?id=' . $id);
            }
        } catch (Exception $e) {
            $_SESSION['errores'] = 'Error: ' . $e->getMessage();
            header('Location: ../../Vista/admin/pelicula/actualizar.php?id=' . ($_POST['id'] ?? 0));
        }
        exit;
    }
    
    private function eliminar() {
    try {
        $id = (int)$_POST['id'];
        $pelicula = $this->modelo->obtenerPorId($id);
        if (!$pelicula) {
            $_SESSION['errores'] = 'Película no encontrada';
            header('Location: ../../Vista/admin/pelicula/index.php');
            return;
        }
        
        // ⚡ YA NO NECESITAS eliminarDependencias() 
        // El CASCADE se encarga automáticamente
        if ($this->modelo->eliminar($id)) {
            // Solo eliminar imagen del servidor
            if (!empty($pelicula['imagen'])) {
                $ruta_imagen = __DIR__ . '/../../uploads/peliculas/' . $pelicula['imagen'];
                if (file_exists($ruta_imagen)) {
                    unlink($ruta_imagen);
                }
            }
            $_SESSION['mensaje'] = 'Película eliminada exitosamente (incluyendo funciones y asientos)';
        } else {
            $_SESSION['errores'] = 'Error al eliminar la película';
        }
        
        header('Location: ../../Vista/admin/pelicula/index.php');
    } catch (Exception $e) {
        $_SESSION['errores'] = 'Error: ' . $e->getMessage();
        header('Location: ../../Vista/admin/pelicula/index.php');
    }
    exit;
}
    
    private function validarDatos($datos) {
        $errores = [];
        
        if (empty(trim($datos['titulo']))) {
            $errores[] = 'El título es obligatorio';
        }
        
        if (empty($datos['genero'])) {
            $errores[] = 'El género es obligatorio';
        }
        
        if (empty($datos['duracion']) || !is_numeric($datos['duracion']) || $datos['duracion'] <= 0) {
            $errores[] = 'La duración debe ser un número mayor a 0';
        }
        
        if (empty($datos['clasificacion'])) {
            $errores[] = 'La clasificación es obligatoria';
        }
        
        if (empty($datos['estado']) || !in_array($datos['estado'], ['activa', 'inactiva'])) {
            $errores[] = 'El estado debe ser "activa" o "inactiva"';
        }
        
        return $errores;
    }
    
    private function procesarImagen($imagen_actual = '') {
        if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] === UPLOAD_ERR_NO_FILE) {
            return $imagen_actual;
        }
        
        if ($_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Error al subir la imagen');
        }
        
        $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $tipo_archivo = finfo_file($finfo, $_FILES['imagen']['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($tipo_archivo, $tipos_permitidos)) {
            throw new Exception('Tipo de imagen no permitido. Solo JPG, PNG, GIF, WEBP');
        }
        
        if ($_FILES['imagen']['size'] > 5 * 1024 * 1024) { // 5MB
            throw new Exception('La imagen es demasiado grande (máximo 5MB)');
        }
        
        $directorio = __DIR__ . '/../../uploads/peliculas/';
        if (!is_dir($directorio)) {
            if (!mkdir($directorio, 0755, true)) {
                throw new Exception('No se pudo crear el directorio de imágenes');
            }
        }
        
        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nombre_archivo = uniqid('pelicula_') . '.' . strtolower($extension);
        $ruta_destino = $directorio . $nombre_archivo;
        
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {
            // Eliminar imagen anterior si existe y es diferente
            if (!empty($imagen_actual) && $imagen_actual !== $nombre_archivo) {
                $ruta_anterior = $directorio . $imagen_actual;
                if (file_exists($ruta_anterior)) {
                    unlink($ruta_anterior);
                }
            }
            return $nombre_archivo;
        } else {
            throw new Exception('Error al guardar la imagen en el servidor');
        }
    }
}

// Ejecutar controlador si se accede directamente
if (basename($_SERVER['PHP_SELF']) === 'PeliculaControlador.php') {
    new PeliculaControlador();
}
?>