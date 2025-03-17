<?php

if (!isset($_SESSION['id']) || !isset($_SESSION['idRol'])) {
    // Si no hay sesión activa, redirige al login
    header("Location: login.php");
    exit();
}

// Definición de roles
define('ROL_ADMIN', 1);    // Rol de administrador
define('ROL_VENDEDOR', 2); // Rol de vendedor
define('ROL_CLIENTE', 3);  // Rol de cliente

// Definir los niveles de acceso según los roles
$privilegios = [
    ROL_ADMIN => ["admin.php", "vendedor.php", "cliente.php", "principal.php", "index.php"],  // Admin (acceso a todo)
    ROL_VENDEDOR => ["vendedor.php", "cliente.php", "principal.php"],  // Vendedor (acceso a vendedor y cliente)
    ROL_CLIENTE => ["cliente.php", "index.php"]  // Cliente (acceso solo a cliente y la página principal)
];

// Verificar si el usuario tiene permiso para estar en la página actual
$pagina_actual = basename($_SERVER['PHP_SELF']); // Obtiene el nombre del archivo actual
$rol_usuario = $_SESSION['idRol']; // Rol del usuario

// Comprobación especial para admin - puede acceder a cualquier página
if ($rol_usuario == ROL_ADMIN) {
    // El administrador puede acceder a todas las páginas
    // No se necesita redirección
} 
// Para otros roles, verificar si pueden acceder a la página actual
else if (!in_array($pagina_actual, $privilegios[$rol_usuario])) {
    // Si la página actual no está permitida para su rol, redirigir
    header("Location: acceso_denegado.php");
    exit();
}

// Función auxiliar para comprobar si un usuario puede acceder a una página específica
function tienePermiso($pagina, $rol) {
    global $privilegios;
    return in_array($pagina, $privilegios[$rol]);
}

// Función para redirigir al usuario a su página de inicio según su rol
function redirigirSegunRol($rol) {
    switch ($rol) {
        case ROL_ADMIN:
            return "admin.php";
        case ROL_VENDEDOR:
            return "vendedor.php";
        case ROL_CLIENTE:
            return "../index.php";
        default:
            return "../index.php";
    }
}
?>
