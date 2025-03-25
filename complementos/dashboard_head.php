<?php
// Incluir privilegios.php para verificación de permisos
if (!function_exists('estaLogueado')) {
    include_once "../dashboard/privilegios.php";
}

// Verificar si la sesión existe
if (!estaLogueado()) {
    header("Location: ../dashboard/login.php");
    exit();
}
?>
<div>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="../index.php">Imperial Gems</a>
        <!-- Sidebar Toggle para mostrar el menú principal-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

        <!-- Botón para regresar al sitio principal -->
        <a href="../index.php" class="btn btn-outline-light btn-sm ms-2 d-none d-md-inline-block">
            <i class="fas fa-home me-1"></i>Ir al Sitio Web
        </a>

        <!-- Indicador de rol del usuario -->
        <span class="navbar-text d-none d-md-block text-light ms-3">
            <?php 
            $rolTexto = "";
            switch($_SESSION['idRol']) {
                case 1: $rolTexto = "Administrador"; break;
                case 2: $rolTexto = "Vendedor"; break;
                case 3: $rolTexto = "Cliente"; break;
                default: $rolTexto = "Usuario";
            }
            echo $rolTexto;
            ?>
        </span>

        <!-- Navbar de usuario-->
        <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php
                    echo $nombre; //imprime el nombre de quien esta conectado
                    ?>
                    <i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <?php if ($_SESSION['idRol'] == ROL_ADMIN): ?>
                    <li><a class="dropdown-item" href="../complementos/tabla_usuarios.php">Gestionar Usuarios</a></li>
                    <?php endif; ?>
                    <li><a class="dropdown-item" href="../index.php">Ir al Sitio Web</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="../confi/logout.php">Salir</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</div>