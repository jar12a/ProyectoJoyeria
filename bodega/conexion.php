<?php
$servername = "localhost"; // Servidor de la BD
$username = "root"; // Usuario (en XAMPP por defecto es 'root')
$password = ""; // Contraseña (en XAMPP normalmente es vacía)
$database = "sistema_gestion"; // Nombre de la BD

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
