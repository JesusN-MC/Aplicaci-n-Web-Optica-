<section class="filter-bar">
    <div class="filter-left">
        <select>
            <option>Todas las categorías</option>
            <option>Lentes</option>
            <option>Armazones</option>
            <option>Accesorios</option>
        </select>
        <button class="btn-green">Filtrar</button>
    </div>
    <div class="filter-right">
        <?php if(isset($_SESSION['usuario_rol'])): ?>
            <?php if($_SESSION['usuario_rol'] == 'Admin'): ?>
                <button class="btn-green">Gestionar Productos</button>
                <button class="btn-green">Gestionar Categoría</button>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
<link rel="stylesheet" href="./Components/Productos_Filtro/style.css">
