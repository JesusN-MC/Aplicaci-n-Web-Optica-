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
      
      <div class="tabs">
        <div class="tab active" id="tab-login">Formulario Perfil Dependiente</div>
      </div>


      <form id="register-form" action="../Drivers/insert_user.php" method="POST">

        <div class="input-group">
            <input type="text" id="nombre" name="nombre" pattern="^[^0-9]+$" required>
            <label for="nombre">Nombre</label>
        </div>

        <div class="input-group">
            <input type="text" id="apellidos" name="apellidos" pattern="^[^0-9]+$" required>
            <label for="apellidos">Apellidos</label>
        </div>

        <div class="date-placeholder">
          <input type="date" id="birthDate" name="fnac"required>
          <label for="birthDate">Fecha de nacimiento</label>
        </div>

        <select name="genero">
            <option value="">Seleccione género (opcional)</option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
            <option value="Otro">Otro</option>
        </select>

        <button type="submit">Registrar</button>
      </form>
    </div>
  </main>
</body>
</html>
