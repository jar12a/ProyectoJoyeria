<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $index = $data['index'];
    $cantidad = $data['cantidad'];

    if (isset($_SESSION['carrito'][$index])) {
        $_SESSION['carrito'][$index]['cantidad'] = $cantidad;
        $precio = $_SESSION['carrito'][$index]['precio'];
        echo json_encode(['success' => true, 'precio' => $precio]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>