<?php
include '../confi/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $tipo = $_POST["tipo"];
    $cantidad = $_POST["cantidad"];
    $precio = $_POST["precio"];
    $material = $_POST["material"];

    // Manejo de la imagen
    $imagenNombre = $_FILES["imagen"]["name"];
    $imagenTmp = $_FILES["imagen"]["tmp_name"];
    $carpetaDestino = "imagenes/";

    if (!file_exists($carpetaDestino)) {
        mkdir($carpetaDestino, 0777, true);
    }

    $imagenRuta = $carpetaDestino . basename($imagenNombre);
    move_uploaded_file($imagenTmp, $imagenRuta);

    // Inserción en la base de datos
    $sql = "INSERT INTO producto (ID_Categoría, Nombre, Descripción, Material, Precio, Stock, Imagen)
            VALUES (:tipo, :nombre, :descripcion, :material, :precio, :cantidad, :imagenRuta)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':material', $material);
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':cantidad', $cantidad);
    $stmt->bindParam(':imagenRuta', $imagenRuta);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->errorInfo()]);
    }

    $pdo = null;
}
?>

