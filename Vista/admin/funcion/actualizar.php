<?php
require_once __DIR__ . '/../../../config/session.php';
if (!isset($_SESSION['admin'])) {
    header('Location: ../login_admin.php');
    exit;
}

require_once __DIR__ . '/../../../Controlador/admin/FuncionControlador.php';
require_once __DIR__ . '/../../../Controlador/admin/PeliculaControlador.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$controlador = new FuncionControlador();
$funcion = $controlador->obtenerPorId($id);

if (!$funcion) {
    $_SESSION['errores'] = 'Función no encontrada';
    header('Location: index.php');
    exit;
}

$peliculaControlador = new PeliculaControlador();
$peliculas = $peliculaControlador->obtenerTodas();

$datos = $_POST ?: $funcion;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Función - Admin</title>
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>🎬 Admin</h2>
                <p>Cineplanet</p>
            </div>
            <ul class="sidebar-menu">
                <li><a href="../../../Vista/web/admin/inicioadmin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="../cliente/index.php"><i class="fas fa-users"></i> Clientes</a></li>
                <li><a href="../pelicula/index.php"><i class="fas fa-film"></i> Películas</a></li>
                <li class="active"><a href="index.php"><i class="fas fa-calendar-alt"></i> Funciones</a></li>
                <li><a href="../dulceria/index.php"><i class="fas fa-candy-cane"></i> Dulcería</a></li>
                <li><a href="../boleta/index.php"><i class="fas fa-ticket-alt"></i> Boletas</a></li>
                <li><a href="../../../Vista/web/admin/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="content-header">
                <h1>✏️ Actualizar Función</h1>
                <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
            </header>

            <?php if (isset($_SESSION['errores'])): ?>
                <div class="alert alert-error"><?php echo $_SESSION['errores']; unset($_SESSION['errores']); ?></div>
            <?php endif; ?>

            <div class="form-container">
                <form method="POST" action="../../../Controlador/admin/FuncionControlador.php">
                    <input type="hidden" name="accion" value="actualizar">
                    <input type="hidden" name="id" value="<?php echo $funcion['id']; ?>">

                    <div class="form-group">
                        <label>Película *</label>
                        <select name="id_pelicula" required>
                            <?php foreach ($peliculas as $pelicula): ?>
                                <option value="<?php echo $pelicula['id']; ?>" <?php echo $datos['id_pelicula'] == $pelicula['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($pelicula['titulo']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Sala *</label>
                        <select name="id_sala" required>
                            <option value="1" <?php echo $datos['id_sala'] == '1' ? 'selected' : ''; ?>>Sala 1</option>
                            <option value="2" <?php echo $datos['id_sala'] == '2' ? 'selected' : ''; ?>>Sala 2</option>
                            <option value="3" <?php echo $datos['id_sala'] == '3' ? 'selected' : ''; ?>>Sala 3</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Fecha *</label>
                        <input type="date" name="fecha" value="<?php echo $datos['fecha']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Hora *</label>
                        <input type="time" name="hora" value="<?php echo $datos['hora']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Precio *</label>
                        <input type="number" step="0.01" name="precio" value="<?php echo $datos['precio']; ?>" required>
                    </div>

                    <div class="form-actions">
                        <a href="index.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Actualizar</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <style>
        .form-container { background: white; margin: 20px; padding: 30px; border-radius: 8px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .form-actions { text-align: center; padding-top: 20px; }
        .btn { padding: 10px 20px; margin: 0 10px; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn-warning { background: #f39c12; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .alert-error { background: #f8d7da; color: #721c24; margin: 20px; padding: 15px; border-radius: 8px; }
    </style>
</body>
</html>