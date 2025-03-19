<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../dashboard/login.php");
}
$nombre = $_SESSION['nombre'];
$idRol = $_SESSION['idRol'];
?>