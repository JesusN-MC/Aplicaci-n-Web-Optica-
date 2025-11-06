    <?php
        $correo = $_POST['correo'];
        $pass= $_POST['pass'];

        include('../Models/usuario.php');
        $clase = new Usuario();

        $usuario = $clase->consultarCorreo($correo);
        if (is_array($usuario) && $usuario['correo'] == $correo && $usuario['contraseña'] == $pass) {
            $usuario = $clase->consultarCorreo($correo);
            session_start(); 
            
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_apellido'] = $usuario['apellidos'];
            $_SESSION['usuario_rol'] = $usuario['rol'];

            header("Location: ../../index.php");
            exit();
        }else {
            ?>
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
                    echo "<h3>Datos Erroneos</h3>";
                    echo "<div class='center'> 
                             <a class='btn-green' href='../Views/login.php'>Regresar</a>
                          </div>";
                ?>
                </main>
            </body>
            </html>
        <?php 
        }
    ?>
  