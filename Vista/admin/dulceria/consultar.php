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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Producto - Admin</title>
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
                <h1>🍭 Ver Producto</h1>
                <div>
                    <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
                    <a href="actualizar.php?id=<?php echo $producto['id']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Editar</a>
                </div>
            </header>

            <div class="view-container">
                <div class="product-card">
                    <div class="product-image">
                        <?php if (!empty($producto['imagen'])): ?>
                            <img src="../../uploads/dulceria/<?php echo $producto['imagen']; ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        <?php else: ?>
                            <div class="no-image">
                                <i class="fas fa-image"></i>
                                <p>Sin imagen</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="product-info">
                        <h2><?php echo htmlspecialchars($producto['nombre']); ?></h2>
                        
                        <div class="info-grid">
                            <div class="info-item">
                                <strong>ID:</strong>
                                <span><?php echo $producto['id']; ?></span>
                            </div>
                            
                            <div class="info-item">
                                <strong>Categoría:</strong>
                                <span class="badge badge-<?php echo $producto['categoria']; ?>">
                                    <?php echo ucfirst($producto['categoria']); ?>
                                </span>
                            </div>
                            
                            <div class="info-item">
                                <strong>Precio:</strong>
                                <span class="price">S/ <?php echo number_format($producto['precio'], 2); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        .view-container { padding: 20px; }
        .product-card { background: white; border-radius: 8px; overflow: hidden; display: flex; max-width: 800px; }
        .product-image { width: 300px; height: 300px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; }
        .product-image img { width: 100%; height: 100%; object-fit: cover; }
        .no-image { text-align: center; color: #ccc; }
        .no-image i { font-size: 48px; margin-bottom: 10px; }
        .product-info { flex: 1; padding: 30px; }
        .product-info h2 { margin: 0 0 20px 0; color: #2c3e50; }
        .info-grid { display: grid; gap: 15px; }
        .info-item { display: flex; justify-content: space-between; align-items: center; padding: 10px; background: #f8f9fa; border-radius: 4px; }
        .price { font-size: 1.5rem; font-weight: bold; color: #27ae60; }
        .badge { padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: bold; }
        .badge-bebidas { background: #e3f2fd; color: #1976d2; }
        .badge-snacks { background: #fff3e0; color: #f57c00; }
        .badge-dulces { background: #fce4ec; color: #c2185b; }
        .badge-combos { background: #e8f5e8; color: #388e3c; }
    </style>
</body>
</html>