<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda diaria</title>
    <link rel="stylesheet" href="../../CSS/login.css">
    <link rel="stylesheet" href="../../CSS/inputs.css">
</head>
<body>
    <?php include '../../Components/Header/header_productos_gestion.php'; ?>
    
    <div class="turnos">

      <div class="turno">
        <div class="titulo-turno">Turno Matutino</div>
        <div class="hora"><span>08:00</span><div class="linea"></div></div>
        <div class="hora"><span>08:30</span><div class="linea"></div></div>
        <div class="hora cita">
          <span>09:00</span>
          <div class="nombre">Nombre Apellido (Motivo)</div>
        </div>
        <div class="hora"><span>09:30</span><div class="linea"></div></div>
        <div class="hora"><span>10:00</span><div class="linea"></div></div>
        <div class="hora"><span>10:30</span><div class="linea"></div></div>
        <div class="hora"><span>11:00</span><div class="linea"></div></div>
        <div class="hora cita">
          <span>11:30</span>
          <div class="nombre">Nombre Apellido (Motivo)</div>
        </div>
        <div class="hora"><span>12:00</span><div class="linea"></div></div>
        <div class="hora"><span>12:30</span><div class="linea"></div></div>
        <div class="hora"><span>13:00</span><div class="linea"></div></div>
        <div class="hora"><span>13:30</span><div class="linea"></div></div>
        <div class="hora"><span>14:00</span><div class="linea"></div></div>
      </div>

      <div class="turno">
        <div class="titulo-turno">Turno Vespertino</div>
        <div class="hora"><span>16:00</span><div class="linea"></div></div>
        <div class="hora"><span>16:30</span><div class="linea"></div></div>
        <div class="hora"><span>17:00</span><div class="linea"></div></div>
        <div class="hora"><span>17:30</span><div class="linea"></div></div>
        <div class="hora"><span>18:00</span><div class="linea"></div></div>
        <div class="hora"><span>18:30</span><div class="linea"></div></div>
        <div class="hora"><span>19:00</span><div class="linea"></div></div>
        <div class="hora"><span>19:30</span><div class="linea"></div></div>
      </div>
</body>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #edf2f7;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .turnos {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      gap: 30px;
    }

    .turno {
      flex: 1 1 400px;
      max-width: 400px;
    }

    .titulo-turno {
      background-color: #007bdb;
      color: white;
      text-align: center;
      font-weight: bold;
      padding: 10px 0;
      border-radius: 6px;
      margin-bottom: 20px;
      font-size: 17px;
    }

    .hora {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
      font-size: 0.95rem;
    }

    .hora span {
      width: 50px;
      color: #333;
    }

    .linea {
      flex-grow: 1;
      border-bottom: 1px solid #999;
      margin-left: 10px;
      height: 1px;
    }

    .cita {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .cita .nombre {
      font-size: 0.9rem;
      color: #333;
    }

    @media (max-width: 768px) {
      .turnos {
        flex-direction: column;
        align-items: center;
      }
    }
  </style>
</html>