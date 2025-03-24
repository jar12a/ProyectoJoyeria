<?php
// Incluir el archivo de conexión
include '../confi/conexion.php';

// Leer los datos enviados desde JavaScript
$datos = json_decode(file_get_contents("php://input"), true);
$id = $datos['id'];

// Verificar que se recibió un ID válido
if (isset($id) && is_numeric($id)) {
    // Eliminar el registro de la base de datos
    $sql = "DELETE FROM proveedores WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $conexion->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "error" => "ID inválido."]);
}

// Cerrar la conexión
$conexion->close();
?>
