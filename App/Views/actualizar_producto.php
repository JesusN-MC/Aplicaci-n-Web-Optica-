<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar una Cita</title>
    <link rel="stylesheet" href="../../CSS/login.css">
    <link rel="stylesheet" href="../../CSS/inputs.css">
</head>
<body style="min-height: 120vh;" >

  <?php 
    include '../../Components/Header/header_productos.php'; 
    $id = $_GET['producto'];
    include '../Models/producto.php';
    $clase = new Producto();
    $res = $clase->consultar($id);
    $datos = mysqli_fetch_assoc($res);
  ?>

  <main style="align-items: center;">
    <div class="container">
      <form id="login-form" action="../Drivers/update_producto.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?php echo $id ?>">
            <input type="hidden" name="imgActual" value="<?php echo $datos['imagen_principal']; ?>">

            <div class="input-group">
                <input type="text" name="nombre" id="nombre" value="<?php echo $datos['nombre'] ?>" required>
                <label for="nombre">Nombre del Producto</label> <br>
            </div>

            <div class="input-group">
                <input type="text" name="marca" id="marca" value="<?php echo $datos['marca'] ?>" required>
                <label for="marca">Marca</label> <br>
            </div> 
            
            <div class="textarea-group">
              <textarea name="descripcion" required><?php echo $datos['descripcion'] ?></textarea>
              <label>Descripción</label>
            </div>

            <div class="select-group">
              <select name="categoria" id="categoria">

            <?php 
                include '../Models/categoria.php';
                $categoria = new Categoria();
                $resultado = $categoria->mostrar();

                foreach($resultado as $fila){
                  $selected = "";

                  if ($fila['id'] == $datos['fk_categoria']) {
                      $selected = "selected";
                  }

                  // Mostrar categorías activas O la categoría actual inactiva
                  if ($fila['estatus'] == '1' || $fila['id'] == $datos['fk_categoria']) {

                      echo '<option '.$selected.' value="'.$fila['id'].'">'.$fila['nombre'].'</option>';

                  }
                }
            ?>
              </select>
              <label>Categoría</label>
            </div>

            <div class="input-group">
                <input type="number" name="precio" id="precio" value="<?php echo $datos['precio'] ?>" required>
                <label for="precio">Precio</label> <br>
            </div>

            <div class="input-group">
                <input type="number" name="stock" id="stock" value="<?php echo $datos['stock'] ?>" required>
                <label for="stock">Stock</label> <br>
            </div>

            <!-- INPUT DE IMAGEN -->
            <div class="file-group">
                <input type="file" id="imagen" name="imagen" accept="image/*">
                <label for="imagen">Imagen del producto</label>
            </div>

            <!-- PREVIEW -->
            <div class="preview-wrapper" id="preview-wrapper" style="display:none;">
                <button type="button" id="remove-img" class="remove-img">✕</button>
                <img id="preview-img" src="">
            </div>
            
            <button style="margin-top: 20px" type="submit">Registrar Producto</button>
            <button type="button" onclick="location.href='../../App/Views/gestion_productos.php'">Regresar</button>
      </form>
    </div>
  </main>

<script>
  const input = document.getElementById("imagen");
  const preview = document.getElementById("preview-img");
  const wrapper = document.getElementById("preview-wrapper");
  const removeBtn = document.getElementById("remove-img");

  // Mostrar preview cuando se carga nueva imagen
  input.addEventListener("change", () => {
      const file = input.files[0];
      
      if (file) {
          preview.src = URL.createObjectURL(file);
          wrapper.style.display = "block";
          input.style.display = "none"; 
      }
  });

  // Botón para eliminar la imagen cargada
  removeBtn.addEventListener("click", () => {
      input.value = "";
      preview.src = "";
      wrapper.style.display = "none";
      input.style.display = "block";
  });

  // -------------------------------
  // CARGAR IMAGEN EXISTENTE DEL PRODUCTO
  // -------------------------------

  // Nombre del archivo que viene de la BD
  const fileName = "<?php echo $datos['imagen_principal']; ?>";

  // Ruta donde realmente está la imagen
  const imgPath = "../../Assets/" + fileName;

  // Si existe, cargarla
  if (fileName && fileName.trim() !== "") {
      preview.src = imgPath;
      wrapper.style.display = "block";
      input.style.display = "none";
  }
</script>

</body>
</html>
