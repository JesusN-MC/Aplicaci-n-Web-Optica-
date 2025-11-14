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
      if($_SESSION['usuario_rol']=='admin'){
        // VISTA PARA EL ADMIN
    }else{
      $id = $_GET['id'];
      include('../Models/usuario.php');
      $clase = new Usuario();
      $respuesta = $clase->buscarPorId($id);
      $datos = mysqli_fetch_assoc($respuesta);
   
      echo '<div class="verPerfil">
    <h2>Nombre del Usuario</h2>
    <form action="../Drivers/actualizar_usuario.php" method="POST">
    
    <div class="input-group">
      <input type="hidden" name="id" id="nombre" value="'.$datos["id"].'">
    </div>
    
    <div class="input-group">
      <input type="text" name="nombre" id="nombre" value="'.$datos["nombre"].'" required>
      <label for="nombre">Nombres</label>
    </div>
    
    <div class="input-group">
      <input type="text" name="apellido" id="nombre" value="'.$datos["apellido"].'" required>
                                                      
      <label for="nombre">Apellidos</label>
    </div>

     <div class="date-placeholder">
          <input type="date" id="birthDate" name="fnac" value="'.$datos["fnac"].'" required>
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
      <input type="text" name="telefono" id="nombre" value="'.$datos["telefono"].'" required>
      <label for="nombre">Teléfono</label>
    </div>
      
    <div class="input-group">
      <input type="text" name="correo" id="nombre" value="'.$datos["correo"].'" required>
      <label for="nombre">Correo</label>
    </div>
   
    <div class="input-group">
      <input type="text" name="pass" id="nombre" value="'.$datos["pass"].'" required>
      <label for="nombre">Contraseña</label>
    </div>
   
    <button type="submit">Guardar</button>
    </form>
  </div>';
    }
    ?>

</body>
</html>
<style>
    .verPerfil {
      width: 80%;
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