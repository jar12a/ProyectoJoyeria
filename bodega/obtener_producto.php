<?php
include '../confi/conexion.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];

$sql = "SELECT * FROM producto WHERE ID_Producto = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(["producto" => $producto]);
} else {
    echo json_encode(["producto" => null]);
}

$pdo = null;
?>
