<?php
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['index']) && isset($_SESSION['carrito'][$data['index']])) {
    unset($_SESSION['carrito'][$data['index']]);
    $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar el array
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>