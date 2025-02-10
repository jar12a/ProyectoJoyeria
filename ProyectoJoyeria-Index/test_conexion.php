<?php
$servername = "localhost";
$username = "root";  // Corregido de "categoría"
$password = "";
$dbname = "sistema_gestion";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conexión exitosa a la base de datos";

// Consulta para ver usuario
$sql = "SELECT u.*, l.Correo as LoginCorreo 
        FROM Usuario u
        JOIN Login l ON u.ID_Login = l.ID_Login
        WHERE u.Nombre = 'Juan Pérez'";  // Cambia el nombre según tu usuario

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<br>Datos del usuario:";
    while($row = $result->fetch_assoc()) {
        echo "<br>ID: " . $row['ID_Usuario'];
        echo "<br>Nombre: " . $row['Nombre'];
        echo "<br>Correo: " . $row['Correo'];
        echo "<br>Teléfono: " . $row['Teléfono'];
        echo "<br>Login Correo: " . $row['LoginCorreo'];
    }
} else {
    echo "<br>No se encontró el usuario";
}

$conn->close();
?>