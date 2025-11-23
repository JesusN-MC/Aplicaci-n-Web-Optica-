<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar una Cita</title>
    <link rel="stylesheet" href="../../CSS/login.css">
    <link rel="stylesheet" href="../../CSS/inputs.css">
    <link rel="stylesheet" href="../Components/Header/style.css">
    <link rel="stylesheet" href="../../Components/Productos_Filtro/style.css">

</head>
<body>
     <?php include '../../Components/Header/header_servicios.php'; ?>
     <?php include '../../barraServicios.php'?>
     
  <main>
    <div class="container">
      <form id="login-form" action="../Drivers/reservar_citas.php" method="POST">
            
            <div class="input-group">
                <input type="text" name="motivo" id="nombre" required>
                <label for="motivo">Motivo</label> <br>
            </div>
            
            <div class="input-group">
                <input type="text" name="fecha" id="nombre" required>
                <label for="fecha">Fecha</label> <br>
            </div>
            
            <div class="input-group">
                <!-- <label for="">Hora</label> -->
                <select name="hora">
                    <option value="">Seleccione una hora</option>
                    <?php
                        foreach($resultado as $fila){
                    ?>
                        <option value="<?=$fila['id']?>"><?=$fila['nombre']?></option>
                        
                    <?php
                        }
                    ?>
                </select>
            </div>
            
            <div class="input-group">
                <Select name="idpaciente">
                    <option value="">Persona</option>
                </Select>
            </div>

            <button type="submit">Reservar Cita</button>
            <button onclick="location.href='../../servicios.php'">Regresar</button>
      </form>
    </div>
  </main>
</body>
</html>