<?php
include_once '../confi/conexion.php';

if (isset($_POST['usuario'])) {
    $usuario = trim($_POST['usuario']);
    $query = "SELECT COUNT(*) as count FROM usuario WHERE usuario = :usuario";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['usuario' => $usuario]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        echo 'El nombre de usuario ya está registrado.';
    } else {
        echo '';
    }
}
?>