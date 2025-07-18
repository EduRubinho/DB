<?php
require_once __DIR__ . '/../../config/session.php';
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = $_SESSION['usuario'];
$mensaje = $_SESSION['mensaje'] ?? '';
$errores = $_SESSION['errores'] ?? '';

unset($_SESSION['mensaje'], $_SESSION['errores']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Cineplanet</title>
    <link rel="stylesheet" href="../css/perfil.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="nav-back">
                <a href="peliculas.php" class="btn btn-back">← Volver a Cartelera</a>
                <a href="mis_boletas.php" class="btn btn-primary">📄 Mis Boletas</a>
            </div>
            <h1>👤 Mi Perfil</h1>
        </header>

        <?php if ($mensaje): ?>
            <div class="alert alert-success">
                ✅ <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <?php if ($errores): ?>
            <div class="alert alert-error">
                ❌ <?php echo htmlspecialchars($errores); ?>
            </div>
        <?php endif; ?>

        <div class="profile-container">
            <div class="profile-header">
                <div class="avatar">
                    <span class="avatar-text">
                        <?php echo strtoupper(substr($usuario['nombre'], 0, 1) . substr($usuario['apellido_paterno'], 0, 1)); ?>
                    </span>
                </div>
                <div class="profile-info">
                    <h2><?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido_paterno'] . ' ' . $usuario['apellido_materno']); ?></h2>
                    <p class="user-type">Cliente Cineplanet</p>
                    <p class="member-since">Miembro desde <?php echo date('Y', strtotime($usuario['fecha_nacimiento'] ?? 'now')); ?></p>
                </div>
            </div>

            <div class="tabs-container">
                <div class="tabs">
                    <button class="tab-button active" onclick="showTab('personal')">📋 Datos Personales</button>
                    <button class="tab-button" onclick="showTab('contacto')">📞 Contacto</button>
                    <button class="tab-button" onclick="showTab('ubicacion')">📍 Ubicación</button>
                </div>

                <form action="../../Controlador/usuario/UsuarioControlador.php" method="POST" class="profile-form">
                    <input type="hidden" name="accion" value="actualizar_perfil">

                    <!-- Tab: Datos Personales -->
                    <div id="tab-personal" class="tab-content active">
                        <h3>📋 Información Personal</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="nombre">Nombre *</label>
                                <input type="text" id="nombre" name="nombre" 
                                       value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="apellido_paterno">Apellido Paterno *</label>
                                <input type="text" id="apellido_paterno" name="apellido_paterno" 
                                       value="<?php echo htmlspecialchars($usuario['apellido_paterno']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="apellido_materno">Apellido Materno *</label>
                                <input type="text" id="apellido_materno" name="apellido_materno" 
                                       value="<?php echo htmlspecialchars($usuario['apellido_materno']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="dni">DNI</label>
                                <input type="text" id="dni" value="<?php echo htmlspecialchars($usuario['DNI']); ?>" disabled>
                                <small>El DNI no se puede modificar</small>
                            </div>
                            <div class="form-group">
                                <label for="genero">Género</label>
                                <input type="text" id="genero" value="<?php echo htmlspecialchars($usuario['genero'] ?? 'No especificado'); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                <input type="date" id="fecha_nacimiento" 
                                       value="<?php echo htmlspecialchars($usuario['fecha_nacimiento'] ?? ''); ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Contacto -->
                    <div id="tab-contacto" class="tab-content">
                        <h3>📞 Información de Contacto</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="correo">Correo Electrónico *</label>
                                <input type="email" id="correo" name="correo" 
                                       value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="celular">Celular *</label>
                                <input type="tel" id="celular" name="celular" 
                                       value="<?php echo htmlspecialchars($usuario['celular']); ?>" required>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Ubicación -->
                    <div id="tab-ubicacion" class="tab-content">
                        <h3>📍 Información de Ubicación</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="departamento">Departamento</label>
                                <input type="text" id="departamento" name="departamento" 
                                       value="<?php echo htmlspecialchars($usuario['departamento'] ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="provincia">Provincia</label>
                                <input type="text" id="provincia" name="provincia" 
                                       value="<?php echo htmlspecialchars($usuario['provincia'] ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="distrito">Distrito</label>
                                <input type="text" id="distrito" name="distrito" 
                                       value="<?php echo htmlspecialchars($usuario['distrito'] ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="cineplanet">Cineplanet Favorito</label>
                                <input type="text" id="cineplanet" 
                                       value="<?php echo htmlspecialchars($usuario['cineplanet'] ?? 'No especificado'); ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-large">
                            💾 Guardar Cambios
                        </button>
                        <a href="peliculas.php" class="btn btn-secondary">
                            ❌ Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="actions-grid">
            <a href="mis_boletas.php" class="action-card">
                <div class="action-icon">🎫</div>
                <h3>Mis Boletas</h3>
                <p>Ver historial de compras</p>
            </a>
            <a href="peliculas.php" class="action-card">
                <div class="action-icon">🎬</div>
                <h3>Cartelera</h3>
                <p>Ver películas disponibles</p>
            </a>
            <a href="logout.php" class="action-card logout">
                <div class="action-icon">🚪</div>
                <h3>Cerrar Sesión</h3>
                <p>Salir de mi cuenta</p>
            </a>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Ocultar todos los contenidos de las pestañas
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Remover clase active de todos los botones
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => button.classList.remove('active'));
            
            // Mostrar el contenido de la pestaña seleccionada
            document.getElementById('tab-' + tabName).classList.add('active');
            
            // Agregar clase active al botón correspondiente
            event.target.classList.add('active');
        }

        // Validación del formulario
        document.querySelector('.profile-form').addEventListener('submit', function(e) {
            const email = document.getElementById('correo').value;
            const celular = document.getElementById('celular').value;
            
            if (!email || !celular) {
                e.preventDefault();
                alert('Por favor completa todos los campos obligatorios');
                return false;
            }
            
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Por favor ingresa un correo electrónico válido');
                return false;
            }
        });
    </script>
</body>
</html>