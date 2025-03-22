<?php
include "../confi/session_start.php";
// consultas sql
include '../confi/conexion.php'; // crea la conexion con la base de datos

// Obtener los valores de los filtros si existen y Construir la consulta SQL con los filtros
include '../confi/filtro_bodega.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    include "../complementos/head_html.php";
    ?>
</head>

<body class="sb-nav-fixed">
    <?php
    include "../complementos/dashboard_head.php";
    ?>

    <!--Barra de navegación -->
    <div id="layoutSidenav">
        <?php
        include "../complementos/dashboard_menu.php";
        ?>
        <!--//Agregar todo para el cuerpo del principal-->
        <div id="layoutSidenav_content">
    <!-- Hero Section -->
    <div class="hero-section" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../img/gem-background.jpg'); background-size: cover; background-position: center; padding: 100px 20px; text-align: center; color: white;">
        <h1 class="display-4">Bienvenido a Imperial Gems</h1>
        <p class="lead">Descubre la elegancia y el lujo en cada una de nuestras joyas y gemas exclusivas.</p>
        <a href="#nuestros-productos" class="btn btn-primary btn-lg">Explorar Colección</a>
    </div>

    <!-- Contenido adicional (opcional) -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4 text-center">
                <h3>Calidad Inigualable</h3>
                <p>Nuestras gemas son seleccionadas cuidadosamente para garantizar la máxima calidad y brillo.</p>
            </div>
            <div class="col-md-4 text-center">
                <h3>Diseños Exclusivos</h3>
                <p>Cada pieza es creada por artesanos expertos, combinando tradición y modernidad.</p>
            </div>
            <div class="col-md-4 text-center">
                <h3>Compromiso con el Cliente</h3>
                <p>Ofrecemos un servicio personalizado para satisfacer todas tus necesidades.</p>
            </div>
        </div>
    </div>

    <?php
    include "../complementos/footer_dashboard.php";
    ?>
</div>
    </div>
    </div>
    <?php
    include "../confi/cierre_sesion.php";
    ?>
</body>

</html>