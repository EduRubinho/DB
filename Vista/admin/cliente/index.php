<?php
require_once __DIR__ . '/../../../config/session.php';

if (!isset($_SESSION['admin'])) {
    header('Location: ../login_admin.php');
    exit;
}

require_once __DIR__ . '/../../../Controlador/admin/ClienteRegistradoControlador.php';

$controlador = new ClienteRegistradoControlador();

$page = $_GET['page'] ?? 1;
$busqueda = $_GET['busqueda'] ?? '';

if ($busqueda) {
    $clientes = $controlador->buscar($busqueda);
    $total = count($clientes);
} else {
    $clientes = $controlador->obtenerTodos($page, 20);
    $total = $controlador->contarTotal();
}

$total_paginas = ceil($total / 20);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Admin Cineplanet</title>
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
                <li>
                    <a href="../../../Vista/web/admin/inicioadmin.php">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li class="active">
                    <a href="index.php">
                        <i class="fas fa-users"></i>
                        Clientes
                    </a>
                </li>
                <li>
                    <a href="../pelicula/index.php">
                        <i class="fas fa-film"></i>
                        Películas
                    </a>
                </li>
                <li>
                    <a href="../funcion/index.php">
                        <i class="fas fa-calendar-alt"></i>
                        Funciones
                    </a>
                </li>
                <li>
                    <a href="../dulceria/index.php">
                        <i class="fas fa-candy-cane"></i>
                        Dulcería
                    </a>
                </li>
                <li>
                    <a href="../boleta/index.php">
                        <i class="fas fa-ticket-alt"></i>
                        Boletas
                    </a>
                </li>
                <li>
                    <a href="../../../Vista/web/admin/logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        Cerrar Sesión
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <header class="content-header">
                <h1>👥 Gestión de Clientes</h1>
                <div class="header-actions">
                    <a href="crear.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Nuevo Cliente
                    </a>
                </div>
            </header>

            <!-- Mensajes -->
            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['errores'])): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $_SESSION['errores']; unset($_SESSION['errores']); ?>
                </div>
            <?php endif; ?>

            <!-- Filtros y búsqueda -->
            <div class="filters-section">
                <form method="GET" class="search-form">
                    <div class="search-group">
                        <input type="text" 
                               name="busqueda" 
                               value="<?php echo htmlspecialchars($busqueda); ?>" 
                               placeholder="Buscar por nombre, DNI o correo..."
                               class="search-input">
                        <button type="submit" class="btn btn-search">
                            <i class="fas fa-search"></i>
                        </button>
                        <?php if ($busqueda): ?>
                            <a href="index.php" class="btn btn-secondary">
                                <i class="fas fa-times"></i>
                                Limpiar
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Estadísticas rápidas -->
            <div class="stats-mini">
                <div class="stat-mini">
                    <i class="fas fa-users"></i>
                    <div>
                        <h3><?php echo $total; ?></h3>
                        <p>Total Clientes</p>
                    </div>
                </div>
                <div class="stat-mini">
                    <i class="fas fa-user-check"></i>
                    <div>
                        <h3><?php echo count(array_filter($clientes, function($c) { return !empty($c['correo']); })); ?></h3>
                        <p>Con Email</p>
                    </div>
                </div>
                <div class="stat-mini">
                    <i class="fas fa-mobile-alt"></i>
                    <div>
                        <h3><?php echo count(array_filter($clientes, function($c) { return !empty($c['celular']); })); ?></h3>
                        <p>Con Celular</p>
                    </div>
                </div>
            </div>

            <!-- Tabla de clientes -->
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>DNI</th>
                            <th>Contacto</th>
                            <th>Ubicación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($clientes)): ?>
                            <tr>
                                <td colspan="6" class="no-data">
                                    <i class="fas fa-inbox"></i>
                                    <p>No se encontraron clientes</p>
                                    <a href="crear.php" class="btn btn-primary">Crear primer cliente</a>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($clientes as $cliente): ?>
                                <tr>
                                    <td class="id-column"><?php echo $cliente['id']; ?></td>
                                    <td>
                                        <div class="user-info">
                                            <strong><?php echo htmlspecialchars($cliente['nombre'] . ' ' . $cliente['apellido_paterno'] . ' ' . $cliente['apellido_materno']); ?></strong>
                                            <small class="gender-badge <?php echo strtolower($cliente['genero']); ?>">
                                                <?php echo $cliente['genero']; ?>
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="dni-badge"><?php echo htmlspecialchars($cliente['DNI']); ?></span>
                                    </td>
                                    <td>
                                        <div class="contact-info">
                                            <small><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($cliente['correo']); ?></small>
                                            <small><i class="fas fa-phone"></i> <?php echo htmlspecialchars($cliente['celular']); ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="location">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <?php echo htmlspecialchars($cliente['distrito'] . ', ' . $cliente['provincia']); ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="consultar.php?id=<?php echo $cliente['id']; ?>" 
                                               class="btn btn-sm btn-info" 
                                               title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="actualizar.php?id=<?php echo $cliente['id']; ?>" 
                                               class="btn btn-sm btn-warning" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="eliminar.php?id=<?php echo $cliente['id']; ?>" 
                                               class="btn btn-sm btn-danger" 
                                               title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <?php if (!$busqueda && $total_paginas > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>" class="pagination-btn">
                            <i class="fas fa-chevron-left"></i>
                            Anterior
                        </a>
                    <?php endif; ?>

                    <div class="pagination-numbers">
                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                            <a href="?page=<?php echo $i; ?>" 
                               class="pagination-btn <?php echo $i == $page ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </div>

                    <?php if ($page < $total_paginas): ?>
                        <a href="?page=<?php echo $page + 1; ?>" class="pagination-btn">
                            Siguiente
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <style>
        .filters-section {
            background: white;
            margin: 20px 30px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .search-form {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-group {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }

        .search-input {
            flex: 1;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .btn-search {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
        }

        .stats-mini {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 20px 30px;
        }

        .stat-mini {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-mini i {
            font-size: 28px;
            color: #3498db;
        }

        .stat-mini h3 {
            font-size: 24px;
            color: #2c3e50;
            margin: 0;
        }

        .stat-mini p {
            color: #6c757d;
            margin: 0;
            font-size: 14px;
        }

        .table-container {
            background: white;
            margin: 20px 30px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }

        .data-table td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .data-table tr:hover {
            background: #f8f9fa;
        }

        .id-column {
            font-weight: 600;
            color: #3498db;
        }

        .user-info strong {
            display: block;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .gender-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
        }

        .gender-badge.masculino {
            background: #e3f2fd;
            color: #1976d2;
        }

        .gender-badge.femenino {
            background: #fce4ec;
            color: #c2185b;
        }

        .gender-badge.otro {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .dni-badge {
            background: #e8f5e8;
            color: #2e7d32;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 13px;
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .contact-info small {
            color: #6c757d;
            font-size: 12px;
        }

        .contact-info i {
            width: 12px;
            margin-right: 5px;
        }

        .location {
            color: #6c757d;
            font-size: 12px;
        }

        .location i {
            margin-right: 5px;
            color: #e74c3c;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .btn-sm {
            padding: 8px 12px;
            font-size: 12px;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-sm:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .no-data i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #dee2e6;
        }

        .no-data p {
            margin: 10px 0 20px 0;
            font-size: 16px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin: 30px;
        }

        .pagination-numbers {
            display: flex;
            gap: 5px;
        }

        .pagination-btn {
            padding: 10px 15px;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            text-decoration: none;
            color: #6c757d;
            transition: all 0.3s ease;
        }

        .pagination-btn:hover,
        .pagination-btn.active {
            background: #3498db;
            color: white;
            border-color: #3498db;
        }

        @media (max-width: 768px) {
            .data-table {
                font-size: 12px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .stats-mini {
                grid-template-columns: 1fr;
            }
        }
    </style>
</body>
</html>