<?php
require 'confi/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Eliminar de la base de datos
    $sql = "DELETE FROM personal WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$id])) {
        echo "<script>alert('Registro eliminado correctamente'); window.location.href='lista.php';</script>";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>