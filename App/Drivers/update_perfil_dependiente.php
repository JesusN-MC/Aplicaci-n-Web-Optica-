<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../Models/perfil_dependiente.php');

$id = $_POST['id'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$parentesco = $_POST['parentesco'];

$perfil = new PerfilDependiente();
$resultado = $perfil->actualizar($id, $nombres, $apellidos, $parentesco);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Actualizar Dependiente</title>
  <link rel="stylesheet" href="../../CSS/gestion_result.css">
  

  
</head>
<body>
  <?php include '../../Components/Header/header_productos.php'; ?>
  <main>
    <div class="container">
      <?php
        if ($resultado) {
            echo "<div class='mensaje-exito'>
                    <h3>Dependiente actualizado exitosamente</h3>
                    <a class='btn-green' href='../../App/Views/listar_perfil_dependiente.php'>Volver al inicio</a>
                  </div>";
        } else {
            echo "<div class='mensaje-error'>
                    <h3>Error al actualizar el dependiente</h3>
                    <a class='btn-green' href='../../App/Views/listar_perfil_dependiente.php'>Volver al inicio</a>
                  </div>";
        }
      ?>
    </div>
  </main>
</body>
</html>
