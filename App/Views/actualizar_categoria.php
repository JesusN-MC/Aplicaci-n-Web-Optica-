<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Óptica - Acceso</title>
  <link rel="stylesheet" href="../../CSS/login.css">
  <link rel="stylesheet" href="../../CSS/inputs.css">
</head>
<body>
  <?php include '../../Components/Header/header_productos.php'; ?>
  <?php 
    $id = $_GET['categoria'];
    include '../Models/categoria.php';
    $categoria = new Categoria();
    $resultado = $categoria->consultar($id);
    $datos=mysqli_fetch_assoc($resultado);

  ?>
  <main>
    <div class="container">
      
      <form id="login-form" action="../Drivers/update_categoria.php" method="POST">
            <div class="input-group">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="text" name="nombre" value="<? echo $datos['nombre']?>" id="nombre" required>
                <label for="nombre">Nombre Categoria</label>
            </div>

            <button type="submit">Actualizar Categoria</button>
            <button type="button" onclick="location.href='../../App/Views/gestion_categorias.php'">Regresar</button>
      </form>
    </div>
  </main>
</body>
</html>
