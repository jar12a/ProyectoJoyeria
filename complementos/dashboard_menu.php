
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">

        <div class="sb-sidenav-menu">
            <div class="nav">

                <a class="nav-link" href="../dashboard/principal.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Menú
                </a>



                <div class="sb-sidenav-menu-heading"></div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Administrar
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="../dashboard/bodega_dasboard.php">Bodega</a>
                        <a class="nav-link" href="../complementos/dashboard_verpedido_adm.php">Pedidos</a>
                        <a class="nav-link" href="../complementos/tabla_usuarios.php">Usuarios</a>
                        <a class="nav-link" href="../complementos/tabla_usuarios.php">Empleados</a>
                        <a class="nav-link" href="../complementos/tabla_usuarios.php">Proveedores</a>
                        <a class="nav-link" href="../complementos/dashboard_mensajes.php">Mensajes </a>   
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Páginas
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
<<<<<<< HEAD
                     
=======
<<<<<<< HEAD
                    <a class="nav-link" href="../complementos/dashboard_mensajes.php">Mensajes </a>    
=======
                    <?php if (tienePermiso('dashboard_mensajes.php', $_SESSION['idRol'])): ?>
                    <a class="nav-link" href="../complementos/dashboard_mensajes.php">Mensajes </a>
                    <?php endif; ?>
                        
                    <?php if (mostrarElementoSegunRol(ROL_ADMIN) || mostrarElementoSegunRol(ROL_VENDEDOR)): ?>
>>>>>>> rol-+-extras
>>>>>>> origin/catalogo-productos
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                            Autentificación
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="../dashboard/login.php">Inicio de sesión</a>
<<<<<<< HEAD
                                <a class="nav-link" href="../dashboard/registro.php">Registrar</a>
                                <a class="nav-link" href="../dashboard/password.php">Recuperar contraseña</a>
                            </nav>
                        </div>
<<<<<<< HEAD
                        
                        
                    </nav>
                </div>

                
=======
=======
                                <?php if (mostrarElementoSegunRol(ROL_ADMIN)): ?>
                                <a class="nav-link" href="../dashboard/registro.php">Registrar</a>
                                <?php endif; ?>
                                <a class="nav-link" href="../dashboard/password.php">Recuperar contraseña</a>
                            </nav>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (mostrarElementoSegunRol(ROL_ADMIN)): ?>
>>>>>>> rol-+-extras
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
<<<<<<< HEAD
                    </nav>
                </div>

=======
                    <?php endif; ?>
                    </nav>
                </div>

                <?php if (mostrarElementoSegunRol(ROL_ADMIN)): ?>
>>>>>>> rol-+-extras
                <div class="sb-sidenav-menu-heading">Addons</div>
                <a class="nav-link" href="charts.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Charts
                </a>
                <a class="nav-link" href="tables.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Tables
                </a>
<<<<<<< HEAD
=======
                <?php endif; ?>
>>>>>>> rol-+-extras
>>>>>>> origin/catalogo-productos
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