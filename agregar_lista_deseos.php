<?php
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}

$producto = [
    'id' => $data['id'],
    'nombre' => $data['nombre'],
    'precio' => $data['precio'],
    'imagen' => $data['imagen']
];

// Verificar si el producto ya está en la lista de deseos
$producto_existente = false;
foreach ($_SESSION['wishlist'] as $item) {
    if ($item['id'] == $producto['id']) {
        $producto_existente = true;
        break;
    }
}

if (!$producto_existente) {
    $_SESSION['wishlist'][] = $producto;
}

echo json_encode(['success' => true]);
?>