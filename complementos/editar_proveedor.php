<?php
// Incluir el archivo de conexión
include '../confi/conexion.php';

// Leer los datos enviados en formato JSON
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    // Capturar los datos
    $id = $data['id'];
    $empresa = $data['empresa'];
    $contacto = $data['contacto'];
    $correo = $data['correo'];
    $telefono = $data['telefono'];
    $direccion = $data['direccion'];
    $envio = $data['envio'];

    // Preparar la consulta SQL para actualizar la tabla
    $sql = "UPDATE proveedores 
            SET empresa = :empresa, contacto = :contacto, correo = :correo, telefono = :telefono, direccion = :direccion, 
                envio = :envio
            WHERE id = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':empresa', $empresa);
    $stmt->bindParam(':contacto', $contacto);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':envio', $envio);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Ejecutar la consulta y devolver el resultado
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->errorInfo()]);
    }
} else {
    echo json_encode(["success" => false, "error" => "No se recibieron datos."]);
}

// Cerrar la conexión
$pdo = null;
?>
