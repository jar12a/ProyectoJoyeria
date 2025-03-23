<?php
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id']) && isset($_SESSION['wishlist'])) {
    foreach ($_SESSION['wishlist'] as $index => $producto) {
        if ($producto['id'] == $data['id']) {
            unset($_SESSION['wishlist'][$index]);
            $_SESSION['wishlist'] = array_values($_SESSION['wishlist']); // Reindexar el array
            echo json_encode(['success' => true]);
            exit;
        }
    }
}

echo json_encode(['success' => false]);
?>