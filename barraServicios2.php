<?php
    if (session_status() === PHP_SESSION_NONE) { 
        session_start();
    }
?>
<link rel="stylesheet" href="../../Components/Productos_Filtro/style.css">
<section class="filter-bar">
    <button onclick="location.href='../../servicios.php'" class="btn-green">Citas</button>

    <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] == 'admin'): ?>
        <!-- Para ADMIN -->
        <button onclick="location.href='../../App/Views/listar_usuario.php'" class="btn-green">Perfiles</button>
    <?php else: ?>
        <!-- Para cualquier otro rol -->
        <button onclick="location.href='../../App/Views/listar_perfil_dependiente.php'" class="btn-green">Perfiles</button>
        <button onclick="location.href='../../App/Views/historial_productos.php'" class="btn-green">Historial</button>
    <?php endif; ?>
    
</section>
<style>
    .filter-bar{
        justify-content: center;
        gap: 10px;
        display: flex;
    }

    .filter-bar .btn-green{
        width: 100px;
        border: 3px solid var(--green);
        background: white;
        color: var(--green);
    }

    .filter-bar .btn-green:hover{
        width: 100px;
        border: 3px solid var(--green);
        background: var(--green);
        color: white;
    }
        @media (max-width: 700px) {
        .filter-bar {
            flex-direction: row;
            align-items: center;
        }
        .filter-left, .filter-right {
            width: 100%;
            justify-content: center;
        }
    }
</style>