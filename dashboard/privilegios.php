<?php

// Definición de roles
define('ROL_ADMIN', 1);      // Rol de administrador
define('ROL_VENDEDOR', 2);   // Rol de vendedor
define('ROL_CLIENTE', 3);    // Rol de cliente
define('ROL_VISITANTE', 0);  // Rol de visitante (no registrado)

// Definir los niveles de acceso según los roles - formato más completo
$privilegios = [
    ROL_ADMIN => [
        "principal.php", "index.php", "cliente.php", "admin.php", "vendedor.php",
        "proveedores/index.php", "empleados/index.php", "mensajes/index.php",
        "usuarios/index.php", "bodega/index.php", "pedidos/index.php",
        "dashboard_bodega1.php", "dashboard_verpedido_adm.php", "tabla_usuarios.php",
        "dashboard_mensajes.php", "bodega_dasboard.php", "perfil.php",
        "ver_pedido.php", "acceso_denegado.php", "login.php", "registro.php", 
        "codigo_recu.php", "recucontra.php", "password.php",
        "registrar_proveedores_dashboard.php", "proveedores_dashboard.php", "tabla_empleados.php"
        // Admin tiene acceso a todas las páginas
    ],
    ROL_VENDEDOR => [
        "principal.php", "cliente.php", "mensajes/index.php", "index.php","password.php",
        "bodega/index.php", "pedidos/index.php", "dashboard_mensajes.php",
        "perfil.php", "ver_pedido.php", "acceso_denegado.php", "login.php",
        "codigo_recu.php", "recucontra.php", "dashboard_verpedido_adm.php" // Añadido acceso a pedidos
        // Vendedor tiene acceso limitado
    ],
    ROL_CLIENTE => [
        "cliente.php", "index.php", "pedidos/index.php", "perfil.php",
        "ver_pedido.php", "acceso_denegado.php", "carrito.php", "listadedeseo.php", 
        "login.php", "registro.php", "codigo_recu.php", "recucontra.php", "password.php"
        // Cliente solo puede ver su área
    ],
    ROL_VISITANTE => [
        "index.php", "catalago1.php", "categoria_aritos.php", "categoria_anillos.php", 
        "categoria_cadena.php", "categoria_brazaletes.php", "Contacto.php",
        "login.php", "registro.php", "password.php", "acceso_denegado.php", 
        "codigo_recu.php", "recucontra.php"
        // Visitantes solo pueden ver páginas públicas
    ]
];

// Si no hay sesión activa, asignar rol de visitante para el resto del script
if (!isset($_SESSION['id']) || !isset($_SESSION['idRol'])) {
    // Para fines de verificación en este archivo, tratar como visitante
    $rol_usuario = ROL_VISITANTE;
    
    // Si estamos tratando de acceder a páginas de dashboard protegidas, redirigir al login
    // Pero permitir explícitamente la recuperación de contraseña completa
    if (strpos($_SERVER['SCRIPT_NAME'], '/dashboard/') !== false && 
        !in_array(basename($_SERVER['PHP_SELF']), [
            'login.php', 
            'registro.php', 
            'password.php', 
            'codigo_recu.php',
            'recucontra.php',
            'acceso_denegado.php'
        ])) {
        header("Location: ../dashboard/login.php");
        exit();
    }
} else {
    // Usuario con sesión, obtener su rol
    $rol_usuario = $_SESSION['idRol'];
}

// Verificar si el usuario tiene permiso para estar en la página actual
$pagina_actual = basename($_SERVER['PHP_SELF']); // Obtiene el nombre del archivo actual

// Comprobación especial para admin - puede acceder a cualquier página
if ($rol_usuario == ROL_ADMIN) {
    // El administrador puede acceder a todas las páginas
    // No se necesita redirección
} 
// Para otros roles, verificar si pueden acceder a la página actual
else {
    $puede_acceder = false;
    foreach ($privilegios[$rol_usuario] as $pagina_permitida) {
        // Comprobar si la página actual coincide con alguna permitida
        if (strpos($pagina_actual, $pagina_permitida) !== false) {
            $puede_acceder = true;
            break;
        }
    }
    
    if (!$puede_acceder) {
        // Si la página actual no está permitida para su rol, redirigir
        header("Location: " . getRutaAccesoDenegado());
        exit();
    }
}

// Obtiene la ruta correcta para el archivo de acceso denegado
function getRutaAccesoDenegado() {
    $script_name = $_SERVER['SCRIPT_NAME'];
    
    // Detectar si estamos en el directorio principal o en un subdirectorio
    if (strpos($script_name, '/dashboard/') !== false) {
        return '../dashboard/acceso_denegado.php';
    } else if (strpos($script_name, '/complementos/') !== false) {
        return '../dashboard/acceso_denegado.php';
    } else {
        return './dashboard/acceso_denegado.php';
    }
}

// Función auxiliar para comprobar si un usuario puede acceder a una página específica
function tienePermiso($pagina, $rol) {
    global $privilegios;
    
    if ($rol == ROL_ADMIN) return true; // Admin siempre tiene permiso
    
    // Si no hay rol definido (visitante), usar ROL_VISITANTE para verificar permisos
    if (!isset($rol) || empty($rol)) {
        $rol = ROL_VISITANTE;
    }
    
    foreach ($privilegios[$rol] as $pagina_permitida) {
        if (strpos($pagina, $pagina_permitida) !== false) {
            return true;
        }
    }
    return false;
}

// Función para redirigir al usuario a su página de inicio según su rol
function redirigirSegunRol($rol) {
    switch ($rol) {
        case ROL_ADMIN:
            return "../dashboard/principal.php";
        case ROL_VENDEDOR:
            return "../dashboard/principal.php";
        case ROL_CLIENTE:
            return "../index.php";
        case ROL_VISITANTE:
        default:
            return "../index.php";
    }
}

// Función para obtener el nombre del panel según el rol
function getNombrePanel($rol) {
    switch ($rol) {
        case ROL_ADMIN:
            return "Panel de Control";
        case ROL_VENDEDOR:
            return "Panel de Control";
        case ROL_CLIENTE:
            return "Mi Cuenta";
        case ROL_VISITANTE:
        default:
            return "Acceso";
    }
}

// Función para mostrar/ocultar elementos de la interfaz según rol
function mostrarElementoSegunRol($rolRequerido) {
    if (!isset($_SESSION['idRol'])) return $rolRequerido == ROL_VISITANTE;
    
    $rol_usuario = $_SESSION['idRol'];
    return $rol_usuario == $rolRequerido || $rol_usuario == ROL_ADMIN;
}

// Función que devuelve una clase CSS según se tenga acceso o no
function claseAccesoSegunRol($pagina) {
    if (!isset($_SESSION['idRol'])) {
        // Para usuarios no logueados, verificar con ROL_VISITANTE
        return tienePermiso($pagina, ROL_VISITANTE) ? "" : "disabled";
    }
    
    $rol_usuario = $_SESSION['idRol'];
    return tienePermiso($pagina, $rol_usuario) ? "" : "disabled";
}

// Función para verificar si un usuario está logueado
function estaLogueado() {
    return isset($_SESSION['id']) && isset($_SESSION['idRol']);
}

// Obtener el rol actual del usuario (visitante si no está logueado)
function getRolActual() {
    return isset($_SESSION['idRol']) ? $_SESSION['idRol'] : ROL_VISITANTE;
}
?>

