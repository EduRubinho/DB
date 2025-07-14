<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Película</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Nueva Película</h1>
        <!-- Formulario corregido -->
        <form action="/DB/Controlador/admin/PeliculaControlador.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="accion" value="crear">
            
            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3" required></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Género</label>
                    <input type="text" name="genero" class="form-control" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Duración (minutos)</label>
                    <input type="number" name="duracion" class="form-control" required>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Director</label>
                    <input type="text" name="director" class="form-control" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Fecha de Estreno</label>
                    <input type="date" name="fecha_estreno" class="form-control" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Imagen (Póster)</label>
                <input type="file" name="imagen" class="form-control" accept="image/*" required>
            </div>
            
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="/DB/Controlador/admin/PeliculaControlador.php?accion=listar" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>