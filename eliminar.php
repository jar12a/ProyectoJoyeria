<?php
require 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Eliminar de la base de datos
    $sql = "DELETE FROM personal WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registro eliminado correctamente'); window.location.href='lista.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>