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
  <?php include '../../Components/Header/header_productos.php'; ?>
  <main style="align-items: center;" >
    <div class="container">
      <form id="login-form" action="../Drivers/insertar_producto.php"" method="POST" enctype="multipart/form-data"4>
            <div class="input-group">
                <input type="text" name="nombre" id="nombre" required>
                <label for="nombre">Nombre del Producto</label> <br>
            </div>
            <div class="input-group">
                <input type="text" name="marca" id="marca" required>
                <label for="marca">Marca</label> <br>
            </div> 
            
            <div class="textarea-group">
              <textarea name="descripcion" required></textarea>
              <label>Descripción</label>
            </div>

            <div class="select-group">
              <select name="categoria" id="categoria">
              
            <?php 
                include '../Models/categoria.php';
                $categoria = new Categoria();
                $resultado = $categoria->mostrar();

                foreach($resultado as $fila){
                    if($fila['estatus'] == '1'){    
                    echo    '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
                    }
                }
            ?>
              </select>
              <label>Categoría</label>
            </div>
            <div class="input-group">
                <input type="number" name="precio" id="precio" required>
                <label for="precio">Precio</label> <br>
            </div>

            <div class="input-group">
                <input type="number" name="stock" id="stock" required>
                <label for="stock">Stock</label> <br>
            </div>

            <div class="file-group">
                <input type="file" id="imagen" name="imagen" accept="image/*" required>
                <label for="imagen">Imagen del producto</label>
            </div>

            <div class="preview-wrapper" id="preview-wrapper">
                <button type="button" id="remove-img" class="remove-img">✕</button>
                <img id="preview-img">
            </div>
            
            <button style="margin-top: 20px" type="submit">Registrar Producto</button>
            <button onclick="location.href='../../App/Views/gestion_productos.php'">Regresar</button>
      </form>
    </div>
  </main>
<script>
  const input = document.getElementById("imagen");
  const preview = document.getElementById("preview-img");
  const wrapper = document.getElementById("preview-wrapper");
  const removeBtn = document.getElementById("remove-img");

  input.addEventListener("change", () => {
      const file = input.files[0];
      
      if (file) {
          preview.src = URL.createObjectURL(file);
          wrapper.style.display = "block";
          input.style.display = "none"; // Ocultar cuadro de carga
          input.required = false; // permitir quitar y no fallar submit
      }
  });

  removeBtn.addEventListener("click", () => {
      input.value = "";
      preview.src = "";
      wrapper.style.display = "none";
      input.style.display = "block"; // mostrar cuadro de carga
      input.required = true;
  });
</script>

</body>
</html>