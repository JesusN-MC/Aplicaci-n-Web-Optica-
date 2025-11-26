<link rel="stylesheet" href="../../Components/Productos_Filtro/style.css">
<section class="filter-bar">
        <button onclick="location.href='../../servicios.php'" class="btn-green">Citas</button>
        <button onclick="location.href='../../App/Views/listar_perfil_dependiente.php'" class="btn-green">Perfiles</button>
        <button class="btn-green">Historial</button>
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