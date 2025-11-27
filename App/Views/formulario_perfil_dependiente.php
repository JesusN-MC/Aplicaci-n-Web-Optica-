<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario Perfil Dependiente</title>
  <link rel="stylesheet" href="../../CSS/login.css">
  <link rel="stylesheet" href="../../CSS/inputs.css">
</head>
<body>
  <?php include '../../Components/Header/header_servicios.php'; ?>
  <?php include '../../barraServicios2.php'; ?>

  <main>
    <div class="container">
      <div class="tabs">
        <div class="tab active">Formulario Perfil Dependiente</div>
      </div>

      <form id="register-form" action="../Drivers/insert_perfil_dependiente.php" method="POST">
        <div class="input-group">
            <input type="text" id="nombres" name="nombres" pattern="^[^0-9]+$" required>
            <label for="nombres">Nombre</label>
        </div>

        <div class="input-group">
            <input type="text" id="apellidos" name="apellidos" pattern="^[^0-9]+$" required>
            <label for="apellidos">Apellidos</label>
        </div>

        <div class="input-group">
            <input type="text" id="parentesco" name="parentesco" required>
            <label for="parentesco">Parentesco</label>
        </div>

        <button type="submit">Registrar</button>
      </form>
    </div>
  </main>
</body>
</html>