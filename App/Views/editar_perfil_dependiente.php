<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_GET['id'])) {
    header("Location: listar_perfil_dependiente.php");
    exit();
}

include '../../App/Models/perfil_dependiente.php';
$clase = new PerfilDependiente();


$dependiente = $clase->buscarPorId($_GET['id']);

if (!$dependiente) {
    echo "Dependiente no encontrado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Dependiente</title>
  <link rel="stylesheet" href="../../CSS/login.css">
  <link rel="stylesheet" href="../../CSS/inputs.css">
</head>
<body>

  <?php include '../../Components/Header/header_login.php'; ?>

  <main>
    <div class="container">

      <div class="tabs">
        <div class="tab active">Editar Dependiente</div>
      </div>

  
      <form action="../Drivers/update_perfil_dependiente.php" method="POST">

      
        <input type="hidden" name="id" value="<?php echo $dependiente['id']; ?>">

        <div class="input-group">
            <input type="text" name="nombres" value="<?php echo $dependiente['nombres']; ?>" required>
            <label>Nombres</label>
        </div>

        <div class="input-group">
            <input type="text" name="apellidos" value="<?php echo $dependiente['apellidos']; ?>" required>
            <label>Apellidos</label>
        </div>

        <div class="input-group">
            <input type="text" name="parentesco" value="<?php echo $dependiente['parentesco']; ?>" required>
            <label>Parentesco</label>
        </div>

        <button type="submit">Guardar cambios</button>
      </form>

      <br>
      <button onclick="location.href='listar_perfil_dependiente.php'">Cancelar</button>

    </div>
  </main>

</body>
</html>
