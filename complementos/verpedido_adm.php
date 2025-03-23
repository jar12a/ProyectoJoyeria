<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../confi/conexion.php'; // Asegúrate de que este archivo existe y define la variable $pdo

// Obtener el número de filas a mostrar por página
$rows_per_page = isset($_GET['rows_per_page']) ? (int)$_GET['rows_per_page'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $rows_per_page;

// Obtener los filtros de búsqueda
$search_cliente = isset($_GET['search_cliente']) ? $_GET['search_cliente'] : '';
$search_fecha = isset($_GET['search_fecha']) ? $_GET['search_fecha'] : '';

// Construir la consulta SQL con los filtros
$query_pedidos = "SELECT p.ID_Pedido, p.Fecha, u.nombre AS Cliente, u.direccion, u.telefono 
                  FROM pedido p 
                  JOIN usuario u ON p.ID_usuario = u.id 
                  WHERE 1=1";

if ($search_cliente) {
    $query_pedidos .= " AND u.nombre LIKE :search_cliente";
}
if ($search_fecha) {
    $query_pedidos .= " AND DATE(p.Fecha) = :search_fecha";
}

$query_pedidos .= " LIMIT :rows_per_page OFFSET :offset";
$stmt_pedidos = $pdo->prepare($query_pedidos);

if ($search_cliente) {
    $stmt_pedidos->bindValue(':search_cliente', '%' . $search_cliente . '%', PDO::PARAM_STR);
}
if ($search_fecha) {
    $stmt_pedidos->bindValue(':search_fecha', $search_fecha, PDO::PARAM_STR);
}
$stmt_pedidos->bindValue(':rows_per_page', $rows_per_page, PDO::PARAM_INT);
$stmt_pedidos->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt_pedidos->execute();
$pedidos = $stmt_pedidos->fetchAll(PDO::FETCH_ASSOC);

// Obtener el total de pedidos para la paginación
$query_total_pedidos = "SELECT COUNT(*) FROM pedido p JOIN usuario u ON p.ID_usuario = u.id WHERE 1=1";
if ($search_cliente) {
    $query_total_pedidos .= " AND u.nombre LIKE :search_cliente";
}
if ($search_fecha) {
    $query_total_pedidos .= " AND DATE(p.Fecha) = :search_fecha";
}
$stmt_total_pedidos = $pdo->prepare($query_total_pedidos);
if ($search_cliente) {
    $stmt_total_pedidos->bindValue(':search_cliente', '%' . $search_cliente . '%', PDO::PARAM_STR);
}
if ($search_fecha) {
    $stmt_total_pedidos->bindValue(':search_fecha', $search_fecha, PDO::PARAM_STR);
}
$stmt_total_pedidos->execute();
$total_pedidos = $stmt_total_pedidos->fetchColumn();
$total_pages = ceil($total_pedidos / $rows_per_page);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Pedidos - Imperial Gems</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Registro de Pedidos</h2>
        <div class="mb-3">
            <form method="GET" action="../complementos/verpedido_adm.php" class="form-inline">
                <label for="rows_per_page" class="mr-2">Filas por página:</label>
                <select name="rows_per_page" id="rows_per_page" class="form-control mr-2" onchange="this.form.submit()">
                    <option value="5" <?php if ($rows_per_page == 5) echo 'selected'; ?>>5</option>
                    <option value="10" <?php if ($rows_per_page == 10) echo 'selected'; ?>>10</option>
                    <option value="20" <?php if ($rows_per_page == 20) echo 'selected'; ?>>20</option>
                </select>
                <input type="text" name="search_cliente" class="form-control mr-2" placeholder="Buscar por cliente" value="<?php echo htmlspecialchars($search_cliente); ?>">
                <input type="date" name="search_fecha" class="form-control mr-2" value="<?php echo htmlspecialchars($search_fecha); ?>">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th># Pedido</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($pedidos) > 0) {
                    $index = $offset + 1;
                    foreach ($pedidos as $pedido) {
                        echo "<tr>
                                <td>{$pedido['ID_Pedido']}</td>
                                <td>{$pedido['Fecha']}</td>
                                <td>{$pedido['Cliente']}</td>
                                <td><button class='btn btn-primary' data-toggle='modal' data-target='#modalPedido{$pedido['ID_Pedido']}'>Ver Pedido</button></td>
                              </tr>";
                        $index++;
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No hay pedidos</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="../complementos/verpedido_adm.php?page=<?php echo $i; ?>&rows_per_page=<?php echo $rows_per_page; ?>&search_cliente=<?php echo htmlspecialchars($search_cliente); ?>&search_fecha=<?php echo htmlspecialchars($search_fecha); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>

    <?php
    // Generar modales para cada pedido
    foreach ($pedidos as $pedido) {
        $pedido_id = $pedido['ID_Pedido'];
        $query_detalles = "SELECT dp.*, p.imagen, p.nombre, p.precio FROM detalle_pedido dp JOIN producto p ON dp.ID_Producto = p.ID_Producto WHERE dp.ID_Pedido = ?";
        $stmt_detalles = $pdo->prepare($query_detalles);
        $stmt_detalles->execute([$pedido_id]);
        $detalles = $stmt_detalles->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="modal fade" id="modalPedido<?php echo $pedido_id; ?>" tabindex="-1" role="dialog" aria-labelledby="modalPedidoLabel<?php echo $pedido_id; ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPedidoLabel<?php echo $pedido_id; ?>">Detalles del Pedido</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h6>Información del Cliente</h6>
                        <p><strong>Nombre:</strong> <?php echo $pedido['Cliente']; ?></p>
                        <p><strong>Dirección:</strong> <?php echo $pedido['direccion']; ?></p>
                        <p><strong>Teléfono:</strong> <?php echo $pedido['telefono']; ?></p>
                        <hr>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Precio por Unidad</th>
                                    <th>Cantidad</th>
                                    <th>Total por Producto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                $index = 1;
                                foreach ($detalles as $detalle) {
                                    $subtotal = $detalle['Subtotal'];
                                    $total += $subtotal;
                                    echo "<tr>
                                            <td>{$index}</td>
                                            <td><img src='{$detalle['imagen']}' alt='{$detalle['nombre']}' style='width: 50px; height: 50px;'></td>
                                            <td>{$detalle['nombre']}</td>
                                            <td>LPS. {$detalle['precio']}</td>
                                            <td>{$detalle['Cantidad']}</td>
                                            <td>LPS. {$subtotal}</td>
                                          </tr>";
                                    $index++;
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right"><strong>Total</strong></td>
                                    <td><strong>LPS. <?php echo $total; ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
