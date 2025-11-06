<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Perfil</title>
    <link rel="stylesheet" href="../../CSS/index.css">
</head>
<body>
    
    <?php include '../../Components/Header/header_servicios.php'; ?>

     <div class="verPerfil">
    <h2>Nombre del Usuario</h2>

    <div class="campo">
      <label>Nombre</label>
      <span>Juan</span>
    </div>

    <div class="campo">
      <label>Apellidos</label>
      <span>Pérez López</span>
    </div>

    <div class="campo">
      <label>Correo</label>
      <span>juan123@gmail.com</span>
    </div>

    <div class="campo">
      <label>Teléfono</label>
      <span>234 242 32345</span>
    </div>

    <div class="campo">
      <label>Género</label>
      <span>Masculino</span>
    </div>
</body>
</html>


<style>

    .verPerfil {
      max-width: 500px;
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