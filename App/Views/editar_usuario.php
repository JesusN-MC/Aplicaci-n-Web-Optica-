<?php 
    if (session_status() === PHP_SESSION_NONE) {
            
        session_start();
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Perfil</title>
    <link rel="stylesheet" href="../../CSS/login.css">
    <link rel="stylesheet" href="../../CSS/inputs.css">
    <link rel="stylesheet" href="../../CSS/index.css">
    <link rel="stylesheet" href="../../CSS/gestion_result.css">
    <link rel="stylesheet" href="../../Components/Header/style.css">
    <link rel="stylesheet" href="historial_clinico_compras.css">
</head>
<body>
    <?php include '../../Components/Header/header_servicios.php'; ?>
    <?php 

      echo '<div class="verPerfil">
    <h2>Editar Usuario</h2>
    <form action="../Drivers/actualizar_usuario.php" method="POST">
    
    <div class="input-group">
      <input type="hidden" name="id" id="id" value="'.$_SESSION["usuario_id"].'">
    </div>
    
    <div class="input-group">
      <input type="text" name="nombre" id="nombre" value="'.$_SESSION["usuario_nombre"].'" required>
      <label for="nombre">Nombres</label>
    </div>
    
    <div class="input-group">
      <input type="text" name="apellido" id="apellido" value="'.$_SESSION["usuario_apellido"].'" required>
                                                      
      <label for="nombre">Apellidos</label>
    </div>

     <div class="date-placeholder">
          <input type="date" id="birthDate" name="fnac" value="'.$_SESSION["usuario_fnac"].'" required>
          <label for="birthDate">Fecha de nacimiento</label>
        </div>
      
    <div class="select-group">
          <select name="genero">
              <option value="Masculino">Masculino</option>
              <option value="Femenino">Femenino</option>
              <option value="Otro">Otro</option>
          </select>
          <label>Seleccione género (opcional)</label>
        </div>

    <div class="input-group">
      <input type="text" name="telefono" id="telefono" value="'.$_SESSION["usuario_telefono"].'">
      <label for="nombre">Teléfono</label>
    </div>
      
    <div class="input-group">
      <input type="text" name="correo" id="correo" value="'.$_SESSION["usuario_correo"].'" required>
      <label for="nombre">Correo</label>
    </div>
   
    <div class="input-group">
      <input type="text" name="pass" id="pass" value="'.$_SESSION["usuario_pass"].'" required>
      <label for="nombre">Contraseña</label>
    </div>
   
    <button class="medium" type="submit">Guardar</button>
    </form>
  </div>';
    
    ?>

</body>
</html>
<style>
    .medium{
      max-witdh: 100px;
    }

    .verPerfil {
      width: 80%;
      max-width: 700px;
      height: 80%;
      margin: 150px auto;
      background: white;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      padding: 30px;
      text-align: left;
    }

    .verPerfil h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .campo {
      margin-bottom: 15px;
    }

    .campo label {
      display: block;
      font-weight: bold;
      color: #555;
      margin-bottom: 5px;
    }

    .campo span {
      display: block;
      background: #f0f2f5;
      padding: 10px;
      border-radius: 8px;
      color: #333;
    }
</style>