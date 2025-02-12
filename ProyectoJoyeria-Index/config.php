<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');  // Normalmente 'root' en XAMPP
define('DB_PASSWORD', '');  // Generalmente vacío en XAMPP
define('DB_NAME', 'sistema_gestion');

// Crear conexión
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>