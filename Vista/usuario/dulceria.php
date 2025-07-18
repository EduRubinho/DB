<?php
require_once __DIR__ . '/../../config/session.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$boleta_id = $_GET['boleta_id'] ?? null;
if (!$boleta_id) {
    header('Location: mis_boletas.php');
    exit;
}

require_once __DIR__ . '/../../Controlador/usuario/DulceriaControlador.php';

$controlador = new DulceriaControlador();
$productos = $controlador->obtenerTodos();

// Agrupar por categoría
$categorias = [];
foreach ($productos as $producto) {
    $categorias[$producto['categoria']][] = $producto;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dulcería - Cineplanet</title>
    <link rel="stylesheet" href="../css/dulceria.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>🍿 Dulcería Cineplanet</h1>
            <p>Completa tu experiencia cinematográfica</p>
        </header>

        <form action="../../Controlador/usuario/DulceriaControlador.php" method="POST" id="dulceriaForm">
            <input type="hidden" name="accion" value="agregar_productos">
            <input type="hidden" name="boleta_id" value="<?php echo $boleta_id; ?>">

            <?php foreach ($categorias as $categoria => $items): ?>
                <section class="categoria-section">
                    <h2 class="categoria-titulo">
                        <?php 
                        $iconos = [
                            'combos' => '🎭',
                            'bebidas' => '🥤', 
                            'snacks' => '🍿',
                            'dulces' => '🍭'
                        ];
                        echo $iconos[$categoria] ?? '🍽️';
                        echo ' ' . ucfirst($categoria);
                        ?>
                    </h2>
                    
                    <div class="productos-grid">
                        <?php foreach ($items as $producto): ?>
                            <div class="producto-card">
                                <div class="producto-imagen">
                                    <?php if ($producto['imagen']): ?>
                                        <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" 
                                             alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                                    <?php else: ?>
                                        <div class="no-image">🍿</div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="producto-info">
                                    <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                                    <p class="precio">S/ <?php echo number_format($producto['precio'], 2); ?></p>
                                    
                                    <div class="cantidad-control">
                                        <button type="button" class="btn-cantidad" onclick="cambiarCantidad(<?php echo $producto['id']; ?>, -1)">-</button>
                                        <input type="number" 
                                               name="productos[<?php echo $producto['id']; ?>]" 
                                               id="cantidad_<?php echo $producto['id']; ?>"
                                               value="0" 
                                               min="0" 
                                               max="10"
                                               readonly>
                                        <button type="button" class="btn-cantidad" onclick="cambiarCantidad(<?php echo $producto['id']; ?>, 1)">+</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>

            <div class="resumen-compra">
                <div class="total-info">
                    <h3>Total Dulcería: S/ <span id="totalDulceria">0.00</span></h3>
                </div>
                
                <div class="acciones">
                    <a href="boleta.php?id=<?php echo $boleta_id; ?>" class="btn btn-secondary">
                        Omitir Dulcería
                    </a>
                    <button type="submit" class="btn btn-primary">
                        🛒 Agregar a mi Compra
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        const precios = <?php echo json_encode(array_column($productos, 'precio', 'id')); ?>;
        
        function cambiarCantidad(productoId, cambio) {
            const input = document.getElementById('cantidad_' + productoId);
            let cantidad = parseInt(input.value) + cambio;
            
            if (cantidad < 0) cantidad = 0;
            if (cantidad > 10) cantidad = 10;
            
            input.value = cantidad;
            actualizarTotal();
        }
        
        function actualizarTotal() {
            let total = 0;
            
            Object.keys(precios).forEach(id => {
                const cantidad = parseInt(document.getElementById('cantidad_' + id).value) || 0;
                total += cantidad * precios[id];
            });
            
            document.getElementById('totalDulceria').textContent = total.toFixed(2);
        }

        // Validar antes de enviar
        document.getElementById('dulceriaForm').addEventListener('submit', function(e) {
            const total = parseFloat(document.getElementById('totalDulceria').textContent);
            
            if (total === 0) {
                const confirmar = confirm('No has seleccionado productos. ¿Deseas continuar sin dulcería?');
                if (!confirmar) {
                    e.preventDefault();
                }
            }
        });
    </script>
</body>
</html>