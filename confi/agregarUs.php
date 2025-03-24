<?php 
// Incluir el archivo de conexión
<<<<<<< HEAD
$host = 'localhost'; // O tu host de base de datos
$usuario = 'root';   // Tu usuario de base de datos
$contrasena = '';    // Tu contraseña de base de datos
$nombre_bd = 'sistema_gestion'; // El nombre de tu base de datos
=======
$host = 'localhost'; // host de base de datos
$usuario = 'root';   // usuario de base de datos
$contrasena = '';    // contraseña de base de datos
$nombre_bd = 'sistema_gestion'; // El nombre de la base de datos
>>>>>>> rol-+-extras

try {
    // Aquí se establece la conexión
    $conn = new PDO("mysql:host=$host;dbname=$nombre_bd", $usuario, $contrasena);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Conexión fallida: " . $e->getMessage();
}
?>
