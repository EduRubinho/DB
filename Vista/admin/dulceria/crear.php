<?php
require_once __DIR__ . '/../../../Config/session.php';
if (!isset($_SESSION['admin'])) {
    header('Location: ../login_admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Producto - Admin</title>
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
                <li><a href="../funcion/index.php"><i class="fas fa-calendar-alt"></i> Funciones</a></li>
                <li class="active"><a href="index.php"><i class="fas fa-candy-cane"></i> Dulcería</a></li>
                <li><a href="../boleta/index.php"><i class="fas fa-ticket-alt"></i> Boletas</a></li>
                <li><a href="../../../Vista/web/admin/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="content-header">
                <h1>🍭 Crear Nuevo Producto</h1>
                <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
            </header>

            <?php if (isset($_SESSION['errores'])): ?>
                <div class="alert alert-error"><?php echo $_SESSION['errores']; unset($_SESSION['errores']); ?></div>
            <?php endif; ?>

            <div class="form-container">
                <form method="POST" action="../../../Controlador/admin/DulceriaControlador.php" enctype="multipart/form-data">
                    <input type="hidden" name="accion" value="crear">

                    <div class="form-group">
                        <label>Nombre del Producto *</label>
                        <input type="text" name="nombre" value="<?php echo $_POST['nombre'] ?? ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Categoría *</label>
                        <select name="categoria" required>
                            <option value="">Seleccionar categoría...</option>
                            <option value="bebidas" <?php echo ($_POST['categoria'] ?? '') == 'bebidas' ? 'selected' : ''; ?>>🥤 Bebidas</option>
                            <option value="snacks" <?php echo ($_POST['categoria'] ?? '') == 'snacks' ? 'selected' : ''; ?>>🍿 Snacks</option>
                            <option value="dulces" <?php echo ($_POST['categoria'] ?? '') == 'dulces' ? 'selected' : ''; ?>>🍬 Dulces</option>
                            <option value="combos" <?php echo ($_POST['categoria'] ?? '') == 'combos' ? 'selected' : ''; ?>>🎁 Combos</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Precio (S/) *</label>
                        <input type="number" step="0.01" name="precio" value="<?php echo $_POST['precio'] ?? ''; ?>" placeholder="10.50" required>
                    </div>

                    <div class="form-group">
                        <label>Imagen del Producto</label>
                        <input type="file" name="imagen" accept="image/*">
                        <small>Formatos permitidos: JPG, PNG, GIF</small>
                    </div>

                    <div class="form-actions">
                        <a href="index.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Crear Producto</button>
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
        .form-group small { display: block; margin-top: 5px; color: #666; font-size: 12px; }
        .form-actions { text-align: center; padding-top: 20px; }
        .btn { padding: 10px 20px; margin: 0 10px; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn-primary { background: #3498db; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .alert-error { background: #f8d7da; color: #721c24; margin: 20px; padding: 15px; border-radius: 8px; }
    </style>
</body>
</html>