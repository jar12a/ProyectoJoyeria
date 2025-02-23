<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si el id_producto está presente
    if (isset($_POST['ID_Producto'])) {
        $id_producto = $_POST['ID_Producto']; // Recibir el ID del producto que se va a actualizar
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $tipo = $_POST['tipo'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
        $material = $_POST['material'];
        $imagen_actual = $_POST['imagen_actual']; // Si hay una imagen actual

        // Manejo de la imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $imagenNombre = $_FILES['imagen']['name'];
            $imagenTmp = $_FILES['imagen']['tmp_name'];
            $carpetaDestino = 'imagenes/';

            if (!file_exists($carpetaDestino)) {
                mkdir($carpetaDestino, 0777, true);
            }

            $imagenRuta = $carpetaDestino . basename($imagenNombre);
            move_uploaded_file($imagenTmp, $imagenRuta);
        } else {
            $imagenRuta = $imagen_actual; // Mantener la imagen actual si no se ha subido una nueva
        }

        // Consulta SQL para actualizar el producto
        $sql = "UPDATE producto SET 
                ID_Categoría = '$tipo', 
                Nombre = '$nombre', 
                Descripción = '$descripcion', 
                Material = '$material', 
                Precio = '$precio', 
                Stock = '$cantidad', 
                Imagen = '$imagenRuta' 
                WHERE ID_Producto = '$id_producto'";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => $conn->error]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "ID de producto no recibido"]);
    }

    $conn->close();
}
?>
