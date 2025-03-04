<?php
session_start();
include 'complementos/head.php';
include 'confi/conexionproductos.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Continuar Pedido</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">MODIFICAR PEDIDO</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="carrito-body">
                <?php
                $total = 0;
                if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
                    foreach ($_SESSION['carrito'] as $index => $producto) {
                        $subtotal = $producto['precio'] * $producto['cantidad'];
                        $total += $subtotal;
                        echo "<tr id='producto-{$index}'>
                                <td><img src='{$producto['imagen']}' alt='{$producto['nombre']}' style='width: 50px; height: 50px;'></td>
                                <td>{$producto['nombre']}</td>
                                <td>LPS. {$producto['precio']}</td>
                                <td>
                                    <input type='number' class='form-control' value='{$producto['cantidad']}' min='1' id='cantidad-{$index}' onchange='calcularSubtotal({$index}, {$producto['precio']})'>
                                </td>
                                <td id='subtotal-{$index}'>LPS. {$subtotal}</td>
                                <td>
                                    <button class='btn btn-primary btn-sm' onclick='actualizarCantidad({$index})'>
                                        <i class='fa-solid fa-sync'></i>
                                    </button>
                                    <button class='btn btn-danger btn-sm' onclick='eliminarProducto({$index})'>Eliminar</button>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No hay productos en el carrito</td></tr>";
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right"><strong>Total</strong></td>
                    <td id="total"><strong>LPS. <?php echo $total; ?></strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <div class="d-flex justify-content-between mb-5">
            <button class="btn btn-danger" onclick="vaciarCarrito()">Vaciar Carrito</button>
            <button class="btn btn-success" onclick="finalizarPedido()">Finalizar Pedido</button>
        </div>
    </div>

    <script>
        // Función para eliminar un producto del carrito
        function eliminarProducto(index) {
            fetch('eliminar_producto_carrito.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ index: index })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`producto-${index}`).remove();
                    actualizarTotal();
                } else {
                    alert('Error al eliminar el producto del carrito');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Función para vaciar el carrito
        function vaciarCarrito() {
            fetch('vaciar_carrito.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Recargar la página para ver los cambios
                } else {
                    alert('Error al vaciar el carrito');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Función para actualizar la cantidad de un producto en el carrito
        function actualizarCantidad(index) {
            const cantidad = document.getElementById(`cantidad-${index}`).value;
            fetch('actualizar_cantidad_carrito.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ index: index, cantidad: cantidad })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    calcularSubtotal(index, data.precio);
                    actualizarTotal();
                } else {
                    alert('Error al actualizar la cantidad del producto');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Función para calcular el subtotal de un producto
        function calcularSubtotal(index, precio) {
            const cantidad = document.getElementById(`cantidad-${index}`).value;
            const subtotal = cantidad * precio;
            document.getElementById(`subtotal-${index}`).innerText = `LPS. ${subtotal}`;
            actualizarTotal(); // Actualizar el total después de calcular el subtotal
        }

        // Función para actualizar el total del carrito
        function actualizarTotal() {
            let total = 0;
            const subtotales = document.querySelectorAll('[id^="subtotal-"]');
            subtotales.forEach(subtotal => {
                total += parseFloat(subtotal.innerText.replace('LPS. ', ''));
            });
            document.getElementById('total').innerText = `LPS. ${total}`;
        }

        // Función para finalizar el pedido
        function finalizarPedido() {
            window.location.href = 'seguir_pedido.php'; // Redirigir a la página de finalizar pedido
        }
    </script>
    <script src="https://kit.fontawesome.com/45b2b3afef.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
<?php include 'complementos/footer.php';?>
</html>
