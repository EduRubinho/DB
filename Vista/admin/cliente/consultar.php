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
    <title>Ver Cliente - Admin</title>
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
                <h1>👤 Ver Cliente</h1>
                <div class="header-actions">
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <a href="actualizar.php?id=<?php echo $cliente['id']; ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                </div>
            </header>

            <div class="view-container">
                <div class="client-card">
                    <div class="client-header">
                        <h2><?php echo htmlspecialchars($cliente['nombre'] . ' ' . $cliente['apellido_paterno'] . ' ' . $cliente['apellido_materno']); ?></h2>
                        <span class="client-id">ID: <?php echo $cliente['id']; ?></span>
                    </div>

                    <div class="client-info">
                        <div class="info-section">
                            <h3>📋 Información Personal</h3>
                            <div class="info-grid">
                                <div><strong>Género:</strong> <?php echo htmlspecialchars($cliente['genero']); ?></div>
                                <div><strong>Fecha Nacimiento:</strong> <?php echo date('d/m/Y', strtotime($cliente['fecha_nacimiento'])); ?></div>
                                <div><strong>Tipo Documento:</strong> <?php echo htmlspecialchars($cliente['tipo_documento']); ?></div>
                                <div><strong>N° Documento:</strong> <?php echo htmlspecialchars($cliente['DNI']); ?></div>
                            </div>
                        </div>

                        <div class="info-section">
                            <h3>📞 Contacto</h3>
                            <div class="info-grid">
                                <div><strong>Correo:</strong> <?php echo htmlspecialchars($cliente['correo']); ?></div>
                                <div><strong>Celular:</strong> <?php echo htmlspecialchars($cliente['celular']); ?></div>
                            </div>
                        </div>

                        <div class="info-section">
                            <h3>📍 Ubicación</h3>
                            <div class="info-grid">
                                <div><strong>Departamento:</strong> <?php echo htmlspecialchars($cliente['departamento']); ?></div>
                                <div><strong>Provincia:</strong> <?php echo htmlspecialchars($cliente['provincia']); ?></div>
                                <div><strong>Distrito:</strong> <?php echo htmlspecialchars($cliente['distrito']); ?></div>
                                <?php if ($cliente['cineplanet']): ?>
                                <div><strong>Cineplanet Preferido:</strong> <?php echo htmlspecialchars($cliente['cineplanet']); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        .view-container {
            padding: 30px;
        }

        .client-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .client-header {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .client-header h2 {
            margin: 0 0 10px 0;
            font-size: 28px;
        }

        .client-id {
            opacity: 0.9;
            font-size: 14px;
        }

        .client-info {
            padding: 30px;
        }

        .info-section {
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #3498db;
        }

        .info-section h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .info-grid div {
            padding: 10px;
            background: white;
            border-radius: 6px;
            font-size: 14px;
        }

        .info-grid strong {
            color: #2c3e50;
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</body>
</html>