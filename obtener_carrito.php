<?php
session_start();

$count = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $producto) {
        $count += $producto['cantidad'];
    }
}

echo json_encode(['count' => $count]);
?>