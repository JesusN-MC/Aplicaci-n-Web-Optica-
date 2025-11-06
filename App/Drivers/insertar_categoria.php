

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Óptica - Acceso</title>
  <link rel="stylesheet" href="../../CSS/gestion_result.css">
</head>
<body>
  <?php include '../../Components/Header/header_productos_gestion.php'; ?>
  <main>
    <div class="container">
    <?php
        $nombre = $_POST['nombre'];

        include('../Models/categoria.php');
        $clase = new Categoria();

        
        if ($clase->guardar($nombre)) {
            
            echo "<h3>Categoria Registrada de Manera Exitosa</h3>";
            echo "<div class='center'>
                    <a class='btn-green' href='../../App/Views/gestion_categorias.php'>Regresar</a>
                  </div>";
            
        } else {
            echo "<h3>Error al Registrar la Categoria</h3>";
            echo "<div class='center'>
                    <a class='btn-green' href='../../App/Views/gestion_categorias.php'>Regresar</a>
                  </div>";
        }
    ?>
  </main>
</body>
</html>