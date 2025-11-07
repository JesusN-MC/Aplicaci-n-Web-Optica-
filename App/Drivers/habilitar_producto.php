<?php 
    $id = $_GET['producto'];

    include('../../App/Models/producto.php');
    $clase = new Producto();
    
    $clase->habilitar($id);
    header("Location: ../../App/Views/gestion_Productos.php");

?>