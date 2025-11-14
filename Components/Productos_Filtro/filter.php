<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cargar categorías dinámicas
include './App/Drivers/mostrar_categoria.php';
$c = new Categoria();
$categorias = $c->activas();

// Categoría seleccionada (si existe)
$selected = isset($_GET['categoria']) ? (int)$_GET['categoria'] : 0;

// URL a donde se enviará el filtro
$self = htmlspecialchars($_SERVER['PHP_SELF']);
?>

<section class="filter-bar">
    <form method="GET" action="<?= $self ?>" class="filter-left">

        <select name="categoria">
            <option value="0">Todas las categorías</option>

            <?php
            if ($categorias && $categorias->num_rows > 0) {
                while ($cat = $categorias->fetch_assoc()) {
                    $id = (int)$cat['id'];
                    $nombre = htmlspecialchars($cat['nombre']);
                    $isSelected = ($selected === $id) ? 'selected' : '';

                    echo "<option value='{$id}' {$isSelected}>{$nombre}</option>";
                }
            }
            ?>
        </select>

        <button class="btn-green" type="submit">Filtrar</button>
    </form>

    <div class="filter-right">
        <?php if (isset($_SESSION['usuario_rol'])): ?>
            <?php if ($_SESSION['usuario_rol'] == 'admin'): ?>
                <button class="btn-green" onclick="location.href='./App/Views/gestion_productos.php'">Gestionar Productos</button>
                <button class="btn-green" onclick="location.href='./App/Views/gestion_categorias.php'">Gestionar Categoría</button>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<link rel="stylesheet" href="./Components/Productos_Filtro/style.css">
