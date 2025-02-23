<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["producto_id"];
    $nombre = $_POST["nombre"];
    $tipo = $_POST["tipo"];
    $descripcion = $_POST["descripcion"];
    $cantidad = $_POST["cantidad"];
    $precio = $_POST["precio"];
    $material = $_POST["material"];
    
    // Manejo de imagen
    if (!empty($_FILES["imagen"]["name"])) {
        $imagen = "uploads/" . basename($_FILES["imagen"]["name"]);
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $imagen);
        $sql = "UPDATE producto SET Nombre='$nombre', ID_Categoría='$tipo', Descripción='$descripcion', 
                Stock='$cantidad', Precio='$precio', Material='$material', Imagen='$imagen' WHERE ID='$id'";
    } else {
        $sql = "UPDATE producto SET Nombre='$nombre', ID_Categoría='$tipo', Descripción='$descripcion', 
                Stock='$cantidad', Precio='$precio', Material='$material' WHERE ID='$id'";
    }

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
    
    $conn->close();
}
?>
