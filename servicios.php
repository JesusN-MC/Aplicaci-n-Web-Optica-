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
    <link rel="stylesheet" href="./CSS/index.css">
    <link rel="stylesheet" href="./Components/Header/style.css">
</head>
<body>
    <?php include './Components/Header/header_servicios_home.php'; ?>

    

    <script src="./JS/user_options.js"></script>
</body>
</html>