<?php 
    $id = $_GET['producto'];

    include('../../App/Models/Producto.php');
    $clase = new Producto();
    
    $clase->deshabilitar($id);
    header("Location: ../../App/Views/gestion_Productos.php");

?>