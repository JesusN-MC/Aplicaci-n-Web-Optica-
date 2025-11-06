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
                <input type="text" name="nombre" id="nombre" required>
                <label for="nombre">Nombre Categoria</label> <br>
            </div>
            <div class="input-group">
                <input type="number" name="precio" id="precio" required>
                <label for="precio">Precio</label> <br>
            </div>
            <div class="input-group">
                <textArea type="text" name="descripcion" id="descripcion" required></textArea>
                <label for="descripcion">Descripcion</label> <br>
            </div>
            <div>
    
              <select name="stock">
            <option value="">Stock</option>
            <option value="disponible">Disponible</option>
            <option value="agotado">Agotado</option>
        </select>

        </div>
            <div class="input-group">
                <input type="text" name="categoria" id="categoria" required>
                <label for="categoria">Categoria</label> <br>
            </div>

            <button onclick="location.href='../../App/Views/gestion_categorias.php'">Regresar</button>
      </form>
    </div>
  </main>
</body>
</html>