
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Óptica - Acceso</title>
  <link rel="stylesheet" href="../../CSS/insert_user.css">
</head>
<body>
  <?php include '../../Components/Header/header_login.php'; ?>
  <main>
    <div class="container">
    <?php
        $nombre = $_POST['nombre'];
        $apellido= $_POST['apellido'];
        $fnac =  $_POST['fnac'];
        $genero =  $_POST['genero'];
        $telefono =  $_POST['telefono'];
        $correo = $_POST['correo'];
        $pass= $_POST['pass'];

        include('../Models/usuario.php');
        $clase = new Usuario();

        // Validar si el correo ya existe
        $usuario = $clase->consultarCorreo($correo);
        if (is_array($usuario) &&$usuario['correo'] == $correo) {
            echo "<h3>Este Correo ya fue Utilizado</h3>";
            echo "<div class='center'>
                    <a class='btn-green' href='../Views/login.php'>Regresar</a>
                  </div>";

            exit;
        }
        // Guardar el usuario
        if ($clase->guardar($nombre, $apellido, $fnac, $genero, $telefono, $correo, $pass)) {
            $usuario = $clase->consultarCorreo($correo);
            session_start(); // Inicia la sesión siempre
            
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_apellido'] = $usuario['apellidos'];
            $_SESSION['usuario_rol'] = $usuario['rol'];
            
            echo "<h3>Cuenta Registrada de Manera Exitosa</h3>";
            echo "<div class='center'>
                    <a class='btn-green' href='../../index.php'>Ingresar</a>
                  </div>";
            
        } else {
            echo "<h3>Error al Registrar la Cuenta</h3>";
            echo "<div class='center'>
                    <a class='btn-green' href='../Views/login.php'>Regresar</a>
                  </div>";
        }
    ?>
  </main>
</body>
</html>