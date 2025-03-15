<?php
session_start();
require_once "privilegios.php"; // Incluye el sistema de privilegios

// Verificación adicional para asegurar que solo los administradores accedan
if (!isset($_SESSION['id']) || $_SESSION['idRol'] != ROL_ADMIN) {
    header("Location: acceso_denegado.php");
    exit();
}

// Variables necesarias para head.php
$nombre = $_SESSION['nombre'];
$idRol = $_SESSION['idRol'];
$ruta_base = '..'; // Para acceder correctamente a los recursos

// Evitar incluir la parte del body del head.php
ob_start();
include "../complementos/head.php";
$header_content = ob_get_clean();

// Extraer solo la parte del head de head.php
$head_only = substr($header_content, 0, strpos($header_content, '</head>') + 7);
?>

<!DOCTYPE html>
<html lang="es">
<?php echo $head_only; ?>
<!-- Estilos adicionales específicos para el panel de administrador -->
<style>
    .dashboard-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        color: #0056b3;
    }
    
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }
    
    .card-header {
        font-weight: bold;
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }
    
    .action-btn {
        border-radius: 20px;
        padding: 8px 20px;
        font-weight: 500;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 86, 179, 0.05);
    }
    
    .nav-tabs .nav-link {
        font-weight: 500;
    }
    
    .nav-tabs .nav-link.active {
        border-bottom: 3px solid #0056b3;
    }
    
    .section-title {
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 20px;
        font-weight: 700;
        color: #333;
    }
    
    .section-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background-color: #0056b3;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #2980b9 0%, #3498db 100%);
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
    }
    
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f39c12 0%, #f1c40f 100%);
    }
    
    .bg-gradient-danger {
        background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
    }
</style>

<body>
    <!-- Barra superior de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-gradient-primary shadow-sm mb-4">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="admin.php">
                <i class="fa-regular fa-gem fa-beat-fade me-2"></i>
                <span>Imperial Gems | Panel de Administrador</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php" target="_blank">
                            <i class="fas fa-home"></i> Ver Tienda
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($nombre); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Configuración</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="display-5 section-title">Panel de Administración</h2>
                <p class="lead text-muted">Bienvenido al panel de control para administradores. Aquí puedes gestionar usuarios, productos y ventas.</p>
            </div>
        </div>

        <!-- Tarjetas de estadísticas -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 stat-card h-100 bg-white">
                    <div class="card-body text-center">
                        <div class="dashboard-icon"><i class="fas fa-users"></i></div>
                        <h5 class="card-title fw-bold">Usuarios Registrados</h5>
                        <h2 class="display-5 fw-bold text-primary">150</h2>
                        <p class="text-muted">Usuarios activos en el sistema</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="#usuariosSection" class="btn btn-sm btn-outline-primary w-100 action-btn">
                            <i class="fas fa-angle-right"></i> Ver Detalles
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 stat-card h-100 bg-white">
                    <div class="card-body text-center">
                        <div class="dashboard-icon"><i class="fas fa-gem"></i></div>
                        <h5 class="card-title fw-bold">Productos</h5>
                        <h2 class="display-5 fw-bold text-warning">300</h2>
                        <p class="text-muted">Productos en inventario</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="#productosSection" class="btn btn-sm btn-outline-warning w-100 action-btn">
                            <i class="fas fa-angle-right"></i> Ver Detalles
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 stat-card h-100 bg-white">
                    <div class="card-body text-center">
                        <div class="dashboard-icon"><i class="fas fa-dollar-sign"></i></div>
                        <h5 class="card-title fw-bold">Ventas Mensuales</h5>
                        <h2 class="display-5 fw-bold text-success">25,300</h2>
                        <p class="text-muted">Ventas realizadas este mes</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="bodega_dasboard.php" class="btn btn-sm btn-outline-success w-100 action-btn">
                            <i class="fas fa-angle-right"></i> Ver Detalles
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 stat-card h-100 bg-white">
                    <div class="card-body text-center">
                        <div class="dashboard-icon"><i class="fas fa-shopping-cart"></i></div>
                        <h5 class="card-title fw-bold">Pedidos Pendientes</h5>
                        <h2 class="display-5 fw-bold text-danger">12</h2>
                        <p class="text-muted">Pedidos en espera de procesamiento</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="bodega_dasboard.php" class="btn btn-sm btn-outline-danger w-100 action-btn">
                            <i class="fas fa-angle-right"></i> Ver Detalles
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Usuarios -->
        <div class="card mb-4" id="usuariosSection">
            <div class="card-header">
                <i class="fas fa-users me-1"></i>
                Administración de Usuarios
                <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-plus"></i> Añadir Usuario
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?php
                    include "../confi/conexion.php"; // Conexión a la base de datos

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
                                <th>Acciones</th>
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
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal"
                                            onclick="editarUsuario(<?= htmlspecialchars($usuario['id']); ?>, '<?= htmlspecialchars($usuario['usuario']); ?>', '<?= htmlspecialchars($usuario['password']); ?>', '<?= htmlspecialchars($usuario['nombre']); ?>', '<?= htmlspecialchars($usuario['telefono']); ?>', '<?= htmlspecialchars($usuario['direccion']); ?>', '<?= htmlspecialchars($usuario['correo']); ?>', '<?= htmlspecialchars($usuario['Rol']); ?>')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminarUsuarioModal" 
                                            onclick="confirmarEliminar(<?= htmlspecialchars($usuario['id']); ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sección de Productos (simplificada) -->
        <div class="card mb-4" id="productosSection">
            <div class="card-header">
                <i class="fas fa-gem me-1"></i>
                Administración de Productos
                <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="fas fa-plus"></i> Añadir Producto
                </button>
            </div>
            <div class="card-body">
                <p class="lead text-center">Panel de administración de productos. Aquí podrás gestionar el inventario completo.</p>
                <!-- Aquí iría la tabla de productos similar a la de usuarios -->
            </div>
        </div>
    </div>

    <!-- Modal de Edición de Usuario -->
    <div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario de edición de usuario -->
                    <form action="admin.php" method="POST">
                        <input type="hidden" name="id" id="usuario_id">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="*****">
                            <small class="text-muted">Dejar en blanco para mantener la contraseña actual</small>
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

    <!-- Modal para Añadir Usuario -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Añadir Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para añadir usuario (similar al de edición) -->
                    <form action="admin.php" method="POST">
                        <!-- Campos de usuario similares al modal de edición -->
                        <div class="mb-3">
                            <label for="new_usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="new_usuario" name="new_usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <!-- Otros campos como nombre, teléfono, etc. -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Crear Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Añadir Producto -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Añadir Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para añadir producto -->
                    <form action="admin.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="product_description" name="product_description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="product_price" class="form-label">Precio</label>
                            <input type="number" class="form-control" id="product_price" name="product_price" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="product_stock" name="product_stock" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_category" class="form-label">Categoría</label>
                            <select class="form-select" id="product_category" name="product_category" required>
                                <option value="1">Anillos</option>
                                <option value="2">Collares</option>
                                <option value="3">Pulseras</option>
                                <option value="4">Aretes</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="product_image" class="form-label">Imagen del Producto</label>
                            <input type="file" class="form-control" id="product_image" name="product_image" accept="image/*" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Añadir Producto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para confirmar eliminación de usuario -->
    <div class="modal fade" id="eliminarUsuarioModal" tabindex="-1" aria-labelledby="eliminarUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="eliminarUsuarioModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.</p>
                    <form id="formEliminarUsuario" action="admin.php" method="POST">
                        <input type="hidden" name="eliminar_id" id="eliminar_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="eliminarUsuario()">Eliminar</button>
                </div>
            </div>
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
        // Función para cargar los datos del usuario en el modal de edición
        function editarUsuario(id, usuario, password, nombre, telefono, direccion, correo, rol) {
            document.getElementById('usuario_id').value = id;
            document.getElementById('usuario').value = usuario;
            document.getElementById('password').value = ''; // Campo de contraseña vacío
            document.getElementById('password').setAttribute('placeholder', '*****');
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

        // Función para preparar la eliminación de un usuario
        function confirmarEliminar(id) {
            document.getElementById('eliminar_id').value = id;
        }

        // Función para enviar el formulario de eliminación
        function eliminarUsuario() {
            document.getElementById('formEliminarUsuario').submit();
        }

        // Inicializar DataTables
        window.addEventListener('DOMContentLoaded', event => {
            const datatablesSimple = document.getElementById('datatablesSimple');
            if (datatablesSimple) {
                new simpleDatatables.DataTable(datatablesSimple);
            }
        });
    </script>
</body>
</html> 