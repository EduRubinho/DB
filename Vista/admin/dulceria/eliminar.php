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
    <title>Eliminar Producto - Admin</title>
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
                <h1>🗑️ Eliminar Producto</h1>
                <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
            </header>

            <div class="delete-container">
                <div class="delete-card">
                    <!-- Header de advertencia -->
                    <div class="warning-header">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h2>⚠️ Confirmar Eliminación</h2>
                        <p>Esta acción no se puede deshacer</p>
                    </div>

                    <!-- Información del producto -->
                    <div class="product-summary">
                        <div class="product-display">
                            <div class="product-image">
                                <?php if (!empty($producto['imagen'])): ?>
                                    <img src="../../uploads/dulceria/<?php echo $producto['imagen']; ?>" 
                                         alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                                <?php else: ?>
                                    <div class="no-image">
                                        <i class="fas fa-image"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="product-details">
                                <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                                
                                <div class="detail-grid">
                                    <div class="detail-item">
                                        <strong>ID:</strong>
                                        <span><?php echo $producto['id']; ?></span>
                                    </div>
                                    
                                    <div class="detail-item">
                                        <strong>Categoría:</strong>
                                        <span class="badge badge-<?php echo $producto['categoria']; ?>">
                                            <?php 
                                            $categorias = [
                                                'bebidas' => '🥤 Bebidas',
                                                'snacks' => '🍿 Snacks', 
                                                'dulces' => '🍬 Dulces',
                                                'combos' => '🎁 Combos'
                                            ];
                                            echo $categorias[$producto['categoria']] ?? ucfirst($producto['categoria']);
                                            ?>
                                        </span>
                                    </div>
                                    
                                    <div class="detail-item">
                                        <strong>Precio:</strong>
                                        <span class="price">S/ <?php echo number_format($producto['precio'], 2); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Advertencias adicionales -->
                        <div class="warning-box">
                            <h4><i class="fas fa-info-circle"></i> Información importante:</h4>
                            <ul>
                                <li>Se eliminará el producto de la base de datos</li>
                                <li>Se eliminará la imagen asociada del servidor</li>
                                <li>Esta acción es <strong>irreversible</strong></li>
                                <li>Si hay pedidos con este producto, podrían verse afectados</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="delete-actions">
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                        
                        <form method="POST" action="../../../Controlador/admin/DulceriaControlador.php" style="display: inline;" 
                              onsubmit="return confirmarEliminacion()">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Eliminar Definitivamente
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        .delete-container { padding: 20px; display: flex; justify-content: center; }
        .delete-card { background: white; border-radius: 8px; max-width: 600px; width: 100%; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        
        .warning-header { background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; padding: 30px; text-align: center; }
        .warning-header i { font-size: 48px; margin-bottom: 15px; animation: pulse 2s infinite; }
        .warning-header h2 { margin: 0 0 10px 0; font-size: 24px; }
        .warning-header p { margin: 0; opacity: 0.9; }
        
        @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }
        
        .product-summary { padding: 30px; }
        .product-display { display: flex; gap: 20px; margin-bottom: 25px; }
        .product-image { width: 120px; height: 120px; flex-shrink: 0; }
        .product-image img { width: 100%; height: 100%; object-fit: cover; border-radius: 8px; }
        .no-image { width: 100%; height: 100%; background: #f8f9fa; border: 2px dashed #ddd; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #ccc; }
        .no-image i { font-size: 32px; }
        
        .product-details { flex: 1; }
        .product-details h3 { margin: 0 0 15px 0; color: #2c3e50; font-size: 20px; }
        .detail-grid { display: grid; gap: 10px; }
        .detail-item { display: flex; justify-content: space-between; align-items: center; padding: 8px 12px; background: #f8f9fa; border-radius: 4px; }
        .detail-item strong { color: #2c3e50; }
        .price { font-weight: bold; color: #27ae60; font-size: 18px; }
        
        .badge { padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: bold; }
        .badge-bebidas { background: #e3f2fd; color: #1976d2; }
        .badge-snacks { background: #fff3e0; color: #f57c00; }
        .badge-dulces { background: #fce4ec; color: #c2185b; }
        .badge-combos { background: #e8f5e8; color: #388e3c; }
        
        .warning-box { background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 20px; }
        .warning-box h4 { margin: 0 0 10px 0; color: #856404; }
        .warning-box ul { margin: 0; padding-left: 20px; color: #856404; }
        .warning-box li { margin-bottom: 5px; }
        
        .delete-actions { padding: 30px; text-align: center; border-top: 1px solid #eee; background: #fafafa; }
        .btn { padding: 12px 24px; margin: 0 10px; text-decoration: none; border-radius: 6px; border: none; cursor: pointer; font-size: 14px; font-weight: 600; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.2); }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-danger { background: #e74c3c; color: white; }
        .btn-danger:hover { background: #c0392b; }
        
        @media (max-width: 768px) {
            .product-display { flex-direction: column; align-items: center; text-align: center; }
            .delete-actions { padding: 20px; }
            .btn { display: block; margin: 10px auto; width: 200px; }
        }
    </style>

    <script>
        function confirmarEliminacion() {
            return confirm('¿Estás completamente seguro de que quieres eliminar este producto?\n\n"<?php echo addslashes($producto['nombre']); ?>"\n\nEsta acción NO se puede deshacer.');
        }
    </script>
</body>
</html>