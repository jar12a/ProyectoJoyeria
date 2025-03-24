<?php
include '../confi/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Eliminar de la base de datos
    $sql = "DELETE FROM personal WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$id])) {
        echo "<script>alert('Registro eliminado correctamente'); window.location.href='http://localhost:3000/ProyectoJoyeria/complementos/tabla_empleados.php';</script>";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>