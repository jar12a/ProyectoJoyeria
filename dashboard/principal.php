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
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

</head>

<body class="sb-nav-fixed">

    <style>
        /* Hacer que la tabla sea responsiva */
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f4f4f4;
        }

        @media (max-width: 768px) {
            table {
                font-size: 12px;
                /* Reducir el tamaño de la fuente en pantallas pequeñas */
            }

            table th,
            table td {
                padding: 5px;
            }
        }
    </style>

    <!-- Modal de aviso de cierre de sesión -->
    <div id="modal">
        <div id="modal-content">
            <p>Se cerrará la sesión en <span id="countdown">10</span> segundos por inactividad.</p>
            <button onclick="continuarSesion()">Continuar Sesión</button>
        </div>
    </div>
    </div>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">Start Bootstrap</a>
        <!-- Sidebar Toggle para mostrar el menú principal-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search para buscar
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>-->
        <!-- Navbar de usuario-->
        <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php
                    echo $nombre; //imprime el nombre de quien esta conectado
                    ?>
                    <i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Configuración</a></li>
                    <!--li><a class="dropdown-item" href="#!">Activity Log</a></li-->
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="logout.php">Salir</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <!--Barra de navegación -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">

                        <a class="nav-link" href="/index1.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Menú
                        </a>
                        <?php

                        if ($idRol == 1) { ?>


                        <?php } ?><!--//CIERRA EL IF-->

                        <!--//creacion de edicion de usuarios-->


                        <div class="sb-sidenav-menu-heading"></div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Administrador
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="bodega_dasboard.php">Bodega</a>
                                <a class="nav-link" href="layout-sidenav-light.html">Pedidos</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Páginas
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                    Autentificación
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="login.php">Inicio de sesión</a>
                                        <a class="nav-link" href="register.php">Registrar</a>
                                        <a class="nav-link" href="password.html">Forgot Password</a>
                                    </nav>
                                </div>
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
                            </nav>
                        </div>

                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a>
                        <a class="nav-link" href="tables.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tables
                        </a>
                    </div>
                </div>

            </nav>
        </div>
        <!--//Agregar todo para el cuerpo-->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Barra de navegación</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="principal.php">Menú</a></li>
                            <li class="breadcrumb-item active">Inicio</li>
                        </ol>
                        <div class="card mb-4">

                        </div>
                        <h1 class="mt-4">Imperial Gems</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>

                        <!--//tabla de usuarios-->
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Usuarios
                            </div>

                            <div class="card-body">
                                <?php
                                // include "usuarios.php";
                                //carga los datos del archivo cargar_usuarios.php a la tabla
                                include "../dashboard/cargar_usuarios.php";
                                ?>



                                <!-- Modal de Edición -->
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario de edición de usuario -->
                <form action="principal.php" method="POST">
                    <input type="hidden" name="id" id="usuario_id">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="*****">
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <select class="form-select" id="rol" name="rol" required>
                            <option value="Administrador">Administrador</option>
                            <option value="Vendedor">Vendedor</option>
                            <option value="Cliente">Cliente</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tabla para mostrar los datos -->
<form action="" method="POST">
    <div class="table-responsive">
        <?php
        include "../confi/conexion.php"; // Asegúrate de que la ruta es correcta

        // Consulta para obtener los datos de los usuarios y sus roles
        $query = "SELECT usuario.id, usuario.usuario, usuario.password, usuario.nombre, usuario.telefono, 
                usuario.direccion, usuario.correo, rol.Rol 
            FROM usuario 
            INNER JOIN rol ON usuario.idRol = rol.id";

        try {
            $stmt = $pdo->query($query); // Ejecutar la consulta
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener los resultados
        } catch (PDOException $e) {
            die("Error al obtener los datos: " . $e->getMessage());
        }
        ?>

        <table id="datatablesSimple" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Contraseña</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Acciones</th> <!-- Para editar o eliminar -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario['id']); ?></td>
                        <td><?= htmlspecialchars($usuario['usuario']); ?></td>
                        <td>*****</td> <!-- Contraseña oculta -->
                        <td><?= htmlspecialchars($usuario['nombre']); ?></td>
                        <td><?= htmlspecialchars($usuario['telefono']); ?></td>
                        <td><?= htmlspecialchars($usuario['direccion']); ?></td>
                        <td><?= htmlspecialchars($usuario['correo']); ?></td>
                        <td><?= htmlspecialchars($usuario['Rol']); ?></td>
                        <td>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal"
                                onclick="editarUsuario(<?= htmlspecialchars($usuario['id']); ?>, '<?= htmlspecialchars($usuario['usuario']); ?>', '<?= htmlspecialchars($usuario['password']); ?>', '<?= htmlspecialchars($usuario['nombre']); ?>', '<?= htmlspecialchars($usuario['telefono']); ?>', '<?= htmlspecialchars($usuario['direccion']); ?>', '<?= htmlspecialchars($usuario['correo']); ?>', '<?= htmlspecialchars($usuario['Rol']); ?>')">
                                Editar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Script para inicializar DataTable -->
        <script>
            $(document).ready(function() {
                $('#datatablesSimple').DataTable(); // Inicializa DataTable en la tabla con id datatablesSimple
            });

            // Función para cargar los datos del usuario en el modal
            function editarUsuario(id, usuario, password, nombre, telefono, direccion, correo, rol) {
                document.getElementById('usuario_id').value = id;
                document.getElementById('usuario').value = usuario;
                document.getElementById('password').value = ''; // Campo de contraseña vacío para encriptar cuando se edite
                document.getElementById('password').setAttribute('placeholder', '*****'); // Para que aparezca oculto como ***** si no se edita
                document.getElementById('nombre').value = nombre;
                document.getElementById('telefono').value = telefono;
                document.getElementById('direccion').value = direccion;
                document.getElementById('correo').value = correo;

                // Selecciona el rol correspondiente
                let rolSelect = document.getElementById('rol');
                for (let i = 0; i < rolSelect.options.length; i++) {
                    if (rolSelect.options[i].value === rol) {
                        rolSelect.selectedIndex = i;
                        break;
                    }
                }
            }
        </script>
    </div>
</form>




                            </div>
                        </div>
                    </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <script>
        // Código para cerrar sesión por inactividad
        let tiempoMaxInactivo = 2000000000; // 20 segundos antes de mostrar el modal
        let tiempoParaCerrar = 10000; // 10 segundos para cerrar sesión tras el aviso
        let inactivo;
        let cuentaRegresiva;
        let tiempoRestante = 10; // Segundos de cuenta regresiva

        function mostrarModal() {
            document.getElementById("modal").style.display = "flex";
            tiempoRestante = 10;
            document.getElementById("countdown").textContent = tiempoRestante;

            cuentaRegresiva = setInterval(() => {
                tiempoRestante--;
                document.getElementById("countdown").textContent = tiempoRestante;

                if (tiempoRestante <= 0) {
                    clearInterval(cuentaRegresiva);
                    window.location.href = "logout.php"; // Cierra sesión
                }
            }, 1000);
        }

        function reiniciarTiempo() {
            clearTimeout(inactivo);
            clearInterval(cuentaRegresiva);
            document.getElementById("modal").style.display = "none"; // Oculta modal
            inactivo = setTimeout(mostrarModal, tiempoMaxInactivo);
        }

        function continuarSesion() {
            reiniciarTiempo(); // El usuario sigue activo
        }

        document.addEventListener("mousemove", reiniciarTiempo);
        document.addEventListener("keypress", reiniciarTiempo);

        reiniciarTiempo(); // Inicia el temporizador
    </script>
</body>

</html>