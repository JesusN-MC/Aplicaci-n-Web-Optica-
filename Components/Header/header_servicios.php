<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<header>
        <i class="logo"><span>Óptica</span></i>
        <nav>
            <ul>
                <li>Productos</li>
                <a href="../../servicios.php"><li class="active">Servicios</li></a>
            </ul>
        </nav>
    <div class="user-greeting">
    <?php if(isset($_SESSION['usuario_nombre'])): ?>
        <span><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></span>
        <div class="user" id="userMenuToggle">
        <img src="./Components/Header/user-solid.svg" alt="usuario" class="icon-user">
            <div class="dropdown-menu" id="dropdownMenu">
                <a href="./App/Views/editar_usuario.php">Editar</a>
                <a href="./App/Controllers/logout.php">Salir</a>
            </div>
        </div>
    <?php else: ?>
        <a class="btn-green" href="../../App/Views/login.php">Acceder</a>
    <?php endif; ?>
    </div>
</header>
<script src="../../JS/user_options.js"></script>
