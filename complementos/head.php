<?php

// Verificar si el archivo cierre_sesion.php existe antes de incluirlo
if (file_exists('../confi/cierre_sesion.php')) {
    include '../confi/cierre_sesion.php';
} else {
    error_log("Archivo cierre_sesion.php no encontrado en la ruta especificada.");
}

include __DIR__ . '/../confi/conexion.php'; // Corregir la ruta del archivo

// Incluir privilegios.php para tener acceso a sus funciones
if (!function_exists('tienePermiso')) {
    if (file_exists(__DIR__ . '/../dashboard/privilegios.php')) {
        include_once __DIR__ . '/../dashboard/privilegios.php';
    }
}

// Obtener el nombre de usuario desde la base de datos si la sesión está iniciada
if (isset($_SESSION['id'])) {
    $stmt = $pdo->prepare("SELECT usuario FROM usuario WHERE id = ?");
    $stmt->execute([$_SESSION['id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($usuario) {
        $_SESSION['usuario'] = $usuario['usuario'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imperial Gems</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .container-user {
            display: flex;
            align-items: center;
            gap: 1px; /* Espacio entre los elementos */
        }
        .icon-link {
            margin-left: 5px; /* Espacio entre los iconos */
        }
        /* Estilo para el indicador de rol */
        .role-badge {
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
            padding: 2px 6px;
            font-size: 0.8rem;
            margin-left: 5px;
        }
    </style>
    <script src="https://kit.fontawesome.com/45b2b3afef.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-hero">
        <div class="container hero">
            <div class="row align-items-center">
                <div class="col-12 col-md-4 d-flex justify-content-center justify-content-md-start">
                    <div class="customer-support">
                        <i class="fa-solid fa-headset"></i>
                        <div class="content-customer-support">
                            <span class="text">Soporte al cliente</span>
                            <span class="number">+504 9667-7273</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 d-flex justify-content-center">
                    <div class="container-logo">
                        <i class="fa-regular fa-gem fa-beat-fade"></i>
                        <h1 class="logo"><a href="index.php">Imperial Gems</a></h1>
                    </div>
                </div>
                
            </div>
            <div class="row align-items-center mt-3">
                <div class="col-10 col-md-4 d-flex justify-content-center justify-content-md-end">
                    <div class="container-user">
                        <?php if (isset($_SESSION['id']) && isset($_SESSION['idRol']) && ($_SESSION['idRol'] == 1 || $_SESSION['idRol'] == 2)): ?>
                        <a href="/ProyectoJoyeria/complementos/dashboard_mensajes.php" class="btn btn-primary position-relative">
                            Mensajes
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                0
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </a>
                        <?php else: ?>
                        
                        <?php endif; ?>

                        <div class="dropdown">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user"></i>
                                <?php
                                if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])) {
                                    echo htmlspecialchars($_SESSION['usuario']); // Mostrar el nombre de usuario
                                    
                                    // Mostrar indicador de rol si está disponible
                                    if (isset($_SESSION['idRol'])) {
                                        $rolTexto = "";
                                        switch($_SESSION['idRol']) {
                                            case 1: $rolTexto = "Admin"; break;
                                            case 2: $rolTexto = "Vendedor"; break;
                                            case 3: $rolTexto = "Cliente"; break;
                                        }
                                        echo '<span class="role-badge">' . $rolTexto . '</span>';
                                    }
                                } else {
                                    echo 'Usuario';
                                }
                                ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <?php
                                if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])) {
                                    // Mostrar enlaces según el rol del usuario
                                    if (isset($_SESSION['idRol'])) {
                                        if ($_SESSION['idRol'] == 1 || $_SESSION['idRol'] == 2) { // Admin o Vendedor
                                            echo '<li><a class="dropdown-item" href="/ProyectoJoyeria/dashboard/principal.php">Panel de Control</a></li>';
                                        }
                                        // Todos pueden ver Mi Cuenta, pero es la principal para clientes
                                        echo '<li><a class="dropdown-item" href="/ProyectoJoyeria/dashboard/cliente.php">Mi Cuenta</a></li>';
                                    }
                                    echo '<li><a class="dropdown-item" href="/ProyectoJoyeria/ver_pedido.php">Ver Pedidos</a></li>';
                                    echo '<li><a class="dropdown-item" href="/ProyectoJoyeria/confi/logout.php">Cerrar sesión</a></li>';
                                } else {
                                    echo '<li><a class="dropdown-item" href="/ProyectoJoyeria/dashboard/login.php">Iniciar sesión</a></li>';
                                    echo '<li><a class="dropdown-item" href="/ProyectoJoyeria/dashboard/registro.php">Registrarse</a></li>';
                                }
                                ?>
                            </ul>
                        </div>

                        <?php if (isset($_SESSION['id'])): ?>
                        <a href="/ProyectoJoyeria/listadedeseo.php" class="icon-link">
                            <i class="fa-solid fa-heart"></i>
                        </a>
                        <a href="/ProyectoJoyeria/carrito.php" class="icon-link">
                            <i class="fa-solid fa-basket-shopping"></i>
                        </a>
                        <div class="content-shopping-cart">
                            <span class="text">Carrito</span>
                            <span class="number" id="cart-count">(
                                <?php
                                echo (empty($_SESSION['carrito'])) ? 0 : count($_SESSION['carrito']);
                                ?>)</span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/ProyectoJoyeria/index.php">Inicio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">

                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Catálogos
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/ProyectoJoyeria/categoria_aritos.php">Aritos</a></li>
                            <li><a class="dropdown-item" href="/ProyectoJoyeria/categoria_anillos.php">Anillos</a></li>
                            <li><a class="dropdown-item" href="/ProyectoJoyeria/categoria_cadena.php">Cadenas</a></li>
                            <li><a class="dropdown-item" href="/ProyectoJoyeria/categoria_brazaletes.php">Brazaletes</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Algo más aquí</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ProyectoJoyeria/catalago1.php">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ProyectoJoyeria/Contacto.php">Contáctanos</a>
                    </li>
                </ul>
              
                </ul>
                <form class="d-flex" role="search" action="/ProyectoJoyeria/filtradobusqueda.php" method="GET">
                    <input class="form-control me-2" type="search" name="busqueda" placeholder="Buscar" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </nav>

    <script>
        // Función para actualizar el contador del carrito
        function actualizarContadorCarrito() {
            fetch('obtener_carrito.php')
                .then(response => response.json())
                .then(data => {
                    const cartCount = document.getElementById('cart-count');
                    cartCount.textContent = `(${data.count})`;
                })
                .catch(error => console.error('Error:', error));
        }

        // Llamar a la función para actualizar el contador del carrito al cargar la página
        document.addEventListener('DOMContentLoaded', actualizarContadorCarrito);
    </script>
    
</body>
</html>
