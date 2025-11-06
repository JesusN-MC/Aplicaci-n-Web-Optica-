<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar una Cita</title>
    <link rel="stylesheet" href="../../CSS/login.css">
    <link rel="stylesheet" href="../../CSS/inputs.css">
</head>
<body>
     <?php include '../../Components/Header/header_productos_gestion.php'; ?>
  <main>
    <div class="container">
      <form id="login-form" action="../Drivers/reservar_citas.php" method="POST">
            <div class="input-group">
                <input type="text" name="motivo" id="nombre" required>
                <label for="nombre">Motivo</label> <br>
            </div>
            <div class="input-group">
                <input type="text" name="fecha" id="nombre" required>
                <label for="nombre">Fecha</label> <br>
            </div>
            <div class="input-group">
                <select name="tipo">
                    <option value="0">Admin</option>
                    <option value="1">Encargado(a)</option>
                    <option value="2">Secretario(a)</option>
                </select>
                
            </div>
            <div class="input-group">
                <input type="text" name="idpaciente" id="nombre" required>
                <label for="nombre">Tipo de Perfil</label> <br>
            </div>

            <button type="submit">Reservar Cita</button>
            <button onclick="location.href='../../App/Views/gestion_categorias.php'">Regresar</button>
      </form>
    </div>
  </main>
</body>
</html>