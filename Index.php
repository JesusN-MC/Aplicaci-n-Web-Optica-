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
<body style="padding-top: 3vh; padding-bottom: 3vh;">

    <?php include './Components/Header/header_productos_home.php'; ?>
    <?php include './Components/Productos_Filtro/filter.php'; ?>

    <main>
        <?php
            include_once './App/Drivers/mostrar_categoria.php';
            $cat = new Categoria();

            include './App/Drivers/mostrar_producto.php';
            $producto = new Producto();

            $categorias = $cat->activas();
            $selectedCategoria = isset($_GET['categoria']) ? (int) $_GET['categoria'] : 0;

            if ($categorias === false || $categorias === null) {
                echo "<p style='opacity:.6'>No se pudieron obtener las categorías.</p>";

            } elseif ($categorias->num_rows === 0) {
                echo "<p style='opacity:.6'>No hay categorías disponibles.</p>";

            } else {

                while ($cat = $categorias->fetch_assoc()) {
                    $idCategoria = (int)$cat['id'];

                    // Si hay filtro, solo mostrar esa categoría
                    if ($selectedCategoria !== 0 && $selectedCategoria !== $idCategoria) {
                        continue;
                    }

                    echo "<section id='cat-{$idCategoria}'>";
                    echo "<h2>" . htmlspecialchars($cat['nombre']) . "</h2>";

                    $productos = $producto->activos($idCategoria);

                    echo '<div class="categorias-container">';

                    if ($productos && $productos->num_rows > 0) {
                        while ($prod = $productos->fetch_assoc()) {

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
                            <a href="./App/Views/visualizar_producto.php?producto=' . (int)$prod['id'] . '">
                                <div class="product-card">
                                    <img src="./Assets/' . htmlspecialchars($prod['imagen_principal']) . '" alt="' . htmlspecialchars($prod['nombre']) . '">
                                    <h3>' . htmlspecialchars($prod['nombre']) . '</h3>
                                    <p>$' . htmlspecialchars($prod['precio']) . '</p>
                                    <p style="color:' . $color . ';font-weight:600">' . $stockText . '</p>
                                </div>
                            </a>';
                        }
                    } else {
                        echo "<p style='opacity:.6'>No hay productos en esta categoría</p>";
                    }

                    echo "</div>";
                    echo "</section>";
                } 
            }
        ?>
    </main>

    <!-- Smooth scroll opcional -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.hash) {
                const el = document.querySelector(window.location.hash);
                if (el) {
                    setTimeout(() => {
                        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 200);
                }
            }
        });
    </script>

</body>
</html>
