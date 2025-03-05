<?php
include '../confi/conexionproductos.php';

$sql = "SELECT ID_categoría, Nombre FROM categoría";
$stmt = $pdo->query($sql);

$categorias = [];
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $categorias[] = $row;
    }
}

echo json_encode(["categorias" => $categorias]);

$pdo = null;
?>
