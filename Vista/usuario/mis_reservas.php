<?php
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../Modelo/usuario/ReservaModelo.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login_usuario.php");
    exit;
}

$reservaModelo = new ReservaModelo();
$reservas = $reservaModelo->obtenerReservasPorUsuario($_SESSION['usuario']['id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .reserva-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }
        .pelicula-titulo {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .detalle {
            margin: 5px 0;
            color: #666;
        }
        .asiento {
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
            font-weight: bold;
        }
        .fecha-reserva {
            font-size: 12px;
            color: #999;
            font-style: italic;
        }
        .volver-btn {
            background-color: #2196F3;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
        .no-reservas {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Mis Reservas</h1>
        
        <?php if (empty($reservas)): ?>
            <div class="no-reservas">
                <p>No tienes reservas realizadas.</p>
                <a href="peliculas.php" class="volver-btn">Ver Cartelera</a>
            </div>
        <?php else: ?>
            <?php foreach ($reservas as $reserva): ?>
                <div class="reserva-card">
                    <div class="pelicula-titulo">
                        🎬 <?php echo htmlspecialchars($reserva['pelicula_titulo']); ?>
                    </div>
                    
                    <div class="detalle">
                        <strong>📅 Función:</strong> 
                        <?php echo date('d/m/Y', strtotime($reserva['fecha'])); ?> 
                        a las <?php echo date('H:i', strtotime($reserva['hora'])); ?>
                    </div>
                    
                    <div class="detalle">
                        <strong>🎭 Sala:</strong> <?php echo htmlspecialchars($reserva['sala_nombre']); ?>
                    </div>
                    
                    <div class="detalle">
                        <strong>💺 Asiento:</strong> 
                        <span class="asiento">
                            Fila <?php echo htmlspecialchars($reserva['fila']); ?> - 
                            Asiento <?php echo htmlspecialchars($reserva['numero']); ?>
                        </span>
                    </div>
                    
                    <div class="detalle">
                        <strong>🎭 Género:</strong> <?php echo htmlspecialchars($reserva['genero']); ?>
                    </div>
                    
                    <div class="detalle">
                        <strong>⏱️ Duración:</strong> <?php echo htmlspecialchars($reserva['duracion']); ?> minutos
                    </div>
                    
                    <?php if (isset($reserva['fecha_reserva'])): ?>
                        <div class="fecha-reserva">
                            Reservado el: <?php echo date('d/m/Y H:i', strtotime($reserva['fecha_reserva'])); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <a href="peliculas.php" class="volver-btn">← Volver a Cartelera</a>
    </div>
</body>
</html>