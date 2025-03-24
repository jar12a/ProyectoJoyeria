<?php
// Include the privileges file if not already included
if (!function_exists('tienePermiso')) {
    include_once "../dashboard/privilegios.php";
}
?>

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">

        <div class="sb-sidenav-menu">
            <div class="nav">

                <a class="nav-link" href="../dashboard/principal.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Menú
                </a>

                <div class="sb-sidenav-menu-heading"></div>
                
                <?php if (mostrarElementoSegunRol(ROL_ADMIN) || mostrarElementoSegunRol(ROL_VENDEDOR)): ?>
                <!-- Sección de Administración - visible para administradores y vendedores (con restricciones) -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Administrar
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <?php if (tienePermiso('dashboard_mensajes.php', $_SESSION['idRol'])): ?>
                        <a class="nav-link" href="../complementos/dashboard_mensajes.php">Mensajes </a>
                        <?php endif; ?>
                        
                        <?php if (mostrarElementoSegunRol(ROL_ADMIN)): ?>
                        <a class="nav-link <?php echo claseAccesoSegunRol('bodega_dasboard.php'); ?>" href="../dashboard/bodega_dasboard.php">Bodega</a>
                        <?php endif; ?>
                        
                        <!-- Pedidos - visible para administradores y vendedores -->
                        <a class="nav-link <?php echo claseAccesoSegunRol('dashboard_verpedido_adm.php'); ?>" href="../complementos/dashboard_verpedido_adm.php">Pedidos</a>
                        
                        <?php if (mostrarElementoSegunRol(ROL_ADMIN)): ?>
                        <a class="nav-link <?php echo claseAccesoSegunRol('tabla_usuarios.php'); ?>" href="../complementos/tabla_usuarios.php">Usuarios</a>
                        <a class="nav-link <?php echo claseAccesoSegunRol('tabla_empleados.php'); ?>" href="../complementos/tabla_empleados.php">Empleados</a>
                        
                        <!-- Submenú de Proveedores - solo visible para administradores -->
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionProveedores">
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseProveedores" aria-expanded="false" aria-controls="pagesCollapseProveedores">
                                Proveedores
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseProveedores" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionProveedores">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../complementos/registrar_proveedores_dashboard.php">Registrar Proveedor</a>
                                    <a class="nav-link" href="../complementos/proveedores_dashboard.php">Mostrar Proveedor</a>
                                </nav>
                            </div>
                        </nav>
                        <?php endif; ?>
                    </nav>
                </div>
                <?php endif; ?>
                
                <!-- Sección de Páginas - visible para todos pero con acceso controlado -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Páginas
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                    
                    <?php if (mostrarElementoSegunRol(ROL_ADMIN) || mostrarElementoSegunRol(ROL_VENDEDOR)): ?>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                            Autentificación
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="../dashboard/login.php">Inicio de sesión</a>
                                <?php if (mostrarElementoSegunRol(ROL_ADMIN)): ?>
                                <a class="nav-link" href="../dashboard/registro.php">Registrar</a>
                                <?php endif; ?>
                                <a class="nav-link" href="../dashboard/password.php">Recuperar contraseña</a>
                            </nav>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (mostrarElementoSegunRol(ROL_ADMIN)): ?>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                            Error
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="401.html">401 Page</a>
                                <a class="nav-link" href="404.html">404 Page</a>
                                <a class="nav-link" href="500.html">500 Page</a>
                            </nav>
                        </div>
                    <?php endif; ?>
                    </nav>
                </div>

                <?php if (mostrarElementoSegunRol(ROL_ADMIN)): ?>
                <div class="sb-sidenav-menu-heading">Addons</div>
                <a class="nav-link" href="charts.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Charts
                </a>
                <a class="nav-link" href="tables.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Tables
                </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="../dashboard/js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="../dashboard/assets/demo/chart-area-demo.js"></script>
<script src="../dashboard/assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="../dashboard/js/datatables-simple-demo.js"></script>

