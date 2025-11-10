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
    <title>Optica - Productos</title>
    <link rel="stylesheet" href="./CSS/productos.css">
</head>
<body>
    <?php include './Components/Header/header_productos_home.php'; ?>
    <?php include './Components/Productos_Filtro/filter.php'; ?>
    
    
    <main>
            <?php
                include './App/Drivers/mostrar_categoria.php';
                $categoria = new Categoria();

                include './App/Drivers/mostrar_producto.php';
                $producto = new Producto();

                $categorias = $categoria->activas();

                if ($categorias === false || $categorias === null) {

                    echo "<p style='opacity:.6'>No se pudieron obtener las categorías.</p>";
                } elseif ($categorias->num_rows === 0) {

                    echo "<p style='opacity:.6'>No hay categorías disponibles.</p>";
                } else {

                    while ($cat = $categorias->fetch_assoc()) {
                        echo "<h2>" . htmlspecialchars($cat['nombre']) . "</h2>";

                        $idCategoria = $cat['id'];

                        $productos = $producto->activos($idCategoria);

                        echo '<div class="categorias-container">';

                        if ($productos && $productos->num_rows > 0) {
                            while ($prod = $productos->fetch_assoc()) {
                                // Texto según stock
                                $stock = (int)$prod['stock'];

                                if ($stock > 3) {
                                    $stockText = "Disponible";
                                    $color = "var(--green)";
                                } else if ($stock > 1) {
                                    $stockText = "Bajo stock";
                                    $color = "#ffcc00";
                                } else {
                                    $stockText = "Agotado";
                                    $color = "red";
                                }

                                echo '
                                <div class="product-card">
                                    <img src="./Assets/' . htmlspecialchars($prod['imagen_principal']) . '" alt="' . htmlspecialchars($prod['nombre']) . '">
                                    <h3>' . htmlspecialchars($prod['nombre']) . '</h3>
                                    <p>$' . htmlspecialchars($prod['precio']) . '</p>
                                    <p style="color:' . $color . ';font-weight:600">' . $stockText . '</p>
                                </div>';
                            }
                        } else {
                            echo "<p style='opacity:.6'>No hay productos en esta categoría</p>";
                        }

                        echo "</div>";
                    }
                }
            ?>


        <!-- <h2>Lentes</h2>
        <div class="categorias-container ">
            <div class="product-card"><img src="https://picsum.photos/300/160?random=1" alt="Producto 1"><h3>Lente de descanso</h3><p>$1200</p><p style="color:var(--green);font-weight:600">Disponible</p></div>
            <div class="product-card"><img src="https://picsum.photos/300/160?random=2" alt="Producto 2"><h3>Lente solar</h3><p>$850</p><p style="color:#ffcc00;font-weight:600">Bajo stock</p></div>
            <div class="product-card"><img src="https://picsum.photos/300/160?random=3" alt="Producto 3"><h3>Lentes de contacto</h3><p>$650</p><p style="color:red;font-weight:600">Agotado</p></div>
            <div class="product-card"><img src="https://picsum.photos/300/160?random=4" alt="Producto 4"><h3>Armazón metálico</h3><p>$950</p><p style="color:var(--green);font-weight:600">Disponible</p></div>
            <div class="product-card"><img src="https://picsum.photos/300/160?random=5" alt="Producto 5"><h3>Gafas deportivas</h3><p>$1100</p><p style="color:var(--green);font-weight:600">Disponible</p></div>
            <div class="product-card"><img src="https://picsum.photos/300/160?random=6" alt="Producto 6"><h3>Lentes progresivos</h3><p>$1750</p><p style="color:#ffcc00;font-weight:600">Bajo stock</p></div>
            <div class="product-card"><img src="https://picsum.photos/300/160?random=7" alt="Producto 7"><h3>Lentes azules</h3><p>$980</p><p style="color:red;font-weight:600">Agotado</p></div>
            <div class="product-card"><img src="https://picsum.photos/300/160?random=8" alt="Producto 8"><h3>Estuche de lentes</h3><p>$200</p><p style="color:var(--green);font-weight:600">Disponible</p></div>
        </div>
        <h2>Limpieza</h2>
        <div class="categorias-container ">
            <div class="product-card"><img src="https://picsum.photos/300/160?random=1" alt="Producto 1"><h3>Lente de descanso</h3><p>$1200</p><p style="color:var(--green);font-weight:600">Disponible</p></div>
            <div class="product-card"><img src="https://picsum.photos/300/160?random=2" alt="Producto 2"><h3>Lente solar</h3><p>$850</p><p style="color:#ffcc00;font-weight:600">Bajo stock</p></div>
            <div class="product-card"><img src="https://picsum.photos/300/160?random=3" alt="Producto 3"><h3>Lentes de contacto</h3><p>$650</p><p style="color:red;font-weight:600">Agotado</p></div>
            <div class="product-card"><img src="https://picsum.photos/300/160?random=4" alt="Producto 4"><h3>Armazón metálico</h3><p>$950</p><p style="color:var(--green);font-weight:600">Disponible</p></div>
            <div class="product-card"><img src="https://picsum.photos/300/160?random=5" alt="Producto 5"><h3>Gafas deportivas</h3><p>$1100</p><p style="color:var(--green);font-weight:600">Disponible</p></div>
            <div class="product-card"><img src="https://picsum.photos/300/160?random=7" alt="Producto 7"><h3>Lentes azules</h3><p>$980</p><p style="color:red;font-weight:600">Agotado</p></div>
        </div> -->
    </main>

</body>
</html>