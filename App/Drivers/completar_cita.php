<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Óptica - Cita Completada</title>
  <style>
    body {
      background: #f7f7f7;
      font-family: Arial, sans-serif;
    }

    main {
      display: flex;
      justify-content: center;
      padding-top: 40px;
    }

    .card {
      margin-top: 150px;
      background: white;
      width: 420px;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      text-align: center;
    }

    h3 {
      color: var(--green);
      margin-bottom: 20px;
    }

    .btn-green {
      display: inline-block;
      padding: 10px 20px;
      background: var(--green);
      border: none;
      color: white;
      border-radius: 6px;
      cursor: pointer;
      text-decoration: none;
      transition: .2s;
    }

    .btn-green:hover {
      background: #1b8a53;
    }

      .icon {
      font-size: 60px;
      margin-bottom: 15px;
    }

    .success {
      color: #27ae60;
    }

    .error {
      color: #c0392b;
    }
  </style>
</head>
<body>
  <?php include '../../Components/Header/header_productos.php'; ?>

  <main>
    <div class="card">
      <?php
        $id = $_GET['id'];
        include('../Models/cita.php');
        $clase = new Cita();

        if ($clase->completar($id)) {
            echo "<div class='icon success'>✔</div>";
            echo "<h3>Cita Completada</h3>";
            echo "<p style='margin-bottom:20px; color:#555;'>La cita ha sido marcada como completada correctamente.</p>";
            echo "<a class='btn-green' href='../../servicios.php'>Regresar</a>";
        } else {
            echo "<div class='icon error'>✖</div>";
            echo "<h3>Ocurrió un error</h3>";
            echo "<p style='margin-bottom:20px; color:#555;'>No se pudo completar la acción. Intenta nuevamente.</p>";
            echo "<a class='btn-green' href='../../servicios.php'>Regresar</a>";
        }
      ?>
    </div>
  </main>

</body>
</html>
