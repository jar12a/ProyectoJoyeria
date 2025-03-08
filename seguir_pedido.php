<?php
session_start();
include 'complementos/head.php';
include 'confi/conexion.php';

// Establecer la zona horaria
date_default_timezone_set('America/Tegucigalpa'); // Ajusta la zona horaria según tu ubicación

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id'])) {
    header("Location: dashboard/login.php");
    exit();
}

// Obtener los datos del usuario desde la base de datos
$idUsuario = $_SESSION['id'];
$stmt = $pdo->prepare("SELECT nombre, telefono, direccion FROM usuario WHERE id = ?");
$stmt->execute([$idUsuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $localidad = $_POST['localidad'];
    $telefono = $_POST['telefono'];

    // Actualizar los datos del usuario en la base de datos
    $stmt = $pdo->prepare("UPDATE usuario SET nombre = ?, telefono = ?, direccion = ? WHERE id = ?");
    $stmt->execute([$nombre, $telefono, $localidad, $idUsuario]);

    // Calcular el total del pedido
    $total = 0;
    foreach ($_SESSION['carrito'] as $producto) {
        $subtotal = $producto['precio'] * $producto['cantidad'];
        $total += $subtotal;
    }
    $total_iva = $total * 0.15;
    $total_final = $total + $total_iva + 200; // 200 es el costo de envío

    // Obtener la fecha actual
    $fecha_pedido = date('Y-m-d H:i:s');

    // Insertar el pedido en la tabla pedido
    $stmt = $pdo->prepare("INSERT INTO pedido (ID_usuario, Total, fecha) VALUES (?, ?, ?)");
    $stmt->execute([$idUsuario, $total_final, $fecha_pedido]);
    $idPedido = $pdo->lastInsertId();

    // Insertar los detalles del pedido en la tabla detalle_pedido
    foreach ($_SESSION['carrito'] as $producto) {
        $idProducto = $producto['id'];
        $cantidad = $producto['cantidad'];
        $subtotal = $producto['precio'] * $producto['cantidad'];
        $stmt = $pdo->prepare("INSERT INTO detalle_pedido (ID_Pedido, ID_Producto, Cantidad, Subtotal, Total) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$idPedido, $idProducto, $cantidad, $subtotal, $total_final]);
    }

    // Limpiar el carrito
    unset($_SESSION['carrito']);

    // Mostrar el modal y redirigir al index después de 2 segundos
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('successModal'));
                myModal.show();
                setTimeout(function() {
                    myModal.hide();
                    window.location.href = 'index.php';
                }, 2000);
            });
          </script>";
}

// Definir el IVA y el costo de envío
$iva = 0.15; // 15% de IVA
$costo_envio = 200;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguir Pedido</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">SEGUIMIENTO DEL PEDIDO</h2>
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
                if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
                    foreach ($_SESSION['carrito'] as $index => $producto) {
                        $subtotal = $producto['precio'] * $producto['cantidad'];
                        $total += $subtotal;
                        echo "<tr>
                                <td>" . ($index + 1) . "</td>
                                <td><img src='{$producto['imagen']}' alt='{$producto['nombre']}' style='width: 50px; height: 50px;'></td>
                                <td>{$producto['nombre']}</td>
                                <td>LPS. {$producto['precio']}</td>
                                <td>{$producto['cantidad']}</td>
                                <td>LPS. {$subtotal}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No hay productos en el carrito</td></tr>";
                }
                ?>
            </tbody>
            <tfoot>
                <?php
                $total_iva = $total * $iva;
                $total_final = $total + $total_iva + $costo_envio;
                ?>
                <tr>
                    <td colspan="5" class="text-right"><strong>Total</strong></td>
                    <td><strong>LPS. <?php echo $total; ?></strong></td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right"><strong>I.V.A. (15%)</strong></td>
                    <td><strong>LPS. <?php echo $total_iva; ?></strong></td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right"><strong>Costo de Envío</strong></td>
                    <td><strong>LPS. <?php echo $costo_envio; ?></strong></td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right"><strong>Total Final</strong></td>
                    <td><strong>LPS. <?php echo $total_final; ?></strong></td>
                </tr>
            </tfoot>
        </table>

        <h3 class="mb-4">Datos del Cliente</h3>
        <form action="seguir_pedido.php" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="localidad">Localidad</label>
                        <input type="text" class="form-control" id="localidad" name="localidad" value="<?php echo htmlspecialchars($usuario['direccion']); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3 w-100">Pagar y Finalizar</button>
        </form>
    </div>

    <!-- Modal de éxito de pedido -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="https://media.giphy.com/media/111ebonMs90YLu/giphy.gif" alt="Verificación" style="width: 50px; height: 50px;">
                    <p>Pedido pagado exitosamente</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/45b2b3afef.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>
