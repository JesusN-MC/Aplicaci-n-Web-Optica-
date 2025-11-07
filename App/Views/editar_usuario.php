<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Perfil</title>
    <link rel="stylesheet" href="../../CSS/login.css">
    <link rel="stylesheet" href="../../CSS/inputs.css">
</head>
<body>
    
    <?php include '../../Components/Header/header_servicios.php'; ?>
    <?php if($_SESSION['usuario_rol']=='admin'){
      






     }?>

  <div class="verPerfil">
    <h2>Nombre del Usuario</h2>

    <div class="input-group">
      <input type="text" name="nombre" id="nombre" required>
      <label for="nombre">Nombres</label>
    </div>
   
    <div class="input-group">
      <input type="text" name="nombre" id="nombre" required>
      <label for="nombre">Correo</label>
    </div>
   
    <div class="input-group">
      <input type="text" name="nombre" id="nombre" required>
      <label for="nombre">Teléfono</label>
    </div>
   
    <div class="input-group">
      <input type="text" name="nombre" id="nombre" required>
      <label for="nombre">Género</label>
    </div>
    
  </div>

</body>
</html>


<style>

    .verPerfil {
      width: 50%;
      height: 50%;
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