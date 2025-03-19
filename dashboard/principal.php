<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}
$nombre = $_SESSION['nombre'];
$idRol = $_SESSION['idRol'];





?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Imperial Gems</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../dashboard/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

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