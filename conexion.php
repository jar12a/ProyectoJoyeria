<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema/gestion";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>