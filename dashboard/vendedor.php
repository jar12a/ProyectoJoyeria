<?php
session_start();
require_once "privilegios.php"; // Incluye el sistema de privilegios

// Verificación adicional para asegurar que solo los vendedores y administradores accedan
if (!isset($_SESSION['id']) || ($_SESSION['idRol'] != ROL_VENDEDOR && $_SESSION['idRol'] != ROL_ADMIN)) {
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

// Procesamiento de formularios (por ejemplo, para actualizar usuarios)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    include "../confi/conexion.php";
    
    $id = $_POST['id'];
    $usuario = $_POST['usuario'];
    $nombre_usuario = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    
    // Convertir el rol de texto a su ID correspondiente
    $rol_texto = $_POST['rol'];
    $idRol_nuevo = 3; // Default: Cliente
    if ($rol_texto == 'Administrador') {
        $idRol_nuevo = 1;
    } else if ($rol_texto == 'Vendedor') {
        $idRol_nuevo = 2;
    }
    
    // Verificar si hay una nueva contraseña
    if (!empty($_POST['password'])) {
        $password = sha1($_POST['password']);
        $sql = "UPDATE usuario SET usuario=?, password=?, nombre=?, telefono=?, direccion=?, correo=?, idRol=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$usuario, $password, $nombre_usuario, $telefono, $direccion, $correo, $idRol_nuevo, $id]);
    } else {
        // Actualizar todo excepto la contraseña
        $sql = "UPDATE usuario SET usuario=?, nombre=?, telefono=?, direccion=?, correo=?, idRol=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$usuario, $nombre_usuario, $telefono, $direccion, $correo, $idRol_nuevo, $id]);
    }
    
    // Mensaje de éxito (se podría mostrar con un modal)
    $actualizado = true;
}
?>

<!DOCTYPE html>
<html lang="es">
<?php echo $head_only; ?>
<!-- Estilos adicionales específicos para el panel de vendedor -->
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
            <a class="navbar-brand d-flex align-items-center" href="vendedor.php">
                <i class="fa-regular fa-gem fa-beat-fade me-2"></i>
                <span>Imperial Gems | Panel de Vendedor</span>
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
                    <?php if ($_SESSION['idRol'] == ROL_ADMIN): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">
                            <i class="fas fa-user-shield"></i> Panel Admin
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($nombre); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Configuración</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../confi/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="display-5 section-title">Dashboard de Ventas</h2>
                <p class="lead text-muted">Bienvenido al panel de control para vendedores. Aquí puedes gestionar ventas, clientes y productos.</p>
            </div>
        </div>

        <!-- Tarjetas de estadísticas -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 stat-card h-100 bg-white">
                    <div class="card-body text-center">
                        <div class="dashboard-icon"><i class="fas fa-shopping-cart"></i></div>
                        <h5 class="card-title fw-bold">Ventas Hoy</h5>
                        <h2 class="display-5 fw-bold text-primary">8</h2>
                        <p class="text-muted">Valor: L 45,600</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="#ventasSection" class="btn btn-sm btn-outline-primary w-100 action-btn">
                            <i class="fas fa-chart-line me-1"></i> Ver Detalles
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 stat-card h-100 bg-white">
                    <div class="card-body text-center">
                        <div class="dashboard-icon"><i class="fas fa-calendar-alt"></i></div>
                        <h5 class="card-title fw-bold">Ventas del Mes</h5>
                        <h2 class="display-5 fw-bold text-success">152</h2>
                        <p class="text-muted">Valor: L 893,450</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="#ventasMensualesSection" class="btn btn-sm btn-outline-success w-100 action-btn">
                            <i class="fas fa-chart-bar me-1"></i> Ver Detalles
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 stat-card h-100 bg-white">
                    <div class="card-body text-center">
                        <div class="dashboard-icon"><i class="fas fa-users"></i></div>
                        <h5 class="card-title fw-bold">Total Clientes</h5>
                        <h2 class="display-5 fw-bold text-warning">48</h2>
                        <p class="text-muted">+3 este mes</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="#clientesSection" class="btn btn-sm btn-outline-warning w-100 action-btn">
                            <i class="fas fa-user-friends me-1"></i> Ver Clientes
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 stat-card h-100 bg-white">
                    <div class="card-body text-center">
                        <div class="dashboard-icon"><i class="fas fa-exclamation-triangle"></i></div>
                        <h5 class="card-title fw-bold">Bajo Stock</h5>
                        <h2 class="display-5 fw-bold text-danger">5</h2>
                        <p class="text-muted">Requiere atención</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="#stockBajoSection" class="btn btn-sm btn-outline-danger w-100 action-btn">
                            <i class="fas fa-boxes me-1"></i> Ver Productos
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navegación por pestañas -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <ul class="nav nav-tabs card-header-tabs" id="vendorTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="nueva-venta-tab" data-bs-toggle="tab" data-bs-target="#nueva-venta" type="button" role="tab">
                            <i class="fas fa-cash-register me-1"></i> Nueva Venta
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="historial-tab" data-bs-toggle="tab" data-bs-target="#historial" type="button" role="tab">
                            <i class="fas fa-history me-1"></i> Historial de Ventas
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="productos-tab" data-bs-toggle="tab" data-bs-target="#productos" type="button" role="tab">
                            <i class="fas fa-gem me-1"></i> Catálogo
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="clientes-tab" data-bs-toggle="tab" data-bs-target="#clientes" type="button" role="tab">
                            <i class="fas fa-users me-1"></i> Clientes
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="vendorTabContent">
                    <!-- Pestaña de Nueva Venta -->
                    <div class="tab-pane fade show active" id="nueva-venta" role="tabpanel" aria-labelledby="nueva-venta-tab">
                        <h4 class="mb-4" id="nuevaVentaSection">Registrar Nueva Venta</h4>
                        <form id="ventaForm">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="clienteSelect" class="form-label">Cliente</label>
                                    <div class="input-group">
                                        <select class="form-select" id="clienteSelect" required>
                                            <option value="" selected disabled>Seleccione un cliente</option>
                                            <option value="1">Juan Pérez</option>
                                            <option value="2">María González</option>
                                            <option value="3">Carlos Rodríguez</option>
                                        </select>
                                        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#addClienteModal">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="fechaVenta" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" id="fechaVenta" value="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="productoSelect" class="form-label">Añadir Producto</label>
                                    <div class="input-group">
                                        <select class="form-select" id="productoSelect">
                                            <option value="" selected disabled>Seleccione un producto</option>
                                            <option value="1">Anillo de Diamante - L20,000</option>
                                            <option value="2">Collar de Oro - L15,000</option>
                                            <option value="3">Pulsera de Plata - L3,500</option>
                                        </select>
                                        <input type="number" class="form-control" id="cantidadProducto" min="1" value="1" style="max-width: 100px;">
                                        <button class="btn btn-primary" type="button" onclick="agregarProducto()">
                                            <i class="fas fa-plus"></i> Añadir
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mb-3">
                                <table class="table table-bordered table-hover" id="tablaProductos">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio Unitario</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Aquí se agregarán dinámicamente los productos -->
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-end">Total:</th>
                                            <th id="totalVenta">L0.00</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="tipoVenta" class="form-label">Método de Pago</label>
                                    <select class="form-select" id="tipoVenta" required>
                                        <option value="efectivo">Efectivo</option>
                                        <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                                        <option value="transferencia">Transferencia Bancaria</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea class="form-control" id="observaciones" rows="1"></textarea>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-outline-secondary me-md-2">
                                    <i class="fas fa-undo"></i> Limpiar
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Registrar Venta
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Pestaña de Historial de Ventas -->
                    <div class="tab-pane fade" id="historial" role="tabpanel" aria-labelledby="historial-tab">
                        <h4 class="mb-4" id="ventasSection">Historial de Ventas</h4>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="fechaDesde" class="form-label">Desde</label>
                                <input type="date" class="form-control" id="fechaDesde">
                            </div>
                            <div class="col-md-4">
                                <label for="fechaHasta" class="form-label">Hasta</label>
                                <input type="date" class="form-control" id="fechaHasta">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="button" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> Filtrar
                                </button>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha</th>
                                        <th>Cliente</th>
                                        <th>Productos</th>
                                        <th>Total</th>
                                        <th>Método de Pago</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>V0001</td>
                                        <td>2024-04-18</td>
                                        <td>Juan Pérez</td>
                                        <td>2</td>
                                        <td>L23,500.00</td>
                                        <td>Tarjeta</td>
                                        <td>
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detalleVentaModal">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-secondary">
                                                <i class="fas fa-print"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>V0002</td>
                                        <td>2024-04-18</td>
                                        <td>María González</td>
                                        <td>1</td>
                                        <td>L15,000.00</td>
                                        <td>Efectivo</td>
                                        <td>
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detalleVentaModal">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-secondary">
                                                <i class="fas fa-print"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>V0003</td>
                                        <td>2024-04-17</td>
                                        <td>Carlos Rodríguez</td>
                                        <td>3</td>
                                        <td>L32,500.00</td>
                                        <td>Transferencia</td>
                                        <td>
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detalleVentaModal">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-secondary">
                                                <i class="fas fa-print"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pestaña de Productos -->
                    <div class="tab-pane fade" id="productos" role="tabpanel" aria-labelledby="productos-tab">
                        <h4 class="mb-4" id="productosSection">Catálogo de Productos</h4>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Buscar producto...">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-secondary">
                                        <i class="fas fa-filter"></i> Filtrar
                                    </button>
                                    <button type="button" class="btn btn-outline-primary">
                                        <i class="fas fa-sort"></i> Ordenar
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 stat-card">
                                    <img src="../product/1.jpg" class="card-img-top" alt="Anillo de Diamante" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">Anillo de Diamante</h5>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-success">En stock: 8</span>
                                            <span class="text-primary fw-bold">L20,000.00</span>
                                        </div>
                                        <p class="card-text">Hermoso anillo con diamante de 1 quilate en oro de 18k.</p>
                                    </div>
                                    <div class="card-footer bg-white d-flex justify-content-between">
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> Detalles
                                        </button>
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fas fa-shopping-cart"></i> Vender
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 stat-card">
                                    <img src="../product/4.jpg" class="card-img-top" alt="Collar de Oro" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">Collar de Oro</h5>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-success">En stock: 5</span>
                                            <span class="text-primary fw-bold">L15,000.00</span>
                                        </div>
                                        <p class="card-text">Elegante collar de oro de 18 quilates con diseño moderno.</p>
                                    </div>
                                    <div class="card-footer bg-white d-flex justify-content-between">
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> Detalles
                                        </button>
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fas fa-shopping-cart"></i> Vender
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 stat-card">
                                    <img src="../product/5.jpg" class="card-img-top" alt="Pulsera de Plata" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">Pulsera de Plata</h5>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-danger">Bajo stock: 2</span>
                                            <span class="text-primary fw-bold">L3,500.00</span>
                                        </div>
                                        <p class="card-text">Hermosa pulsera de plata 925 con acabados a mano.</p>
                                    </div>
                                    <div class="card-footer bg-white d-flex justify-content-between">
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pestaña de Clientes -->
                    <div class="tab-pane fade" id="clientes" role="tabpanel" aria-labelledby="clientes-tab">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 id="clientesSection">Gestión de Clientes</h4>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClienteModal">
                                <i class="fas fa-user-plus"></i> Nuevo Cliente
                            </button>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Teléfono</th>
                                        <th>Correo</th>
                                        <th>Dirección</th>
                                        <th>Total Compras</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Juan Pérez</td>
                                        <td>9789-4567</td>
                                        <td>juan@example.com</td>
                                        <td>Col. Kennedy, Tegucigalpa</td>
                                        <td>L23,500.00</td>
                                        <td>
                                            <button class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>María González</td>
                                        <td>9876-5432</td>
                                        <td>maria@example.com</td>
                                        <td>Col. Palmira, Tegucigalpa</td>
                                        <td>L15,000.00</td>
                                        <td>
                                            <button class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Carlos Rodríguez</td>
                                        <td>9912-3456</td>
                                        <td>carlos@example.com</td>
                                        <td>Col. Miraflores, Tegucigalpa</td>
                                        <td>L32,500.00</td>
                                        <td>
                                            <button class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Agregar Cliente -->
    <div class="modal fade" id="addClienteModal" tabindex="-1" aria-labelledby="addClienteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClienteModalLabel">Agregar Nuevo Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formNuevoCliente">
                        <div class="mb-3">
                            <label for="nombreCliente" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="nombreCliente" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefonoCliente" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefonoCliente" required>
                        </div>
                        <div class="mb-3">
                            <label for="correoCliente" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correoCliente">
                        </div>
                        <div class="mb-3">
                            <label for="direccionCliente" class="form-label">Dirección</label>
                            <textarea class="form-control" id="direccionCliente" rows="2"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Guardar Cliente</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detalle de Venta -->
    <div class="modal fade" id="detalleVentaModal" tabindex="-1" aria-labelledby="detalleVentaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalleVentaModalLabel">Detalle de Venta #V0001</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Cliente:</strong> Juan Pérez</p>
                            <p><strong>Fecha:</strong> 18/04/2024</p>
                            <p><strong>Método de Pago:</strong> Tarjeta de Crédito</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p><strong>Vendedor:</strong> <?php echo $nombre; ?></p>
                            <p><strong>ID Venta:</strong> V0001</p>
                            <p><strong>Estado:</strong> <span class="badge bg-success">Completada</span></p>
                        </div>
                    </div>
                    
                    <h6 class="fw-bold">Productos</h6>
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Anillo de Diamante</td>
                                    <td>L20,000.00</td>
                                    <td>1</td>
                                    <td>L20,000.00</td>
                                </tr>
                                <tr>
                                    <td>Pulsera de Plata</td>
                                    <td>L3,500.00</td>
                                    <td>1</td>
                                    <td>L3,500.00</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th>L23,500.00</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="fw-bold">Observaciones:</h6>
                        <p>Regalo de aniversario. Cliente solicitó envolver los productos para regalo.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-4 bg-light mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <span class="text-muted">© 2024 Imperial Gems - Todos los derechos reservados</span>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <span class="text-muted">Desarrollado por Imperial Gems Team</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para agregar productos dinámicamente a la tabla
        function agregarProducto() {
            const productoSelect = document.getElementById('productoSelect');
            const cantidadProducto = document.getElementById('cantidadProducto');
            
            if (productoSelect.value === '') {
                alert('Por favor seleccione un producto');
                return;
            }
            
            const productoOption = productoSelect.options[productoSelect.selectedIndex];
            const productoNombre = productoOption.text.split(' - ')[0];
            const productoPrecio = productoOption.text.split(' - ')[1].replace('L', '');
            const cantidad = cantidadProducto.value;
            const subtotal = parseFloat(productoPrecio.replace(',', '')) * parseInt(cantidad);
            
            const tablaProductos = document.getElementById('tablaProductos').getElementsByTagName('tbody')[0];
            const fila = tablaProductos.insertRow();
            
            fila.innerHTML = `
                <td>${productoNombre}</td>
                <td>L${parseFloat(productoPrecio.replace(',', '')).toFixed(2)}</td>
                <td>${cantidad}</td>
                <td>L${subtotal.toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="eliminarFila(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            
            // Limpiar selección
            productoSelect.selectedIndex = 0;
            cantidadProducto.value = 1;
            
            // Actualizar total
            actualizarTotal();
        }
        
        // Función para eliminar una fila de producto
        function eliminarFila(btn) {
            const fila = btn.closest('tr');
            fila.remove();
            actualizarTotal();
        }
        
        // Función para actualizar el total de la venta
        function actualizarTotal() {
            const tabla = document.getElementById('tablaProductos');
            const filas = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            let total = 0;
            
            for (let i = 0; i < filas.length; i++) {
                const subtotal = filas[i].getElementsByTagName('td')[3].textContent;
                total += parseFloat(subtotal.replace('L', ''));
            }
            
            document.getElementById('totalVenta').textContent = `L${total.toFixed(2)}`;
        }
        
        // Envío del formulario de venta
        document.getElementById('ventaForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const tablaProductos = document.getElementById('tablaProductos').getElementsByTagName('tbody')[0];
            if (tablaProductos.getElementsByTagName('tr').length === 0) {
                alert('Debe agregar al menos un producto a la venta');
                return;
            }
            
            // Aquí iría el código para enviar los datos al servidor
            // Por ahora, solo mostraremos un mensaje de éxito
            alert('Venta registrada correctamente');
            
            // Simular redirección o recarga
            setTimeout(function() {
                location.reload();
            }, 1000);
        });
        
        // Inicialización de componentes cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar DataTables (si es necesario)
            
            // Activar el primer tab al cargar la página
            const triggerTabList = [].slice.call(document.querySelectorAll('#vendorTabs button'));
            triggerTabList.forEach(function (triggerEl) {
                triggerEl.addEventListener('click', function (event) {
                    event.preventDefault();
                    
                    // Activar el tab seleccionado
                    const tabTarget = document.querySelector(this.getAttribute('data-bs-target'));
                    const tabList = [].slice.call(document.querySelectorAll('.tab-pane'));
                    
                    tabList.forEach(function(tab) {
                        tab.classList.remove('show', 'active');
                    });
                    
                    tabTarget.classList.add('show', 'active');
                    
                    // Actualizar clase activa en los botones
                    triggerTabList.forEach(function(el) {
                        el.classList.remove('active');
                    });
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>
</html> 