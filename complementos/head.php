<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imperial Gems</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/tu_codigo_aqui.js" crossorigin="anonymous"></script>
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

            <div class="col-12 col-md-4 d-flex justify-content-center justify-content-md-end">
                <div class="container-user">
                    <button type="button" class="btn btn-primary position-relative">
                        Mensajes
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            0
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </button>
                    <i class="fa-solid fa-user"></i>
                    <a href="/ProyectoJoyeria/listadedeseo.php" class="icon-link">
                        <i class="fa-solid fa-heart"></i>
                    </a>
                    <a href="/ProyectoJoyeria/carrito.php" class="icon-link">
                        <i class="fa-solid fa-basket-shopping"></i>
                    </a>
                    <div class="content-shopping-cart">
                        <span class="text">Carrito</span>
                        <span class="number" id="cart-count">(<?php
                        echo (empty($_SESSION['carrito'])) ? 0 : count($_SESSION['carrito']);
                        ?>)</span>
                    </div>
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
                    <a class="nav-link active" aria-current="page" href="/ProyectoJoyeria/login.php">Iniciar Sesion</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Catálogos
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="categoria_aritos.php">Aritos</a></li>
                        <li><a class="dropdown-item" href="categoria_anillos.php">Anillos</a></li>
                        <li><a class="dropdown-item" href="categoria_cadena.php">Cadenas</a></li>
                        <li><a class="dropdown-item" href="categoria_brazaletes.php">Brazaletes</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Algo más aquí</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/ProyectoJoyeria/catalago1.php">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true">Imperial Gems</a>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
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

