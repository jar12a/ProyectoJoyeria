<?php
// Configuración de la base de datos
$host = 'localhost';  // Dirección del servidor de base de datos
$dbname = 'sistema_gestion';  // Nombre de la base de datos
$username = 'root';  // Usuario de la base de datos
$password = "";  // Contraseña del usuario

// Crear la cadena de conexión (DSN)
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

// Intentar establecer la conexión
try {
    // Crear una instancia de mysqli para la conexión
    $conn = new mysqli($host, $username, $password, $dbname);

    // Verificar si hay errores en la conexión
    if ($conn->connect_error) {
        die("Error al conectar con la base de datos: " . $conn->connect_error);
    }
} catch (Exception $e) {
    // Si hay un error de conexión, mostrarlo
    die("Error al conectar con la base de datos: " . $e->getMessage());
}
?>