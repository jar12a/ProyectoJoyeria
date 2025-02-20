<?php
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$producto = [
    'id' => $data['id'],
    'nombre' => $data['nombre'],
    'precio' => $data['precio'],
    'cantidad' => $data['cantidad'],
    'imagen' => $data['imagen'] // Añadir la imagen del producto
];

// Verificar si el producto ya está en el carrito
$producto_existente = false;
foreach ($_SESSION['carrito'] as &$item) {
    if ($item['id'] == $producto['id']) {
        $item['cantidad'] += $producto['cantidad'];
        $producto_existente = true;
        break;
    }
}

if (!$producto_existente) {
    $_SESSION['carrito'][] = $producto;
}

echo json_encode(['success' => true]);
?>