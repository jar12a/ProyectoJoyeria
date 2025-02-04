<?php
// Configuración de la base de datos
$host = 'localhost';  // Dirección del servidor de base de datos
$dbname = 'joyeriaproyecto';  // Nombre de la base de datos
$username = 'root';  // Usuario de la base de datos
$password = '12341234';  // Contraseña del usuario

// Crear la cadena de conexión (DSN)
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

// Intentar establecer la conexión
try {
    // Crear una instancia de PDO para la conexión
    $pdo = new PDO($dsn, $username, $password);
    
    // Configurar PDO para lanzar excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si hay un error de conexión, mostrarlo
    die("Error al conectar con la base de datos: " . $e->getMessage());
}
?>
