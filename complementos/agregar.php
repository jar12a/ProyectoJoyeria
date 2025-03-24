<?php
include '../confi/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $documento_identidad = $_POST['documento_identidad'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $direccion = $_POST['direccion'];
    $estado_civil = $_POST['estado_civil'];
    $procedencia = $_POST['procedencia'];
    $salario = $_POST['salario'];
    $nss = $_POST['nss'];
    $contacto_emergencia = $_POST['contacto_emergencia'];
    $fecha_ingreso = date("Y-m-d"); // Fecha automática

    // Manejo de la imagen
    $foto = "";
    if (!empty($_FILES['foto']['name'])) {
        if (!is_dir("uploads")) {
            mkdir("uploads", 0777, true); // Crear la carpeta si no existe
        }
        $foto = basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $foto);
    }

    $sql = "INSERT INTO personal 
            (nombre, correo, telefono, documento_identidad, fecha_nacimiento, direccion, estado_civil, procedencia, salario, nss, contacto_emergencia, fecha_ingreso, foto) 
            VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$nombre, $correo, $telefono, $documento_identidad, $fecha_nacimiento, $direccion, $estado_civil, $procedencia, $salario, $nss, $contacto_emergencia, $fecha_ingreso, $foto])) {
        header("Location: http://localhost:3000/ProyectoJoyeria/complementos/tabla_empleados.php");
        exit();
    } else {
        echo "Error: " . $stmt->errorInfo()[2]; // Muestra el error si falla
    }
}
?>