<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['idRol'])) {
    // Si no hay sesión activa, redirigir a la página de login
    header("Location: /ProyectoJoyeria/dashboard/login.php");
    exit();
}

// Obtiene el rol del usuario
$rol = $_SESSION['idRol'];

// Validación según el rol
if ($rol == 1) {
    // Si es administrador, puede hacer estas acciones
    echo "<p>Bienvenido, Administrador.</p>";
    echo "<p>Aquí puedes agregar las funciones exclusivas para administradores.</p>";
    
} elseif ($rol == 2) {
    // Si es vendedor, puede hacer estas acciones
    echo "<p>Bienvenido, Vendedor.</p>";
    echo "<p>Aquí puedes agregar las funciones exclusivas para vendedores.</p>";
    
} elseif ($rol == 3) {
    // Si es cliente, puede hacer estas acciones
    echo "<p>Bienvenido, Cliente.</p>";
    echo "<p>Aquí puedes agregar las funciones exclusivas para clientes.</p>";
    
} else {
    // Si el rol no es válido, cerrar sesión y redirigir
    session_destroy();
    header("Location: /ProyectoJoyeria/index.php");
    exit();
}
?>
