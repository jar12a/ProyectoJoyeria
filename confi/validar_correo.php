<?php
include_once '../confi/conexion.php';

if (isset($_POST['correo'])) {
    $correo = trim($_POST['correo']);
    $query = "SELECT COUNT(*) as count FROM usuario WHERE correo = :correo";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['correo' => $correo]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        echo 'El correo electrónico ya está registrado.';
    } else {
        echo '';
    }
}
?>