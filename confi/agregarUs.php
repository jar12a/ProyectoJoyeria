<?php 
// Incluir el archivo de conexión
$host = 'localhost: 3307'; // O tu host de base de datos
$usuario = 'root';   // Tu usuario de base de datos
$contrasena = '';    // Tu contraseña de base de datos
$nombre_bd = 'sistema_gestion'; // El nombre de tu base de datos

try {
    // Aquí se establece la conexión
    $conn = new PDO("mysql:host=$host;dbname=$nombre_bd", $usuario, $contrasena);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Conexión fallida: " . $e->getMessage();
}
?>
