<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Asignar Producto</title>

    <link rel="stylesheet" href="../../CSS/login.css" />
    <link rel="stylesheet" href="../../CSS/inputs.css" />

    <style>
        /* MODAL */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            width: 350px;
            border-radius: 10px;
            text-align: center;
        }

        .modal-actions {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .modal-actions button {
            padding: 10px 18px;
            cursor: pointer;
            border-radius: 6px;
        }

        #cancelBtn {
            background: #c34c4cff;
            margin-right: 10px;
        }

        #confirmBtn {
            background: #28a745;
            color: white;
            margin-left: 10px;
        }

        .assign-btn {
            cursor: pointer;
        }
    </style>
</head>

<body>

<?php 
    include '../../Components/Header/header_productos.php'; 
    
    $idProducto = $_GET['producto'];

    include '../Models/producto.php';
    $clase = new Producto();
    $res = $clase->consultar($idProducto);
    $datos = mysqli_fetch_assoc($res); 

    $imagen = "../../Assets/" . $datos['imagen_principal'];
?>

    <div class="main-wrapper">
        <div class="card">

            <!-- PRODUCTO -->
            <section class="product-row">
                <div class="img-box">
                    <img src="<?php echo $imagen ?>" alt="Imagen del producto">
                </div>

                <div class="product-info">

                    <div class="info-item">
                        <label>Nombre</label>
                        <div><?php echo $datos['nombre'] ?></div>
                    </div>

                    <div class="info-item">
                        <label>Stock</label>
                        <div><?php echo $datos['stock'] ?></div>
                    </div>

                    <div class="info-item">
                        <label>Marca</label>
                        <div><?php echo $datos['marca'] ?></div>
                    </div>

                    <div class="info-item">
                        <label>Categoría</label>
                        <div>
                        <?php
                            include '../Models/categoria.php';
                            $cat = new Categoria();
                            $r = $cat->consultar($datos['fk_categoria']);
                            $filaCat = mysqli_fetch_assoc($r);
                            echo $filaCat['nombre'];
                        ?>
                        </div>
                    </div>

                </div>
            </section>

            <section class="assign-area">
                <h3>Asignar a Usuario</h3>

                <div class="search-box">
                    <input id="userSearch" type="text" placeholder="Buscar usuario..." />
                </div>

                <div class="user-list" id="userList">

                    <?php 
                        include '../Models/usuario.php';
                        $claseU = new Usuario();
                        $resU = $claseU->mostrar();

                        foreach($resU as $fila){
                            echo '
                            <div class="user-item">
                                <span>'.$fila['nombre'].' '.$fila['apellidos'].'</span>
                                <button class="assign-btn" data-userid="'.$fila['id'].'">Asignar</button>
                            </div>';
                        }
                    ?>

                </div>
            </section>

        </div>
    </div>

    <div class="modal" id="confirmModal">
        <div class="modal-content">
            <h3>¿Asignar este producto?</h3>
            <p id="userName"></p>

            <div class="modal-actions">
                <button id="cancelBtn">Cancelar</button>
                <button id="confirmBtn">Confirmar</button>
            </div>
        </div>
    </div>

<script>
    // SCRIPT DE BUSQUEDA
    function quitarAcentos(str) {
        return str
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .toLowerCase();
    }

    document.getElementById('userSearch').addEventListener('input', function(e){
        const q = quitarAcentos(e.target.value);

        document.querySelectorAll('#userList .user-item').forEach(item => {
            const name = quitarAcentos(item.querySelector('span').innerText);
            item.style.display = name.includes(q) ? 'flex' : 'none';
        });
    });

    // ABRIR MODAL
    let selectedUser = "";
    let selectedUserId = "";

    document.querySelectorAll(".assign-btn").forEach(btn => {
        btn.addEventListener("click", function(e){
            e.stopPropagation();

            selectedUser = this.parentElement.querySelector("span").innerText;
            selectedUserId = this.dataset.userid;

            document.getElementById("userName").innerText = selectedUser;

            document.getElementById("confirmModal").style.display = "flex";
        });
    });

    document.getElementById("cancelBtn").onclick = function () {
        document.getElementById("confirmModal").style.display = "none";
    };

    document.getElementById("confirmBtn").onclick = function () {
        window.location = "resultado_asignacion.php?usuario=" + selectedUserId + "&producto=<?php echo $idProducto?>" + "&total=<?php echo $datos['precio']?>"+ "&stock=<?php echo $datos['stock']?>";
    };
</script>

</body>
</html>

<style>
        body {
            background: #f5f7fa;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .main-wrapper {
            width: 95%;
            max-width: 700px;
            margin-top: 70px;
            display: flex;
            justify-content: center;
        }

        .view-container {
            background: #fff;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
            animation: fadeIn 0.4s ease;
            height: fit-content;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 26px;
            color: #333;
        }

        .content {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .img-box img {
            width: 100%;
            max-width: 300px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.18);
        }
        .info-item, .product-info{
            max-width: 300px;
            width: 100%;
        }

        .info-item label {
            font-size: 14px;
            font-weight: bold;
            color: #555;
        }

        .info-item div {
            margin-top: 4px;
            padding: 10px 14px;
            background: #f0f2f5;
            border-radius: 10px;
            font-size: 16px;
            color: #333;
            border-left: 4px solid #096545ff;
        }

        textarea {
            width: 100%;
            height: 120px;
            resize: none;
            padding: 10px;
            border-radius: 10px;
            background: #f0f2f5;
            border: none;
            border-left: 4px solid #096545ff;
            color: #333;
            font-size: 16px;
        }

        .assign-panel {
            background: #fff;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
            animation: fadeIn 0.4s ease;
            height: fit-content;
        }

        .search-box input {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 2px solid #cfd3d8;
            font-size: 16px;
        }

        .user-list {
            margin-top: 20px;
            max-height: 420px;
            overflow-y: auto;
        }

        .user-item {
            background: #f3f4f6;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-item button {
            background: #096545;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s;
            max-width: 200px;
        }

        .user-item button:hover {
            background: #064c33;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 900px) {
            .main-wrapper {
                grid-template-columns: 1fr;
                margin-top: 120px;
            }

            .view-container, .assign-panel {
                width: 100%;
            }

            .img-box img {
                max-width: 250px;
            }
        }
        .card {
            background: #fff;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
            width: 100%;
            animation: fadeIn 0.4s ease;
        }

        .product-row {
            display: flex;
            gap: 20px;
            align-items: flex-start;
            margin-bottom: 25px;
        }

        
  </style>