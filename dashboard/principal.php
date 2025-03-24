<?php
include "../confi/session_start.php";
<<<<<<< HEAD
=======
// Include privileges
if (!function_exists('tienePermiso')) {
    include_once "./privilegios.php";
}
>>>>>>> rol-+-extras
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
    <!-- Menú Gráfico -->
    <div class="container-fluid px-4 mt-4">
        <div class="row">
            <!-- Tarjeta para Menú -->
            <div class="col-md-3 mb-4">
                <div class="card bg-primary text-white text-center">
                    <div class="card-body">
                        <i class="fas fa-home fa-3x mb-3"></i> <!-- Ícono -->
                        <h5 class="card-title">Menú</h5>
                        <p class="card-text">Accede al menú principal.</p>
                        <a href="../dashboard/principal.php" class="btn btn-light">Ir al Menú</a>
                    </div>
                </div>
            </div>

<<<<<<< HEAD
=======
            <?php if (tienePermiso('complementos/tabla_usuarios.php', $_SESSION['idRol']) && $_SESSION['idRol'] == 1): ?>
>>>>>>> rol-+-extras
            <!-- Tarjeta para Proveedores -->
            <div class="col-md-3 mb-4">
                <div class="card bg-success text-white text-center">
                    <div class="card-body">
                        <i class="fas fa-truck fa-3x mb-3"></i> <!-- Ícono -->
                        <h5 class="card-title">Proveedores</h5>
                        <p class="card-text">Gestiona proveedores y pedidos.</p>
<<<<<<< HEAD
                        <a href="../complementos/proveedores_dashboard.php" class="btn btn-light">Ver Proveedores</a>
                    </div>
                </div>
            </div>

=======
                        <a href="../complementos/tabla_usuarios.php" class="btn btn-light">Ver Proveedores</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if (tienePermiso('complementos/tabla_usuarios.php', $_SESSION['idRol']) && $_SESSION['idRol'] == 1): ?>
>>>>>>> rol-+-extras
            <!-- Tarjeta para Empleados -->
            <div class="col-md-3 mb-4">
                <div class="card bg-warning text-dark text-center">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x mb-3"></i> <!-- Ícono -->
                        <h5 class="card-title">Empleados</h5>
                        <p class="card-text">Administra el personal.</p>
<<<<<<< HEAD
                        <a href="../complementos/tabla_empleados.php" class="btn btn-light">Ver Empleados</a>
                    </div>
                </div>
            </div>

=======
                        <a href="../complementos/tabla_usuarios.php" class="btn btn-light">Ver Empleados</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if (tienePermiso('complementos/dashboard_mensajes.php', $_SESSION['idRol'])): ?>
>>>>>>> rol-+-extras
            <!-- Tarjeta para Mensajes -->
            <div class="col-md-3 mb-4">
                <div class="card bg-danger text-white text-center">
                    <div class="card-body">
                        <i class="fas fa-envelope fa-3x mb-3"></i> <!-- Ícono -->
                        <h5 class="card-title">Mensajes</h5>
                        <p class="card-text">Revisa y envía mensajes.</p>
                        <a href="../complementos/dashboard_mensajes.php" class="btn btn-light">Ver Mensajes</a>
                    </div>
                </div>
            </div>
<<<<<<< HEAD

=======
            <?php endif; ?>

            <?php if (tienePermiso('complementos/tabla_usuarios.php', $_SESSION['idRol']) && $_SESSION['idRol'] == 1): ?>
>>>>>>> rol-+-extras
            <!-- Tarjeta para Usuarios -->
            <div class="col-md-3 mb-4">
                <div class="card bg-info text-white text-center">
                    <div class="card-body">
                        <i class="fas fa-user-cog fa-3x mb-3"></i> <!-- Ícono -->
                        <h5 class="card-title">Usuarios</h5>
                        <p class="card-text">Gestiona los usuarios del sistema.</p>
                        <a href="../complementos/tabla_usuarios.php" class="btn btn-light">Ver Usuarios</a>
                    </div>
                </div>
            </div>
<<<<<<< HEAD

=======
            <?php endif; ?>

            <?php if (tienePermiso('bodega_dasboard.php', $_SESSION['idRol']) && $_SESSION['idRol'] == 1): ?>
>>>>>>> rol-+-extras
            <!-- Tarjeta para Bodega -->
            <div class="col-md-3 mb-4">
                <div class="card bg-secondary text-white text-center">
                    <div class="card-body">
                        <i class="fas fa-warehouse fa-3x mb-3"></i> <!-- Ícono -->
                        <h5 class="card-title">Bodega</h5>
                        <p class="card-text">Gestiona el inventario en bodega.</p>
<<<<<<< HEAD
                        <a href="../dashboard/bodega_dasboard.php" class="btn btn-light">Ver Bodega</a>
                    </div>
                </div>
            </div>

=======
                        <a href="bodega_dasboard.php" class="btn btn-light">Ver Bodega</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if (tienePermiso('complementos/dashboard_verpedido_adm.php', $_SESSION['idRol']) && $_SESSION['idRol'] == 1): ?>
>>>>>>> rol-+-extras
            <!-- Tarjeta para Pedidos -->
            <div class="col-md-3 mb-4">
                <div class="card bg-dark text-white text-center">
                    <div class="card-body">
                        <i class="fas fa-clipboard-list fa-3x mb-3"></i> <!-- Ícono -->
                        <h5 class="card-title">Pedidos</h5>
                        <p class="card-text">Revisa y gestiona los pedidos.</p>
                        <a href="../complementos/dashboard_verpedido_adm.php" class="btn btn-light">Ver Pedidos</a>
                    </div>
                </div>
            </div>
<<<<<<< HEAD
=======
            <?php endif; ?>
>>>>>>> rol-+-extras
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