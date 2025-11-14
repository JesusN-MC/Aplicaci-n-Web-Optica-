

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
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $marca = $_POST['marca'];
        $descripcion =  $_POST['descripcion'];
        $categoria =  $_POST['categoria'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];

        // imagen actual que ya estaba guardada
        $imagen_actual = $_POST['imgActual'];  // <-- debes obtenerla antes

        // nombre del archivo nuevo
        $foto = $_FILES['imagen']['name'];

        if ($foto != "") {
            // SI SUBIERON UNA NUEVA IMAGEN
            $ruta = $_FILES['imagen']['tmp_name'];
            move_uploaded_file($ruta, "../../Assets/".$foto);
            $imagen_final = $foto; // usar la nueva
        } else {
            // NO SUBIERON NADA: mantener la imagen ya existente
            $imagen_final = $imagen_actual;
        }

        include('../Models/producto.php');
        $clase = new Producto();

        
        if ($clase->actualizar($id, $nombre, $marca, $descripcion, $categoria, $precio, $stock, $imagen_final)) {
            
            echo "<h3>Producto Actualizado de Manera Exitosa</h3>";
            echo "<div class='center'>
                    <a class='btn-green' href='../../App/Views/gestion_productos.php'>Regresar</a>
                  </div>";
            
        } else {
            echo "<h3>Error al Actualizar el Producto</h3>";
            echo "<div class='center'>
                    <a class='btn-green' href='../../App/Views/gestion_productos.php'>Regresar</a>
                  </div>";
        }
    ?>
  </main>
</body>
</html>