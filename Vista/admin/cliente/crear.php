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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cliente - Admin</title>
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
                <h1>👤 Crear Nuevo Cliente</h1>
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
                    <input type="hidden" name="accion" value="crear">

                    <div class="form-columns">
                        <div class="form-column">
                            <h3>📋 Información Personal</h3>
                            
                            <div class="form-group">
                                <label>Nombre *</label>
                                <input type="text" name="nombre" value="<?php echo $_POST['nombre'] ?? ''; ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Apellido Paterno *</label>
                                <input type="text" name="apellido_paterno" value="<?php echo $_POST['apellido_paterno'] ?? ''; ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Apellido Materno</label>
                                <input type="text" name="apellido_materno" value="<?php echo $_POST['apellido_materno'] ?? ''; ?>">
                            </div>

                            <div class="form-group">
                                <label>Género *</label>
                                <select name="genero" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="Masculino" <?php echo ($_POST['genero'] ?? '') === 'Masculino' ? 'selected' : ''; ?>>Masculino</option>
                                    <option value="Femenino" <?php echo ($_POST['genero'] ?? '') === 'Femenino' ? 'selected' : ''; ?>>Femenino</option>
                                    <option value="Otro" <?php echo ($_POST['genero'] ?? '') === 'Otro' ? 'selected' : ''; ?>>Otro</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Fecha de Nacimiento *</label>
                                <input type="date" name="fecha_nacimiento" value="<?php echo $_POST['fecha_nacimiento'] ?? ''; ?>" required>
                            </div>
                        </div>

                        <div class="form-column">
                            <h3>📄 Documentación</h3>
                            
                            <div class="form-group">
                                <label>Tipo de Documento *</label>
                                <select name="tipo_documento" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="DNI" <?php echo ($_POST['tipo_documento'] ?? '') === 'DNI' ? 'selected' : ''; ?>>DNI</option>
                                    <option value="Pasaporte" <?php echo ($_POST['tipo_documento'] ?? '') === 'Pasaporte' ? 'selected' : ''; ?>>Pasaporte</option>
                                    <option value="CE" <?php echo ($_POST['tipo_documento'] ?? '') === 'CE' ? 'selected' : ''; ?>>Carné de Extranjería</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Número de Documento *</label>
                                <input type="text" name="DNI" value="<?php echo $_POST['DNI'] ?? ''; ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Correo Electrónico *</label>
                                <input type="email" name="correo" value="<?php echo $_POST['correo'] ?? ''; ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Celular *</label>
                                <input type="tel" name="celular" value="<?php echo $_POST['celular'] ?? ''; ?>" required>
                            </div>
                        </div>

                        <div class="form-column">
                            <h3>📍 Ubicación</h3>
                            
                            <div class="form-group">
                                <label>Departamento *</label>
                                <input type="text" name="departamento" value="<?php echo $_POST['departamento'] ?? ''; ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Provincia *</label>
                                <input type="text" name="provincia" value="<?php echo $_POST['provincia'] ?? ''; ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Distrito *</label>
                                <input type="text" name="distrito" value="<?php echo $_POST['distrito'] ?? ''; ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Contraseña *</label>
                                <input type="password" name="password" required minlength="6">
                            </div>

                            <div class="form-group">
                                <label>Confirmar Contraseña *</label>
                                <input type="password" name="confirm_password" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Crear Cliente
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <style>
        /* ===== CONTENEDOR FORMULARIO ===== */
        .form-container {
            background: white;
            margin: 30px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.5s ease;
        }

        /* ===== COLUMNAS DEL FORMULARIO ===== */
        .form-columns {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .form-column {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 12px;
            border-left: 4px solid #3498db;
            transition: all 0.3s ease;
        }

        .form-column:hover {
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.1);
            transform: translateY(-2px);
        }

        .form-column h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
        }

        /* ===== GRUPOS DE FORMULARIO ===== */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group label::after {
            content: '';
            margin-left: 3px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: white;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
            transform: translateY(-1px);
        }

        .form-group input:valid {
            border-color: #27ae60;
        }

        .form-group input:invalid:not(:focus):not(:placeholder-shown) {
            border-color: #e74c3c;
        }

        /* ===== CAMPOS ESPECÍFICOS ===== */
        .form-group select {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 40px;
            appearance: none;
        }

        .form-group input[type="date"] {
            position: relative;
        }

        .form-group input[type="password"] {
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
        }

        .form-group input[type="email"] {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3e%3cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 18px;
            padding-right: 40px;
        }

        .form-group input[type="tel"] {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3e%3cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 18px;
            padding-right: 40px;
        }

        /* ===== ACCIONES DEL FORMULARIO ===== */
        .form-actions {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 30px 0 0 0;
            border-top: 2px solid #e9ecef;
            margin-top: 30px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2980b9, #21618c);
            color: white;
            text-decoration: none;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            color: white;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #5a6268, #495057);
            color: white;
            text-decoration: none;
        }

        /* ===== VALIDACIÓN VISUAL ===== */
        .form-group input:required:valid::after {
            content: '✓';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #27ae60;
            font-weight: bold;
        }

        /* ===== EFECTOS HOVER ===== */
        .form-group:hover label {
            color: #3498db;
        }

        .form-group:hover input,
        .form-group:hover select {
            border-color: #3498db;
        }

        /* ===== ANIMACIONES ===== */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .form-column {
            animation: fadeIn 0.6s ease forwards;
        }

        .form-column:nth-child(1) { animation-delay: 0.1s; }
        .form-column:nth-child(2) { animation-delay: 0.2s; }
        .form-column:nth-child(3) { animation-delay: 0.3s; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .form-columns {
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }
        }

        @media (max-width: 768px) {
            .form-container {
                margin: 20px;
                padding: 20px;
            }

            .form-columns {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .form-column {
                padding: 20px;
            }

            .form-actions {
                flex-direction: column;
                gap: 15px;
            }

            .btn {
                padding: 12px 20px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .form-column h3 {
                font-size: 16px;
            }

            .form-group label {
                font-size: 13px;
            }

            .form-group input,
            .form-group select {
                padding: 10px 12px;
                font-size: 13px;
            }
        }

        /* ===== ESTADOS DE CARGA ===== */
        .form-container.loading {
            position: relative;
            pointer-events: none;
        }

        .form-container.loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ===== TOOLTIPS ===== */
        .form-group input[title]:hover::after {
            content: attr(title);
            position: absolute;
            bottom: -30px;
            left: 0;
            background: #2c3e50;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1000;
        }
    </style>

    <script>
        // Validación en tiempo real
        document.querySelectorAll('input[required]').forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    this.style.borderColor = '#e74c3c';
                } else {
                    this.style.borderColor = '#27ae60';
                }
            });
        });

        // Validación de contraseñas
        const password = document.querySelector('input[name="password"]');
        const confirmPassword = document.querySelector('input[name="confirm_password"]');

        confirmPassword.addEventListener('input', function() {
            if (this.value !== password.value) {
                this.setCustomValidity('Las contraseñas no coinciden');
                this.style.borderColor = '#e74c3c';
            } else {
                this.setCustomValidity('');
                this.style.borderColor = '#27ae60';
            }
        });

        // Animación del formulario
        document.querySelector('.simple-form').addEventListener('submit', function() {
            document.querySelector('.form-container').classList.add('loading');
        });
    </script>
</body>
</html>