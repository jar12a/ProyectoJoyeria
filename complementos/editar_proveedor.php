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
    $tipo_pago = $data['tipo_pago'];
    $envio = $data['envio'];
    $banco = $data['banco'];
    $numCuenta = $data['numCuenta'];
    $nombreTitular = $data['nombreTitular'];
    $tipoCuenta = $data['tipoCuenta'];
    $direccionPagoEfectivo = $data['direccionPagoEfectivo'];
    $horarioPagoEfectivo = $data['horarioPagoEfectivo'];
    $correoPayPal = $data['correoPayPal'];
    $confirmarCuentaPayPal = $data['confirmarCuentaPayPal'];

    // Preparar la consulta SQL para actualizar la tabla
    $sql = "UPDATE proveedores 
            SET empresa = :empresa, contacto = :contacto, correo = :correo, telefono = :telefono, direccion = :direccion, 
                tipo_pago = :tipo_pago, envio = :envio, banco = :banco, numCuenta = :numCuenta, 
                nombreTitular = :nombreTitular, tipoCuenta = :tipoCuenta, direccionPagoEfectivo = :direccionPagoEfectivo, 
                horarioPagoEfectivo = :horarioPagoEfectivo, correoPayPal = :correoPayPal, confirmarCuentaPayPal = :confirmarCuentaPayPal
            WHERE id = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':empresa', $empresa);
    $stmt->bindParam(':contacto', $contacto);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':tipo_pago', $tipo_pago);
    $stmt->bindParam(':envio', $envio);
    $stmt->bindParam(':banco', $banco);
    $stmt->bindParam(':numCuenta', $numCuenta);
    $stmt->bindParam(':nombreTitular', $nombreTitular);
    $stmt->bindParam(':tipoCuenta', $tipoCuenta);
    $stmt->bindParam(':direccionPagoEfectivo', $direccionPagoEfectivo);
    $stmt->bindParam(':horarioPagoEfectivo', $horarioPagoEfectivo);
    $stmt->bindParam(':correoPayPal', $correoPayPal);
    $stmt->bindParam(':confirmarCuentaPayPal', $confirmarCuentaPayPal);
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
