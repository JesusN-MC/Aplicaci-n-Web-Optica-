<!-- <?php
// session_start(); // Inicia la sesión siempre
// $_SESSION['usuario_nombre'] = 'Job Noe';
?> -->


<header>
        <i class="logo"><span>Óptica</span></i>
        <nav>
            <ul>
                <li>Productos</li>
                <li class="active">Servicios</li>
            </ul>
        </nav>
    <div class="user-greeting">
        <?php if(isset($_SESSION['usuario_nombre'])): ?>
            <span><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></span>
            <div class="user">
                <img src="./Components/Header/user-solid.svg" alt="usuario" class="icon-user">
            </div>
        <?php else: ?>
            <a class="btn-green" href="#">Iniciar sesión</a>
        <?php endif; ?>
    </div>
</header>
<link rel="stylesheet" href="./Components/Header/style.css">