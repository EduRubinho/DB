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

$datos = $_POST ?: $cliente;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Cliente - Admin</title>
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
                <h1>✏️ Actualizar Cliente</h1>
                <div class="header-actions">
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </header>

            <?php if (isset($_SESSION['errores'])): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $_SESSION['errores']; unset($_SESSION['errores']); ?>
                </div>
            <?php endif; ?>

            <div class="form-container">
                <form method="POST" action="../../../Controlador/admin/ClienteRegistradoControlador.php" class="simple-form">
                    <input type="hidden" name="accion" value="actualizar">
                    <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">

                    <div class="form-columns">
                        <div class="form-column">
                            <h3>📋 Información Personal</h3>
                            
                            <div class="form-group">
                                <label>Nombre *</label>
                                <input type="text" name="nombre" value="<?php echo htmlspecialchars($datos['nombre']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Apellido Paterno *</label>
                                <input type="text" name="apellido_paterno" value="<?php echo htmlspecialchars($datos['apellido_paterno']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Apellido Materno</label>
                                <input type="text" name="apellido_materno" value="<?php echo htmlspecialchars($datos['apellido_materno']); ?>">
                            </div>

                            <div class="form-group">
                                <label>Género *</label>
                                <select name="genero" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="Masculino" <?php echo $datos['genero'] === 'Masculino' ? 'selected' : ''; ?>>Masculino</option>
                                    <option value="Femenino" <?php echo $datos['genero'] === 'Femenino' ? 'selected' : ''; ?>>Femenino</option>
                                    <option value="Otro" <?php echo $datos['genero'] === 'Otro' ? 'selected' : ''; ?>>Otro</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Fecha de Nacimiento *</label>
                                <input type="date" name="fecha_nacimiento" value="<?php echo $datos['fecha_nacimiento']; ?>" required>
                            </div>
                        </div>

                        <div class="form-column">
                            <h3>📄 Documentación</h3>
                            
                            <div class="form-group">
                                <label>Tipo de Documento *</label>
                                <select name="tipo_documento" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="DNI" <?php echo $datos['tipo_documento'] === 'DNI' ? 'selected' : ''; ?>>DNI</option>
                                    <option value="Pasaporte" <?php echo $datos['tipo_documento'] === 'Pasaporte' ? 'selected' : ''; ?>>Pasaporte</option>
                                    <option value="CE" <?php echo $datos['tipo_documento'] === 'CE' ? 'selected' : ''; ?>>Carné de Extranjería</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Número de Documento *</label>
                                <input type="text" name="DNI" value="<?php echo htmlspecialchars($datos['DNI']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Correo Electrónico *</label>
                                <input type="email" name="correo" value="<?php echo htmlspecialchars($datos['correo']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Celular *</label>
                                <input type="tel" name="celular" value="<?php echo htmlspecialchars($datos['celular']); ?>" required>
                            </div>
                        </div>

                        <div class="form-column">
                            <h3>📍 Ubicación</h3>
                            
                            <div class="form-group">
                                <label>Departamento *</label>
                                <input type="text" name="departamento" value="<?php echo htmlspecialchars($datos['departamento']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Provincia *</label>
                                <input type="text" name="provincia" value="<?php echo htmlspecialchars($datos['provincia']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Distrito *</label>
                                <input type="text" name="distrito" value="<?php echo htmlspecialchars($datos['distrito']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Cineplanet Preferido</label>
                                <input type="text" name="cineplanet" value="<?php echo htmlspecialchars($datos['cineplanet']); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Actualizar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <style>
        .form-container {
            background: white;
            margin: 30px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .form-columns {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .form-column h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .form-actions {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding-top: 30px;
            border-top: 2px solid #e9ecef;
        }

        @media (max-width: 768px) {
            .form-columns {
                grid-template-columns: 1fr;
            }
        }
    </style>
</body>
</html>