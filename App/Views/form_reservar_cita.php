<?php
session_start();
$idUsuario = $_SESSION['usuario_id'];

require_once('../Drivers/conexion.php');
$conexion = new Conexion();

/* 1. Titular */
$consultaU = "SELECT id, nombre, apellidos FROM usuario WHERE id = $idUsuario";
$respuestaU = $conexion->query($consultaU);
$usuario = $respuestaU->fetch_assoc();

/* 2. Dependientes */
$constulaP = "SELECT id, nombres, apellidos FROM perfil WHERE fk_usuario = $idUsuario";
$respuestaP = $conexion->query($constulaP);
?>

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
                <select name="tipo">
                    <option value="">Seleccione tipo de cita</option>
                        <option value="r">Revisión</option> 
                        <option value="c">Consulta</option> 
                </select>
            </div>
            
            <div class="input-group">
                <input type="date" name="fecha" id="nombre" required>
                <label for="fecha">Fecha</label> <br>
            </div>
            
            <div class="input-group">
                <select name="hora">
                    <option value="">Seleccione una hora</option>
                         <option value="08">08:00</option> 
                </select>
            </div>
            
            <div class="input-group">
                <Select name="idpaciente" required>
                    <option value="">Seleccione al paciente</option>
                <option value="<?= $usuario['id'] ?>">
                    <?= $usuario['nombre'] . " " . $usuario['apellidos'] ?>
                </option>

                <?php while($fila = $respuestaP->fetch_assoc()) { ?>
                    <option value="<?= $fila['id'] ?>">
                        <?= $fila['nombres'] . " " . $fila['apellidos'] ?>
                    </option>
                <?php } ?>
                </Select>
            </div>

            <button type="submit">Reservar Cita</button>
            <button onclick="location.href='../../servicios.php'">Regresar</button>
      </form>
    </div>
  </main>
</body>
</html>