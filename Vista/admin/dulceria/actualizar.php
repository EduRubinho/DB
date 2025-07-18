<?php
require_once __DIR__ . '/../../../Config/session.php';
if (!isset($_SESSION['admin'])) {
    header('Location: ../login_admin.php');
    exit;
}

require_once __DIR__ . '/../../../Controlador/admin/DulceriaControlador.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$controlador = new DulceriaControlador();
$producto = $controlador->obtenerPorId($id);

if (!$producto) {
    $_SESSION['errores'] = 'Producto no encontrado';
    header('Location: index.php');
    exit;
}

// Usar datos POST si hay errores, sino usar datos del producto
$datos = $_POST ?: $producto;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Producto - Admin</title>
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
                <h1>✏️ Actualizar Producto</h1>
                <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
            </header>

            <?php if (isset($_SESSION['errores'])): ?>
                <div class="alert alert-error"><?php echo $_SESSION['errores']; unset($_SESSION['errores']); ?></div>
            <?php endif; ?>

            <div class="form-container">
                <div class="form-with-preview">
                    <!-- Vista previa de imagen actual -->
                    <div class="image-preview">
                        <h3>Imagen Actual</h3>
                        <?php if (!empty($producto['imagen'])): ?>
                            <img src="../../uploads/dulceria/<?php echo $producto['imagen']; ?>" 
                                 alt="<?php echo htmlspecialchars($producto['nombre']); ?>"
                                 style="width: 200px; height: 200px; object-fit: cover; border-radius: 8px;">
                            <p style="margin-top: 10px; font-size: 12px; color: #666;">
                                <?php echo $producto['imagen']; ?>
                            </p>
                        <?php else: ?>
                            <div style="width: 200px; height: 200px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: 2px dashed #ddd;">
                                <div style="text-align: center; color: #ccc;">
                                    <i class="fas fa-image" style="font-size: 48px; margin-bottom: 10px;"></i>
                                    <p>Sin imagen</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Formulario -->
                    <div class="form-section">
                        <form method="POST" action="../../../Controlador/admin/DulceriaControlador.php" enctype="multipart/form-data">
                            <input type="hidden" name="accion" value="actualizar">
                            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">

                            <div class="form-group">
                                <label>Nombre del Producto *</label>
                                <input type="text" name="nombre" value="<?php echo htmlspecialchars($datos['nombre']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Categoría *</label>
                                <select name="categoria" required>
                                    <option value="bebidas" <?php echo $datos['categoria'] == 'bebidas' ? 'selected' : ''; ?>>🥤 Bebidas</option>
                                    <option value="snacks" <?php echo $datos['categoria'] == 'snacks' ? 'selected' : ''; ?>>🍿 Snacks</option>
                                    <option value="dulces" <?php echo $datos['categoria'] == 'dulces' ? 'selected' : ''; ?>>🍬 Dulces</option>
                                    <option value="combos" <?php echo $datos['categoria'] == 'combos' ? 'selected' : ''; ?>>🎁 Combos</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Precio (S/) *</label>
                                <input type="number" step="0.01" name="precio" value="<?php echo $datos['precio']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Nueva Imagen (opcional)</label>
                                <input type="file" name="imagen" accept="image/*">
                                <small style="color: #666;">Deja vacío para mantener la imagen actual. Formatos: JPG, PNG, GIF</small>
                            </div>

                            <div class="form-actions">
                                <a href="index.php" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Actualizar Producto
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        .form-container { background: white; margin: 20px; padding: 30px; border-radius: 8px; }
        .form-with-preview { display: grid; grid-template-columns: 250px 1fr; gap: 30px; align-items: start; }
        .image-preview h3 { margin: 0 0 15px 0; color: #2c3e50; font-size: 16px; }
        .form-section { min-width: 0; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; color: #2c3e50; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; font-size: 14px; }
        .form-group input:focus, .form-group select:focus { border-color: #3498db; outline: none; box-shadow: 0 0 5px rgba(52, 152, 219, 0.3); }
        .form-group small { display: block; margin-top: 5px; font-size: 12px; }
        .form-actions { text-align: center; padding-top: 20px; border-top: 1px solid #eee; margin-top: 20px; }
        .btn { padding: 12px 20px; margin: 0 10px; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; font-size: 14px; transition: all 0.3s; }
        .btn:hover { transform: translateY(-1px); }
        .btn-warning { background: #f39c12; color: white; }
        .btn-warning:hover { background: #e67e22; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-secondary:hover { background: #5a6268; }
        .alert-error { background: #f8d7da; color: #721c24; margin: 20px; padding: 15px; border-radius: 8px; border-left: 4px solid #dc3545; }
        
        @media (max-width: 768px) {
            .form-with-preview { grid-template-columns: 1fr; }
            .image-preview { text-align: center; }
        }
    </style>
</body>
</html>