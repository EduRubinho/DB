<?php
require_once __DIR__ . '/../../../config/session.php';
if (!isset($_SESSION['admin'])) {
    header('Location: ../login_admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Película - Admin</title>
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
                <li class="active"><a href="index.php"><i class="fas fa-film"></i> Películas</a></li>
                <li><a href="../funcion/index.php"><i class="fas fa-calendar-alt"></i> Funciones</a></li>
                <li><a href="../dulceria/index.php"><i class="fas fa-candy-cane"></i> Dulcería</a></li>
                <li><a href="../boleta/index.php"><i class="fas fa-ticket-alt"></i> Boletas</a></li>
                <li><a href="../../../Vista/web/admin/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="content-header">
                <h1>🎬 Crear Nueva Película</h1>
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </header>

            <?php if (isset($_SESSION['errores'])): ?>
                <div class="alert alert-error">
                    <?php echo $_SESSION['errores']; unset($_SESSION['errores']); ?>
                </div>
            <?php endif; ?>

            <div class="form-container">
                <form method="POST" action="../../../Controlador/admin/PeliculaControlador.php" enctype="multipart/form-data">
                    <input type="hidden" name="accion" value="crear">

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Título *</label>
                            <input type="text" name="titulo" value="<?php echo $_POST['titulo'] ?? ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Duración (minutos) *</label>
                            <input type="number" name="duracion" value="<?php echo $_POST['duracion'] ?? ''; ?>" min="1" required>
                        </div>

                        <div class="form-group">
                            <label>Género *</label>
                            <select name="genero" required>
                                <option value="">Seleccionar...</option>
                                <option value="Acción" <?php echo ($_POST['genero'] ?? '') === 'Acción' ? 'selected' : ''; ?>>Acción</option>
                                <option value="Comedia" <?php echo ($_POST['genero'] ?? '') === 'Comedia' ? 'selected' : ''; ?>>Comedia</option>
                                <option value="Drama" <?php echo ($_POST['genero'] ?? '') === 'Drama' ? 'selected' : ''; ?>>Drama</option>
                                <option value="Terror" <?php echo ($_POST['genero'] ?? '') === 'Terror' ? 'selected' : ''; ?>>Terror</option>
                                <option value="Romance" <?php echo ($_POST['genero'] ?? '') === 'Romance' ? 'selected' : ''; ?>>Romance</option>
                                <option value="Ciencia Ficción" <?php echo ($_POST['genero'] ?? '') === 'Ciencia Ficción' ? 'selected' : ''; ?>>Ciencia Ficción</option>
                                <option value="Animación" <?php echo ($_POST['genero'] ?? '') === 'Animación' ? 'selected' : ''; ?>>Animación</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Clasificación *</label>
                            <select name="clasificacion" required>
                                <option value="">Seleccionar...</option>
                                <option value="G" <?php echo ($_POST['clasificacion'] ?? '') === 'G' ? 'selected' : ''; ?>>G - General</option>
                                <option value="PG" <?php echo ($_POST['clasificacion'] ?? '') === 'PG' ? 'selected' : ''; ?>>PG - Para menores</option>
                                <option value="PG-13" <?php echo ($_POST['clasificacion'] ?? '') === 'PG-13' ? 'selected' : ''; ?>>PG-13 - Mayores de 13</option>
                                <option value="R" <?php echo ($_POST['clasificacion'] ?? '') === 'R' ? 'selected' : ''; ?>>R - Restringido</option>
                                <option value="NC-17" <?php echo ($_POST['clasificacion'] ?? '') === 'NC-17' ? 'selected' : ''; ?>>NC-17 - Solo adultos</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Idioma *</label>
                            <select name="idioma" required>
                                <option value="">Seleccionar...</option>
                                <option value="Español" <?php echo ($_POST['idioma'] ?? '') === 'Español' ? 'selected' : ''; ?>>Español</option>
                                <option value="Inglés" <?php echo ($_POST['idioma'] ?? '') === 'Inglés' ? 'selected' : ''; ?>>Inglés</option>
                                <option value="Francés" <?php echo ($_POST['idioma'] ?? '') === 'Francés' ? 'selected' : ''; ?>>Francés</option>
                                <option value="Japonés" <?php echo ($_POST['idioma'] ?? '') === 'Japonés' ? 'selected' : ''; ?>>Japonés</option>
                                <option value="Coreano" <?php echo ($_POST['idioma'] ?? '') === 'Coreano' ? 'selected' : ''; ?>>Coreano</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Estado *</label>
                            <select name="estado" required>
                                <option value="activa" <?php echo ($_POST['estado'] ?? '') === 'activa' ? 'selected' : ''; ?>>Activa</option>
                                <option value="inactiva" <?php echo ($_POST['estado'] ?? '') === 'inactiva' ? 'selected' : ''; ?>>Inactiva</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Sinopsis *</label>
                        <textarea name="sinopsis" rows="4" required><?php echo $_POST['sinopsis'] ?? ''; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Imagen/Póster</label>
                        <input type="file" name="imagen" accept="image/*">
                        <small>Formatos: JPG, PNG, GIF. Máximo 5MB</small>
                    </div>

                    <div class="form-actions">
                        <a href="index.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Crear Película
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <style>
        .form-container { background: white; margin: 20px; padding: 30px; border-radius: 8px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; color: #333; }
        .form-group input, .form-group select, .form-group textarea { 
            width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; 
            font-size: 14px; box-sizing: border-box;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { 
            border-color: #3498db; outline: none; 
        }
        .form-group small { color: #666; font-size: 12px; margin-top: 5px; display: block; }
        .form-actions { text-align: center; padding-top: 20px; border-top: 1px solid #eee; }
        .btn { padding: 10px 20px; margin: 0 10px; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn-primary { background: #3498db; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .alert-error { background: #f8d7da; color: #721c24; margin: 20px; padding: 15px; border-radius: 8px; }
        @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } }
    </style>
</body>
</html>