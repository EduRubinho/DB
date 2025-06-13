<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario Registro Cineplanet</title>

  <link rel="stylesheet" href="css/estilos.css">

</head>
<body>

  <div class="container">
    <h1>Únete</h1>
    <p>Completa tus datos y accede a nuestro <br><strong>universo de beneficios</strong></p>
    <form id="registroForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
      <div class="row">
        <div class="field">
          <label>Nombre</label>
          <input type="text" name="nombre" required>
        </div>
        <div class="field">
          <label>Apellido Paterno</label>
          <input type="text" name="apellido_paterno" required>
        </div>
      </div>

      <div class="row">
        <div class="field">
          <label>Apellido Materno</label>
          <input type="text" name="apellido_materno">
        </div>
        <div class="field">
          <label>Correo electrónico</label>
          <input type="email" name="correo" required>
        </div>
      </div>

      <div class="row">
        <div class="field">
          <label>Contraseña</label>
          <input type="password" name="password" required>
        </div>
        <div class="field">
          <label>Confirmar contraseña</label>
          <input type="password" name="confirm_password" required>
        </div>
      </div>

      <div class="row">
        <div class="field">
          <label>Tipo de documento</label>
          <select name="tipo_documento" required>
            <option value="">Selecciona</option>
            <option value="dni">DNI</option>
            <option value="ce">C.E.</option>
          </select>
        </div>
        <div class="field triple">
          <input type="text" name="numero_documento" placeholder="N° de documento" required>
          <span class="guion">-</span>

          <input type="text" name="dv" placeholder="DV" maxlength="1">
        </div>
      </div>

      <div class="row">
        <div class="field">
          <label>Fecha de Nacimiento</label>
          <input type="date" name="fecha_nacimiento" required>
        </div>
        <div class="field">
          <label>Número de Celular</label>
          <input type="tel" name="celular" required>
        </div>
      </div>

      <div class="row">
        <div class="field">
          <label>Departamento</label>
          <select name="departamento" required>
            <option value="">Selecciona</option>
          </select>
        </div>
        <div class="field">
          <label>Provincia</label>
          <select name="provincia" required>
            <option value="">Selecciona</option>
          </select>
        </div>
      </div>

      <div class="row">
        <div class="field">
          <label>Distrito</label>
          <select name="distrito" required>
            <option value="">Selecciona</option>
          </select>
        </div>
        <div class="field">
          <label>Tu Cineplanet favorito <span class="opcional">(Campo Opcional)</span></label>
          <select name="cineplanet_favorito">
            <option value="">Selecciona</option>
          </select>
        </div>
      </div>

      <div class="row genero">
        <label>Género</label>
        <label><input type="radio" name="genero" value="hombre" required> Hombre</label>
        <label><input type="radio" name="genero" value="mujer" required> Mujer</label>
      </div>

      <div class="row checkboxes">
        <label><input type="checkbox" required> Acepto los <a href="#">Términos y Condiciones</a> y la <a href="#">Política de Privacidad</a></label>
        <label><input type="checkbox" required> He leído y acepto las finalidades de tratamiento adicionales</label>
      </div>

      <div class="submit">
        <button type="submit">Unirme</button>
      </div>
      <?php if(!empty($errores)): ?>
        <div class="error">
          <?php echo $errores; ?>
        </div>
      <?php endif; ?>

    </form>
  </div>

</body>
</html>

