<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $nombre = $data['nombre'];
    $precio = $data['precio'];
    $cantidad = $data['cantidad'];
    $imagen = $data['imagen'];

    // Verificar si el carrito ya existe en la sesión
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Verificar si el producto ya está en el carrito
    $productoExistente = false;
    foreach ($_SESSION['carrito'] as &$producto) {
        if ($producto['id'] === $id) {
            $producto['cantidad'] += $cantidad;
            $productoExistente = true;
            break;
        }
    }

    // Si el producto no existe en el carrito, agregarlo
    if (!$productoExistente) {
        $_SESSION['carrito'][] = [
            'id' => $id,
            'nombre' => $nombre,
            'precio' => $precio,
            'cantidad' => $cantidad,
            'imagen' => $imagen
        ];
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>