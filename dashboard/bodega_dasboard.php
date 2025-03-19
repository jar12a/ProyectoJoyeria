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
        <!--//Agregar todo para el cuerpo-->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Bodega</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../dashboard/principal.php">Menú</a></li>
                        <li class="breadcrumb-item active">Bienvenido a la bodega</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <p class="mb-0">
                                Bienvenido a la bodega
                                <?php
                                include "../bodega/bodega.php"; // Corrige la ruta del archivo

                                ?>
                            </p>
                        </div>
                    </div>

                </div>
            </main>
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