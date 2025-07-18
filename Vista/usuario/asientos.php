<?php
require_once __DIR__ . '/../../config/session.php';
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../../Controlador/usuario/AsientoControlador.php';
require_once __DIR__ . '/../../Controlador/usuario/FuncionControlador.php';

$funcion_id = $_GET['funcion_id'] ?? null;
$pelicula_id = $_GET['pelicula_id'] ?? null;

if (!$funcion_id) {
    header('Location: peliculas.php');
    exit;
}

$funcionControlador = new FuncionControlador();
$asientoControlador = new AsientoControlador();

$funcion = $funcionControlador->obtenerPorId($funcion_id);
$asientos = $asientoControlador->obtenerPorFuncion($funcion_id);

if (!$funcion) {
    header('Location: peliculas.php');
    exit;
}

// Organizar asientos por fila
$asientosPorFila = [];
foreach ($asientos as $asiento) {
    $fila = $asiento['fila'];
    if (!isset($asientosPorFila[$fila])) {
        $asientosPorFila[$fila] = [];
    }
    $asientosPorFila[$fila][] = $asiento;
}

// Ordenar filas y asientos
ksort($asientosPorFila);
foreach ($asientosPorFila as $fila => $asientosFila) {
    usort($asientosPorFila[$fila], function($a, $b) {
        return $a['numero'] - $b['numero'];
    });
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Asientos - <?php echo htmlspecialchars($funcion['pelicula_titulo']); ?></title>
    <link rel="stylesheet" href="../css/asientos.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="nav-back">
                <a href="funciones.php?pelicula_id=<?php echo $pelicula_id; ?>" class="btn btn-back">← Volver a Funciones</a>
            </div>
            <h1>🎬 Seleccionar Asientos</h1>
        </header>

        <div class="funcion-info-banner">
            <div class="info-item">
                <strong>🎭 Película:</strong> <?php echo htmlspecialchars($funcion['pelicula_titulo']); ?>
            </div>
            <div class="info-item">
                <strong>📅 Fecha:</strong> <?php echo date('d/m/Y', strtotime($funcion['fecha'])); ?>
            </div>
            <div class="info-item">
                <strong>🕐 Hora:</strong> <?php echo date('H:i', strtotime($funcion['hora'])); ?>
            </div>
            <div class="info-item">
                <strong>🎪 Sala:</strong> <?php echo htmlspecialchars($funcion['sala_nombre']); ?>
            </div>
            <div class="info-item precio-info">
                <strong>💰 Precio:</strong> S/ <?php echo number_format($funcion['precio'], 2); ?> por asiento
            </div>
        </div>

        <div class="leyenda">
            <div class="leyenda-item">
                <div class="asiento-demo disponible"></div>
                <span>Disponible</span>
            </div>
            <div class="leyenda-item">
                <div class="asiento-demo ocupado"></div>
                <span>Ocupado</span>
            </div>
            <div class="leyenda-item">
                <div class="asiento-demo seleccionado"></div>
                <span>Seleccionado</span>
            </div>
        </div>

        <div class="sala-container">
            <div class="pantalla">
                <div class="pantalla-texto">📽️ PANTALLA</div>
            </div>

            <form id="form-reserva" action="../../Controlador/usuario/ReservaControlador.php" method="POST">
                <input type="hidden" name="accion" value="reservar_multiple">
                <input type="hidden" name="funcion_id" value="<?php echo htmlspecialchars($funcion_id); ?>">
                <input type="hidden" name="precio" value="<?php echo htmlspecialchars($funcion['precio']); ?>">

                <div class="asientos-grid">
                    <?php foreach ($asientosPorFila as $fila => $asientosFila): ?>
                        <div class="fila-container">
                            <div class="fila-label">Fila <?php echo $fila; ?></div>
                            <div class="fila-asientos">
                                <?php foreach ($asientosFila as $asiento): ?>
                                    <div class="asiento-wrapper">
                                        <input type="checkbox" 
                                               name="asientos[]" 
                                               value="<?php echo $asiento['id']; ?>"
                                               id="asiento_<?php echo $asiento['id']; ?>"
                                               class="asiento-input"
                                               <?php echo $asiento['ocupado'] ? 'disabled' : ''; ?>
                                               onchange="actualizarSeleccion()">
                                        <label for="asiento_<?php echo $asiento['id']; ?>" 
                                               class="asiento <?php echo $asiento['ocupado'] ? 'ocupado' : 'disponible'; ?>">
                                            <?php echo $asiento['numero']; ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </form>
        </div>

        <div class="resumen-container">
            <div class="resumen-card">
                <h3>📋 Resumen de Selección</h3>
                <div id="asientos-seleccionados" class="asientos-lista">
                    No hay asientos seleccionados
                </div>
                <div id="total-container" class="total-info">
                    <div id="cantidad-asientos">Cantidad: 0 asientos</div>
                    <div id="total-precio">Total: S/ 0.00</div>
                </div>
                <button type="submit" form="form-reserva" id="btn-reservar" class="btn btn-reservar" disabled>
                    🎫 Generar Boleta y Reservar
                </button>
            </div>
        </div>
    </div>

    <script>
        const precioUnitario = <?php echo $funcion['precio']; ?>;
        
        function actualizarSeleccion() {
            const asientosSeleccionados = document.querySelectorAll('input[name="asientos[]"]:checked');
            const btnReservar = document.getElementById('btn-reservar');
            const divSeleccionados = document.getElementById('asientos-seleccionados');
            const divCantidad = document.getElementById('cantidad-asientos');
            const divTotal = document.getElementById('total-precio');
            
            // Actualizar apariencia visual
            document.querySelectorAll('.asiento-input').forEach(input => {
                const label = input.nextElementSibling;
                if (input.checked) {
                    label.classList.add('seleccionado');
                    label.classList.remove('disponible');
                } else if (!input.disabled) {
                    label.classList.remove('seleccionado');
                    label.classList.add('disponible');
                }
            });
            
            if (asientosSeleccionados.length > 0) {
                const lista = Array.from(asientosSeleccionados).map(input => {
                    const label = input.nextElementSibling;
                    const fila = input.closest('.fila-container').querySelector('.fila-label').textContent;
                    return `${fila} - Asiento ${label.textContent}`;
                }).join(', ');
                
                divSeleccionados.innerHTML = `<strong>Asientos:</strong> ${lista}`;
                divCantidad.innerHTML = `Cantidad: ${asientosSeleccionados.length} asiento${asientosSeleccionados.length > 1 ? 's' : ''}`;
                divTotal.innerHTML = `<strong>Total: S/ ${(asientosSeleccionados.length * precioUnitario).toFixed(2)}</strong>`;
                btnReservar.disabled = false;
            } else {
                divSeleccionados.innerHTML = 'No hay asientos seleccionados';
                divCantidad.innerHTML = 'Cantidad: 0 asientos';
                divTotal.innerHTML = 'Total: S/ 0.00';
                btnReservar.disabled = true;
            }
        }

        // Validación antes de enviar
        document.getElementById('form-reserva').addEventListener('submit', function(e) {
            const asientosSeleccionados = document.querySelectorAll('input[name="asientos[]"]:checked');
            if (asientosSeleccionados.length === 0) {
                e.preventDefault();
                alert('Por favor selecciona al menos un asiento');
            } else {
                const confirmacion = confirm(`¿Confirmas la reserva de ${asientosSeleccionados.length} asiento(s) por S/ ${(asientosSeleccionados.length * precioUnitario).toFixed(2)}?`);
                if (!confirmacion) {
                    e.preventDefault();
                }
            }
        });
    </script>
</body>
</html>