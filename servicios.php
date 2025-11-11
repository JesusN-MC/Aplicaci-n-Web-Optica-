<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Optica - Servicios</title>
    <link rel="stylesheet" href="./Components/Header/style.css">
    <link rel="stylesheet" href="./CSS/productos.css">
</head>
<body>
    <?php include './Components/Header/header_servicios_home.php'; ?>
    
    <main>
    <div class="product-card">
        <p style="color:var(--green);font-weight:600"><a href="./App/Views/form_reservar_cita.php">Nueva cita</a></p>
    </div>
    </main>
    

</body>
</html>