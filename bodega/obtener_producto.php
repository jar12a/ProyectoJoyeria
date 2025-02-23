<?php
include 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];

$sql = "SELECT * FROM producto WHERE ID_Producto = '$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $producto = $result->fetch_assoc();
    echo json_encode(["producto" => $producto]);
} else {
    echo json_encode(["producto" => null]);
}

$conn->close();
?>
