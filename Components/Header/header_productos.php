<!-- <?php
// session_start(); // Inicia la sesión siempre
// $_SESSION['usuario_nombre'] = 'Job Noe';
?> -->


<header>
        <i class="logo"><span>Óptica</span></i>
        <nav>
            <ul>
                <li class="active">Productos</li>
                <!-- Si no accede no puede navegar a Servicios -->
                <?php if(isset($_SESSION)): ?> 
                    <li>Servicios</li>
                <?php endif; ?>
            </ul>
        </nav>
    <div class="user-greeting">
        <?php if(isset($_SESSION['usuario_nombre'])): ?>
            <span><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></span>
            <div class="user">
                <img src="./Components/Header/user-solid.svg" alt="usuario" class="icon-user">
            </div>
        <?php else: ?>
            <a class="btn-green" href="#">Acceder</a>
        <?php endif; ?>
    </div>
</header>
<link rel="stylesheet" href="./Components/Header/style.css">