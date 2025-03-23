<?php
session_start();
require_once "privilegios.php"; // Incluye el sistema de privilegios

// Verificación para asegurar que solo los usuarios autorizados accedan
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$nombre = $_SESSION['nombre'];
$idRol = $_SESSION['idRol'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cuenta - Imperial Gems</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <script src="https://kit.fontawesome.com/45b2b3afef.js" crossorigin="anonymous"></script>
    <?php include '../complementos/head.php'; ?>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Bienvenido, <?php echo $nombre; ?></h3>
                    </div>
                    <div class="card-body">
                        <p class="lead">Bienvenido a tu cuenta en Imperial Gems. Aquí puedes gestionar tus pedidos, ver tu historial de compras y actualizar tu información personal.</p>
                        <p>Para regresar a la tienda principal, haz clic en el botón de abajo.</p>
                        <a href="../index.php" class="btn btn-primary">
                            <i class="fas fa-store"></i> Ir a la Tienda
                        </a>
                        <a href="../confi/logout.php" class="btn btn-danger float-right">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pestañas de navegación para la cuenta -->
        <ul class="nav nav-tabs" id="clientTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pedidos-tab" data-toggle="tab" href="#pedidos" role="tab" aria-controls="pedidos" aria-selected="true">
                    <i class="fas fa-shopping-bag"></i> Mis Pedidos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="perfil-tab" data-toggle="tab" href="#perfil" role="tab" aria-controls="perfil" aria-selected="false">
                    <i class="fas fa-user-circle"></i> Mi Perfil
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="favoritos-tab" data-toggle="tab" href="#favoritos" role="tab" aria-controls="favoritos" aria-selected="false">
                    <i class="fas fa-heart"></i> Favoritos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="direcciones-tab" data-toggle="tab" href="#direcciones" role="tab" aria-controls="direcciones" aria-selected="false">
                    <i class="fas fa-map-marker-alt"></i> Direcciones
                </a>
            </li>
        </ul>

        <div class="tab-content" id="clientTabContent">
            <!-- Pestaña de Pedidos -->
            <div class="tab-pane fade show active" id="pedidos" role="tabpanel" aria-labelledby="pedidos-tab">
                <div class="card border-top-0 rounded-0 rounded-bottom">
                    <div class="card-body">
                        <h4 class="mb-4">Mis Pedidos</h4>
                        
                        <?php
                        // Aquí se cargarian los pedidos del cliente desde la base de datos
                        // Por ahora mostramos datos de ejemplo
                        $tienePedidos = true; // Cambiar a false si no hay pedidos
                        
                        if ($tienePedidos) {
                        ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Nº Pedido</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Total</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>#ORD-2024-001</td>
                                            <td>15/03/2024</td>
                                            <td><span class="badge badge-success">Entregado</span></td>
                                            <td>L 25,000.00</td>
                                            <td>
                                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#detallesPedidoModal1">
                                                    <i class="fas fa-eye"></i> Ver
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>#ORD-2024-002</td>
                                            <td>10/04/2024</td>
                                            <td><span class="badge badge-warning text-dark">En camino</span></td>
                                            <td>L 12,500.00</td>
                                            <td>
                                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#detallesPedidoModal2">
                                                    <i class="fas fa-eye"></i> Ver
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="alert alert-info text-center">
                                <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                                <p>No tienes pedidos realizados todavía.</p>
                                <a href="../index.php" class="btn btn-primary mt-2">Ir de compras</a>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Pestaña de Perfil -->
            <div class="tab-pane fade" id="perfil" role="tabpanel" aria-labelledby="perfil-tab">
                <div class="card border-top-0 rounded-0 rounded-bottom">
                    <div class="card-body">
                        <h4 class="mb-4">Mi Perfil</h4>
                        
                        <?php
                        // Consulta para obtener los datos del usuario actual
                        include "../confi/conexion.php";
                        
                        $id_usuario = $_SESSION['id'];
                        $query = "SELECT * FROM usuario WHERE id = :id";
                        
                        try {
                            $stmt = $pdo->prepare($query);
                            $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
                            $stmt->execute();
                            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            echo "Error al obtener los datos: " . $e->getMessage();
                            $usuario = null;
                        }
                        
                        if ($usuario) {
                        ?>
                            <form id="formPerfil">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="usuario">Usuario</label>
                                            <input type="text" class="form-control" id="usuario" value="<?php echo htmlspecialchars($usuario['usuario']); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre">Nombre Completo</label>
                                            <input type="text" class="form-control" id="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="correo">Correo Electrónico</label>
                                            <input type="email" class="form-control" id="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="telefono">Teléfono</label>
                                            <input type="text" class="form-control" id="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <textarea class="form-control" id="direccion" rows="2"><?php echo htmlspecialchars($usuario['direccion']); ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="password">Nueva Contraseña</label>
                                    <input type="password" class="form-control" id="password" placeholder="Dejar en blanco para mantener la actual">
                                    <small class="form-text text-muted">Mínimo 6 caracteres</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="confirmPassword">Confirmar Nueva Contraseña</label>
                                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirmar nueva contraseña">
                                </div>
                                
                                <button type="button" class="btn btn-primary" onclick="actualizarPerfil()">
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>
                            </form>
                        <?php
                        } else {
                        ?>
                            <div class="alert alert-danger">
                                No se pudieron cargar tus datos. Por favor, intenta nuevamente más tarde.
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Pestaña de Favoritos -->
            <div class="tab-pane fade" id="favoritos" role="tabpanel" aria-labelledby="favoritos-tab">
                <div class="card border-top-0 rounded-0 rounded-bottom">
                    <div class="card-body">
                        <h4 class="mb-4">Mis Productos Favoritos</h4>
                        
                        <!-- Aquí irían los productos favoritos -->
                        <div class="row">
                            <!-- Producto Favorito 1 -->
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <img src="../product/1.jpg" class="card-img-top" alt="Anillo de Diamante" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">Anillo de Diamante</h5>
                                        <p class="card-text">Hermoso anillo con diamante de 1 quilate.</p>
                                        <p class="text-primary font-weight-bold">L20,000.00</p>
                                    </div>
                                    <div class="card-footer d-flex justify-content-between">
                                        <a href="../index.php" class="btn btn-primary">
                                            <i class="fas fa-shopping-cart"></i> Comprar
                                        </a>
                                        <button class="btn btn-danger" onclick="eliminarFavorito(1)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Producto Favorito 2 -->
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <img src="../product/4.jpg" class="card-img-top" alt="Collar de Oro" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">Collar de Oro</h5>
                                        <p class="card-text">Elegante collar de oro de 18 quilates.</p>
                                        <p class="text-primary font-weight-bold">L15,000.00</p>
                                    </div>
                                    <div class="card-footer d-flex justify-content-between">
                                        <a href="../index.php" class="btn btn-primary">
                                            <i class="fas fa-shopping-cart"></i> Comprar
                                        </a>
                                        <button class="btn btn-danger" onclick="eliminarFavorito(2)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pestaña de Direcciones -->
            <div class="tab-pane fade" id="direcciones" role="tabpanel" aria-labelledby="direcciones-tab">
                <div class="card border-top-0 rounded-0 rounded-bottom">
                    <div class="card-body">
                        <h4 class="mb-4">Mis Direcciones</h4>
                        <p class="text-muted mb-4">Gestiona tus direcciones de envío para tus compras.</p>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card border-primary h-100">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Dirección Principal</h5>
                                    </div>
                                    <div class="card-body">
                                        <address>
                                            <strong><?php echo $nombre; ?></strong><br>
                                            <?php echo $usuario['direccion']; ?><br>
                                            <abbr title="Teléfono">Tel:</abbr> <?php echo $usuario['telefono']; ?>
                                        </address>
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editarDireccionModal">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card h-100 border-dashed">
                                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                        <i class="fas fa-plus-circle fa-3x text-muted mb-3"></i>
                                        <h5>Añadir Nueva Dirección</h5>
                                        <button class="btn btn-outline-secondary mt-3" data-toggle="modal" data-target="#nuevaDireccionModal">
                                            <i class="fas fa-plus"></i> Añadir
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Detalles de Pedido 1 -->
    <div class="modal fade" id="detallesPedidoModal1" tabindex="-1" aria-labelledby="detallesPedidoModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detallesPedidoModalLabel1">Detalles del Pedido #ORD-2024-001</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Fecha:</strong> 15/03/2024</p>
                            <p><strong>Estado:</strong> <span class="badge badge-success">Entregado</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Método de Pago:</strong> Tarjeta de Crédito</p>
                            <p><strong>Total:</strong> L 25,000.00</p>
                        </div>
                    </div>
                    
                    <h6>Productos</h6>
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Anillo de Diamante</td>
                                <td>1</td>
                                <td>L 20,000.00</td>
                                <td>L 20,000.00</td>
                            </tr>
                            <tr>
                                <td>Aretes de Plata</td>
                                <td>2</td>
                                <td>L 2,500.00</td>
                                <td>L 5,000.00</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                <td><strong>L 25,000.00</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                    
                    <h6>Dirección de Envío</h6>
                    <address>
                        <strong><?php echo $nombre; ?></strong><br>
                        <?php echo $usuario['direccion']; ?><br>
                        <abbr title="Teléfono">Tel:</abbr> <?php echo $usuario['telefono']; ?>
                    </address>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Detalles de Pedido 2 -->
    <div class="modal fade" id="detallesPedidoModal2" tabindex="-1" aria-labelledby="detallesPedidoModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detallesPedidoModalLabel2">Detalles del Pedido #ORD-2024-002</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Fecha:</strong> 10/04/2024</p>
                            <p><strong>Estado:</strong> <span class="badge badge-warning text-dark">En camino</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Método de Pago:</strong> Efectivo</p>
                            <p><strong>Total:</strong> L 12,500.00</p>
                        </div>
                    </div>
                    
                    <h6>Productos</h6>
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Collar de Oro</td>
                                <td>1</td>
                                <td>L 12,500.00</td>
                                <td>L 12,500.00</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                <td><strong>L 12,500.00</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                    
                    <h6>Dirección de Envío</h6>
                    <address>
                        <strong><?php echo $nombre; ?></strong><br>
                        <?php echo $usuario['direccion']; ?><br>
                        <abbr title="Teléfono">Tel:</abbr> <?php echo $usuario['telefono']; ?>
                    </address>
                    
                    <div class="alert alert-info">
                        <h6><i class="fas fa-truck"></i> Información de Envío</h6>
                        <p class="mb-0">Tu pedido está en camino. Número de seguimiento: <strong>TRC-456789</strong></p>
                        <p class="mb-0">Fecha estimada de entrega: <strong>15/04/2024</strong></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Dirección -->
    <div class="modal fade" id="editarDireccionModal" tabindex="-1" aria-labelledby="editarDireccionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarDireccionModalLabel">Editar Dirección</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditarDireccion">
                        <div class="form-group">
                            <label for="nombreDireccion">Nombre Completo</label>
                            <input type="text" class="form-control" id="nombreDireccion" value="<?php echo $nombre; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="calleDireccion">Dirección</label>
                            <textarea class="form-control" id="calleDireccion" rows="2"><?php echo $usuario['direccion']; ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ciudadDireccion">Ciudad</label>
                                    <input type="text" class="form-control" id="ciudadDireccion" value="Tegucigalpa">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="departamentoDireccion">Departamento</label>
                                    <input type="text" class="form-control" id="departamentoDireccion" value="Francisco Morazán">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="telefonoDireccion">Teléfono</label>
                            <input type="text" class="form-control" id="telefonoDireccion" value="<?php echo $usuario['telefono']; ?>">
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="direccionPrincipal" checked>
                                <label class="custom-control-label" for="direccionPrincipal">Establecer como dirección principal</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarDireccion()">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Nueva Dirección -->
    <div class="modal fade" id="nuevaDireccionModal" tabindex="-1" aria-labelledby="nuevaDireccionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevaDireccionModalLabel">Añadir Nueva Dirección</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formNuevaDireccion">
                        <div class="form-group">
                            <label for="nombreNuevaDireccion">Nombre Completo</label>
                            <input type="text" class="form-control" id="nombreNuevaDireccion" placeholder="Ingrese el nombre">
                        </div>
                        
                        <div class="form-group">
                            <label for="calleNuevaDireccion">Dirección</label>
                            <textarea class="form-control" id="calleNuevaDireccion" rows="2" placeholder="Ingrese la dirección completa"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ciudadNuevaDireccion">Ciudad</label>
                                    <input type="text" class="form-control" id="ciudadNuevaDireccion" placeholder="Ciudad">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="departamentoNuevaDireccion">Departamento</label>
                                    <input type="text" class="form-control" id="departamentoNuevaDireccion" placeholder="Departamento">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="telefonoNuevaDireccion">Teléfono</label>
                            <input type="text" class="form-control" id="telefonoNuevaDireccion" placeholder="Teléfono de contacto">
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="nuevaDireccionPrincipal">
                                <label class="custom-control-label" for="nuevaDireccionPrincipal">Establecer como dirección principal</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarNuevaDireccion()">Guardar Dirección</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        // Función para actualizar el perfil del usuario
        function actualizarPerfil() {
            const nombre = document.getElementById('nombre').value;
            const correo = document.getElementById('correo').value;
            const telefono = document.getElementById('telefono').value;
            const direccion = document.getElementById('direccion').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            // Validación básica
            if (!nombre || !correo || !telefono || !direccion) {
                alert("Por favor complete todos los campos obligatorios");
                return;
            }
            
            // Validar que las contraseñas coincidan si se está cambiando
            if (password) {
                if (password.length < 6) {
                    alert("La contraseña debe tener al menos 6 caracteres");
                    return;
                }
                
                if (password !== confirmPassword) {
                    alert("Las contraseñas no coinciden");
                    return;
                }
            }
            
            // Aquí se enviarían los datos al servidor para actualizar
            // Por ahora, sólo mostramos un mensaje de éxito
            alert("Perfil actualizado correctamente");
        }
        
        // Función para eliminar un producto de favoritos
        function eliminarFavorito(id) {
            // Aquí se enviaría la solicitud al servidor
            alert("Producto eliminado de favoritos");
            // Para este ejemplo, simplemente recargamos la página
            location.reload();
        }
        
        // Función para guardar cambios en una dirección
        function guardarDireccion() {
            alert("Dirección actualizada correctamente");
            $('#editarDireccionModal').modal('hide');
        }
        
        // Función para guardar una nueva dirección
        function guardarNuevaDireccion() {
            const nombre = document.getElementById('nombreNuevaDireccion').value;
            const direccion = document.getElementById('calleNuevaDireccion').value;
            const ciudad = document.getElementById('ciudadNuevaDireccion').value;
            const departamento = document.getElementById('departamentoNuevaDireccion').value;
            const telefono = document.getElementById('telefonoNuevaDireccion').value;
            
            if (!nombre || !direccion || !ciudad || !departamento || !telefono) {
                alert("Por favor complete todos los campos");
                return;
            }
            
            alert("Nueva dirección añadida correctamente");
            $('#nuevaDireccionModal').modal('hide');
            
            // En una implementación real, aquí recargaríamos la sección de direcciones
            // para mostrar la nueva dirección añadida
        }
        
        // Estilos adicionales (se podría mover a un archivo CSS)
        document.addEventListener('DOMContentLoaded', function() {
            const style = document.createElement('style');
            style.innerHTML = `
                .border-dashed {
                    border: 2px dashed #dee2e6;
                    border-radius: 0.25rem;
                    height: 100%;
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>

<?php include '../complementos/footer.php'; ?>
</html> 