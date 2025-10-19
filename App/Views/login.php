<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Óptica - Acceso</title>
  <link rel="stylesheet" href="../../CSS/login.css">
  <link rel="stylesheet" href="../../CSS/inputs.css">
</head>
<body>
  <?php include '../../Components/Header/header_login.php'; ?>
  <main>
    <div class="container">
      <!-- navegación -->
      <div class="tabs">
        <div class="tab active" id="tab-login">Iniciar sesión</div>
        <div class="tab" id="tab-register">Registrarse</div>
      </div>

      <!-- login -->
      <form id="login-form">
        <div class="input-group">
          <input type="email" name="correo" id="correo" required>
          <label for="telefono">Correo Electronico</label>
        </div>

        <div class="password-container input-group">
          <input type="password" maxlength="20" minlength="8" required>
          <label for="telefono">Contraseña</label>
        </div>
        <button type="submit">Ingresar</button>
      </form>

      <!-- Registro -->
      <form id="register-form" style="display:none;">

        <div class="input-group">
            <input type="text" id="nombre" name="nombre" pattern="^[^0-9]+$" required>
            <label for="nombre">Nombre</label>
        </div>

        <div class="input-group">
            <input type="text" id="apellidos" name="apellidos" pattern="^[^0-9]+$" required>
            <label for="apellidos">Apellidos</label>
        </div>

        <!-- 👇 Aquí el input date con placeholder simulado -->
        <div class="date-placeholder">
          <input type="date" id="birthDate" required>
          <label for="birthDate">Fecha de nacimiento</label>
        </div>

        <div class="input-group">
            <input type="number" id="edad" name="edad" required>
            <label for="edad">Edad</label>
        </div>

        <select>
            <option value="">Seleccione género (opcional)</option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
            <option value="Otro">Otro</option>
        </select>

        <div class="input-group">
            <input type="tel" id="telefono" name="telefono" required>
            <label for="telefono">Teléfono (opcional)</label>
        </div>

        <div class="input-group">
          <input type="email" name="correo" id="correo" required>
          <label for="telefono">Correo Electronico</label>
        </div>

        <div class="password-container input-group">
          <input type="password" maxlength="20" minlength="8" required>
          <label for="telefono">Contraseña</label>
        </div>

        <button type="submit">Registrar</button>
      </form>
    </div>
  </main>
  <script src="../../JS/login.js"></script>
</body>
</html>
