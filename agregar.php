<?php
require 'conexion.php';

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
        $foto = basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $foto);
    }

    $sql = "INSERT INTO personal 
            (nombre, correo, telefono, documento_identidad, fecha_nacimiento, direccion, estado_civil, procedencia, salario, nss, contacto_emergencia, fecha_ingreso, foto) 
            VALUES 
            ('$nombre', '$correo', '$telefono', '$documento_identidad', '$fecha_nacimiento', '$direccion', '$estado_civil', '$procedencia', '$salario', '$nss', '$contacto_emergencia', '$fecha_ingreso', '$foto')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php"); // Redirige si todo sale bien
        exit();
    } else {
        echo "Error: " . $conn->error; // Muestra el error si falla
    }

    $conn->close();
}
?>