<?php
include "../confi/session_start.php";
// consultas sql
include '../confi/conexion.php'; // crea la conexion con la base de datos

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
        ?><!--//Agregar todo para el cuerpo-->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Barra de navegación</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="../dashboard/principal.php">Menú</a></li>
                            <li class="breadcrumb-item active">Inicio</li>
                        </ol>
                        <div class="card mb-4">

                        </div>
                        <h1 class="mt-4">Imperial Gems</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>




                        <?php
                        // Definir las variables necesarias para el archivo incluido
                        $rows_per_page = isset($_GET['rows_per_page']) ? (int)$_GET['rows_per_page'] : 10;
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $search_cliente = isset($_GET['search_cliente']) ? $_GET['search_cliente'] : '';
                        $search_fecha = isset($_GET['search_fecha']) ? $_GET['search_fecha'] : '';

                        // Incluir el archivo sin parámetros en la URL
                        include_once '../complementos/verpedido_adm.php';
                        ?>



                    </div>
            </main>
            <?php
            include "../complementos/footer_dashboard.php";
            ?>
        </div>
</body>

</html>