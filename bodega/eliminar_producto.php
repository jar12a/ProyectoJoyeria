<?php
include 'conexion.php';

// Recibir el ID del producto a eliminar
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id']; // Acceder al id que se pasó en la solicitud

// Comprobar si el ID es válido
if ($id) {
    $sql = "DELETE FROM producto WHERE ID_Producto = '$id'"; // Asegúrate de que el nombre de la columna sea correcto

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "error" => "ID no válido"]);
}

$conn->close();
?>
