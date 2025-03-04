<?php
session_start();
include 'complementos/head.php';
include 'confi/conexionproductos.php';

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
        <form action="procesar_pago.php" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="localidad">Localidad</label>
                        <input type="text" class="form-control" id="localidad" name="localidad" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3 w-100">Pagar y Finalizar</button>
        </form>
    </div>

    <script src="https://kit.fontawesome.com/45b2b3afef.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>
