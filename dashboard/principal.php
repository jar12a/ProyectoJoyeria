<?php
include "../confi/session_start.php";
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

        <?php
        include "../complementos/tabla_usuarios.php";
        ?>
    </div>




    <?php
    include "../confi/cierre_sesion.php";
    ?>
</body>


</html>