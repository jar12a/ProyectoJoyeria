<?php
// Habilitar la visualización de errores para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Verificar si el archivo de conexión existe
if (file_exists('C:/xampp/htdocs/ProyectoJoyeria/conexion.php')) {
    include 'C:/xampp/htdocs/ProyectoJoyeria/conexion.php';
    echo "Conexión incluida correctamente.";
} else {
    die("No se puede encontrar el archivo de conexión.");
}

// Verificar si la conexión fue exitosa
if (isset($pdo)) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "Error: no se pudo establecer conexión con la base de datos.";
}
?>
