<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Historial clínico y de compras</title>

  <link rel="stylesheet" href="../../CSS/index.css">
  <link rel="stylesheet" href="../../CSS/gestion_result.css">
  <link rel="stylesheet" href="../../Components/Header/style.css">
  <link rel="stylesheet" href="../../CSS/historial_clinico_compras.css">
</head>
<body>

  <?php include '../../Components/Header/header_servicios.php'; ?>

  <main>
    <h1>Historial clínico y de compras</h1>

    <section>
      <h2>Historial de citas</h2>
      <table>
        <tr>
          <th>Fecha</th>
          <th>Notas</th>
          <th>Estado</th>
          <th>Enlace</th>
        </tr>
      </table>
    </section>

    <section>
      <h2>Historial de compras</h2>
      <table>
        <tr>
          <th>Producto</th>
          <th>Fecha</th>
          <th>Cantidad</th>
          <th>Enlace</th>
        </tr>
      </table>
    </section>
  </main>

</body>
</html>
