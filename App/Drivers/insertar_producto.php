

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Óptica - Acceso</title>
  <link rel="stylesheet" href="../../CSS/gestion_result.css">
</head>
<body>
  <?php include '../../Components/Header/header_productos.php'; ?>
  <main>
    <div class="container">
    <?php
        $nombre = $_POST['nombre'];
        $marca = $_POST['marca'];
        $descripcion =  $_POST['descripcion'];
        $categoria =  $_POST['categoria'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $foto =  $_FILES['imagen']['name'];

        $ruta = $_FILES['imagen']['tmp_name'];
        move_uploaded_file($ruta, "../../Assets/".$foto);

        include('../Models/producto.php');
        $clase = new Producto();

        
        if ($clase->guardar($nombre, $marca, $descripcion, $categoria, $precio, $stock, $foto)) {
            
            echo "<h3>Producto Registrado de Manera Exitosa</h3>";
            echo "<div class='center'>
                    <a class='btn-green' href='../../App/Views/gestion_productos.php'>Regresar</a>
                  </div>";
            
        } else {
            echo "<h3>Error al Registrar el Producto</h3>";
            echo "<div class='center'>
                    <a class='btn-green' href='../../App/Views/gestion_productos.php'>Regresar</a>
                  </div>";
        }
    ?>
  </main>
</body>
</html>