<?php
require_once __DIR__ . '/../../../config/session.php';
if (!isset($_SESSION['admin'])) {
    header('Location: ../login_admin.php');
    exit;
}

require_once __DIR__ . '/../../../Controlador/admin/ClienteRegistradoControlador.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$controlador = new ClienteRegistradoControlador();
$cliente = $controlador->obtenerPorId($id);

if (!$cliente) {
    $_SESSION['errores'] = 'Cliente no encontrado';
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Cliente - Admin</title>
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>🎬 Admin</h2>
                <p>Cineplanet</p>
            </div>
            <ul class="sidebar-menu">
                <li><a href="../../../Vista/web/admin/inicioadmin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li class="active"><a href="index.php"><i class="fas fa-users"></i> Clientes</a></li>
                <li><a href="../pelicula/index.php"><i class="fas fa-film"></i> Películas</a></li>
                <li><a href="../funcion/index.php"><i class="fas fa-calendar-alt"></i> Funciones</a></li>
                <li><a href="../dulceria/index.php"><i class="fas fa-candy-cane"></i> Dulcería</a></li>
                <li><a href="../boleta/index.php"><i class="fas fa-ticket-alt"></i> Boletas</a></li>
                <li><a href="../../../Vista/web/admin/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <header class="content-header">
                <h1>🗑️ Eliminar Cliente</h1>
                <div class="header-actions">
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </header>

            <div class="delete-container">
                <div class="delete-card">
                    <div class="delete-header">
                        <div class="warning-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h2>⚠️ Confirmar Eliminación</h2>
                        <p>¿Estás seguro de que quieres eliminar este cliente?</p>
                        <p><strong>Esta acción no se puede deshacer.</strong></p>
                    </div>

                    <div class="client-summary">
                        <h3>Cliente a eliminar:</h3>
                        <div class="summary-info">
                            <div class="summary-item">
                                <strong>ID:</strong> <?php echo $cliente['id']; ?>
                            </div>
                            <div class="summary-item">
                                <strong>Nombre:</strong> <?php echo htmlspecialchars($cliente['nombre'] . ' ' . $cliente['apellido_paterno'] . ' ' . $cliente['apellido_materno']); ?>
                            </div>
                            <div class="summary-item">
                                <strong>DNI:</strong> <?php echo htmlspecialchars($cliente['DNI']); ?>
                            </div>
                            <div class="summary-item">
                                <strong>Correo:</strong> <?php echo htmlspecialchars($cliente['correo']); ?>
                            </div>
                        </div>
                    </div>

                    <div class="delete-actions">
                        <a href="index.php" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                        
                        <form method="POST" action="../../../Controlador/admin/ClienteRegistradoControlador.php" style="display: inline;">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-lg" onclick="return confirm('¿Estás completamente seguro de eliminar este cliente?')">
                                <i class="fas fa-trash"></i> Eliminar Cliente
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        .delete-container {
            padding: 30px;
            display: flex;
            justify-content: center;
        }

        .delete-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 100%;
        }

        .delete-header {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 15px 15px 0 0;
        }

        .warning-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .delete-header h2 {
            margin: 0 0 15px 0;
            font-size: 24px;
        }

        .delete-header p {
            margin: 5px 0;
            opacity: 0.9;
        }

        .client-summary {
            padding: 30px;
        }

        .client-summary h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 18px;
        }

        .summary-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #e74c3c;
        }

        .summary-item {
            padding: 8px 0;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-item strong {
            color: #2c3e50;
        }

        .delete-actions {
            padding: 30px;
            display: flex;
            justify-content: center;
            gap: 20px;
            border-top: 2px solid #e9ecef;
        }

        .btn-lg {
            padding: 15px 30px;
            font-size: 16px;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .delete-actions {
                flex-direction: column;
            }
        }
    </style>
</body>
</html>