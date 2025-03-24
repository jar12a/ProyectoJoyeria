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
            SET empresa = ?, contacto = ?, correo = ?, telefono = ?, direccion = ?, 
                tipo_pago = ?, envio = ?, banco = ?, numCuenta = ?, 
                nombreTitular = ?, tipoCuenta = ?, direccionPagoEfectivo = ?, 
                horarioPagoEfectivo = ?, correoPayPal = ?, confirmarCuentaPayPal = ?
            WHERE id = ?";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param(
        "sssssssssssssssi", 
        $empresa, $contacto, $correo, $telefono, $direccion, 
        $tipo_pago, $envio, $banco, $numCuenta, 
        $nombreTitular, $tipoCuenta, $direccionPagoEfectivo, 
        $horarioPagoEfectivo, $correoPayPal, $confirmarCuentaPayPal, $id
    );

    // Ejecutar la consulta y devolver el resultado
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $conexion->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "error" => "No se recibieron datos."]);
}
?>
