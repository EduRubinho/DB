<?php
require_once __DIR__ . '/../../../config/session.php';
if (!isset($_SESSION['admin'])) {
    header('Location: ../login_admin.php');
    exit;
}

require_once __DIR__ . '/../../../Controlador/admin/PeliculaControlador.php';
require_once __DIR__ . '/../../../Controlador/admin/FuncionControlador.php';

$peliculaControlador = new PeliculaControlador();
$peliculas = $peliculaControlador->obtenerTodas();

$funcionControlador = new FuncionControlador();
$salas = $funcionControlador->obtenerSalas(); // Nuevo método
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Función - Admin</title>
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
                <h1>📅 Crear Nueva Función</h1>
                <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
            </header>

            <?php if (isset($_SESSION['errores'])): ?>
                <div class="alert alert-error"><?php echo $_SESSION['errores']; unset($_SESSION['errores']); ?></div>
            <?php endif; ?>

            <div class="form-container">
                <form method="POST" action="../../../Controlador/admin/FuncionControlador.php">
                    <input type="hidden" name="accion" value="crear">

                    <div class="form-group">
                        <label>Película *</label>
                        <select name="id_pelicula" required>
                            <option value="">Seleccionar película...</option>
                            <?php foreach ($peliculas as $pelicula): ?>
                                <option value="<?php echo $pelicula['id']; ?>" <?php echo ($_POST['id_pelicula'] ?? '') == $pelicula['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($pelicula['titulo']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Sala *</label>
                        <select name="id_sala" required>
                            <option value="">Seleccionar sala...</option>
                            <?php if (!empty($salas)): ?>
                                <?php foreach ($salas as $sala): ?>
                                    <option value="<?php echo $sala['id_sala']; ?>" <?php echo ($_POST['id_sala'] ?? '') == $sala['id_sala'] ? 'selected' : ''; ?>>
                                        Sala <?php echo $sala['id_sala']; ?> - <?php echo $sala['formato']; ?> (<?php echo $sala['capacidad']; ?> asientos)
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>No hay salas disponibles</option>
                            <?php endif; ?>
                        </select>
                        <?php if (empty($salas)): ?>
                            <small style="color: red;">⚠️ No hay salas registradas. Contacta al administrador.</small>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label>Fecha *</label>
                        <input type="date" name="fecha" value="<?php echo $_POST['fecha'] ?? date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Hora *</label>
                        <select name="hora" required>
                            <option value="">Seleccionar hora...</option>
                            <option value="10:00" <?php echo ($_POST['hora'] ?? '') == '10:00' ? 'selected' : ''; ?>>10:00 AM</option>
                            <option value="13:00" <?php echo ($_POST['hora'] ?? '') == '13:00' ? 'selected' : ''; ?>>01:00 PM</option>
                            <option value="16:00" <?php echo ($_POST['hora'] ?? '') == '16:00' ? 'selected' : ''; ?>>04:00 PM</option>
                            <option value="19:00" <?php echo ($_POST['hora'] ?? '') == '19:00' ? 'selected' : ''; ?>>07:00 PM</option>
                            <option value="22:00" <?php echo ($_POST['hora'] ?? '') == '22:00' ? 'selected' : ''; ?>>10:00 PM</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Precio *</label>
                        <select name="precio" required>
                            <option value="">Seleccionar precio...</option>
                            <option value="12.00" <?php echo ($_POST['precio'] ?? '') == '12.00' ? 'selected' : ''; ?>>S/ 12.00 - Matinée</option>
                            <option value="15.00" <?php echo ($_POST['precio'] ?? '') == '15.00' ? 'selected' : ''; ?>>S/ 15.00 - Normal</option>
                            <option value="18.00" <?php echo ($_POST['precio'] ?? '') == '18.00' ? 'selected' : ''; ?>>S/ 18.00 - Noche</option>
                            <option value="25.00" <?php echo ($_POST['precio'] ?? '') == '25.00' ? 'selected' : ''; ?>>S/ 25.00 - 3D/IMAX</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <a href="index.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary" <?php echo empty($salas) ? 'disabled' : ''; ?>>
                            <i class="fas fa-save"></i> Crear Función
                        </button>
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
        .form-group small { display: block; margin-top: 5px; font-size: 12px; }
        .form-actions { text-align: center; padding-top: 20px; }
        .btn { padding: 10px 20px; margin: 0 10px; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn-primary { background: #3498db; color: white; }
        .btn-primary:disabled { background: #ccc; cursor: not-allowed; }
        .btn-secondary { background: #6c757d; color: white; }
        .alert-error { background: #f8d7da; color: #721c24; margin: 20px; padding: 15px; border-radius: 8px; }
    </style>
</body>
</html>