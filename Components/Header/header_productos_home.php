<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<header>
        <i class="logo"><span>Óptica</span></i>
        <nav>
            <ul>
                <a href="./index.php"><li class="active">Productos</li></a>
                <!-- Si no accede no puede navegar a Servicios -->
                <?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] > 0): ?>
                    <a href="./servicios.php"><li>Servicios</li></a>
                <?php endif; ?>
            </ul>
        </nav>
    <div class="user-greeting">
        <?php if(isset($_SESSION['usuario_nombre'])): ?>
            <span><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></span>
            <div class="user" id="userMenuToggle">
            <img src="./Components/Header/user-solid.svg" alt="usuario" class="icon-user">
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="./App/Views/editar_usuario.php">Editar Perfil</a>
                    <a href="./App/Drivers/logout.php">Cerrar Sesion</a>
                </div>
            </div>
        <?php else: ?>
            <a class="btn-green" href="./App/Views/login.php">Acceder</a>
        <?php endif; ?>
    </div>
</header>
<link rel="stylesheet" href="./Components/Header/style.css">
<script src="./JS/user_options.js"></script>