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

    
    

    </div>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="../index.php">Imperial Gems</a>
        <!-- Sidebar Toggle para mostrar el menú principal-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

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
                    <li><a class="dropdown-item" href="../confi/logout.php">Salir</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <?php 
    include "../confi/cierre_sesion.php";
    ?>