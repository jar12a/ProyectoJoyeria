<?php
session_start();
include 'complementos/head.php';
include 'bodega/conexionproductos.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categoría Aritos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .card-img-overlay {
            background: rgba(0, 0, 0, 0.5);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .card:hover .card-img-overlay {
            opacity: 1;
        }
        .carousel-item img {
            cursor: pointer;
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: black;
        }
        .modal-lg-custom {
            max-width: 30%;
        }
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
        }
        .rating input {
            display: none;
        }
        .rating label {
            font-size: 2rem;
            color: #FFD700;
            cursor: pointer;
        }
        .rating label:hover,
        .rating label:hover ~ label,
        .rating input:checked ~ label {
            color: #FFED85;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Sección de Productos -->
        <h2 class="mb-4">ARITOS</h2>
        <div class="row">
            <?php
            // Realizar la consulta a la base de datos para obtener solo los productos de la categoría "aritos"
            $sql = "SELECT p.ID_Producto, p.Nombre, c.Nombre AS Categoria, p.Descripción, p.Stock, p.Precio, p.Material, p.Imagen 
                    FROM producto p
                    JOIN categoría c ON p.ID_Categoría = c.ID_categoría
                    WHERE c.Nombre = 'aritos'";
            $stmt = $pdo->query($sql);

            // Iterar sobre los resultados y mostrarlos en tarjetas de Bootstrap
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="col-md-3 mb-4">';
                echo '    <div class="card">';
                echo '        <img src="' . $row['Imagen'] . '" class="card-img-top" alt="' . $row['Nombre'] . '">';
                echo '        <div class="card-img-overlay">';
                echo '            <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#previewModal' . $row['ID_Producto'] . '">Vista previa</button>';
                echo '        </div>';
                echo '        <div class="card-body">';
                echo '            <h6 class="card-title">' . $row['Nombre'] . '</h6>';
                echo '            <p class="card-text">LPS.' . $row['Precio'] . '</p>';
                echo '            <div class="input-group mb-3">';
                echo '                <input type="number" class="form-control" placeholder="Cantidad" min="1" value="1" id="cantidad-' . $row['ID_Producto'] . '">';
                echo '                <div class="input-group-append">';
                echo '                    <button class="btn btn-primary" type="button" onclick="agregarAlCarrito(' . $row['ID_Producto'] . ', \'' . $row['Nombre'] . '\', ' . $row['Precio'] . ', \'' . $row['Imagen'] . '\')">';
                echo '                        <i class="bi bi-cart"></i>Agregar al carrito';
                echo '                    </button>';
                echo '                </div>';
                echo '            </div>';
                echo '        </div>';
                echo '    </div>';
                echo '</div>';

                // Modal de Vista Previa
                echo '<div class="modal fade" id="previewModal' . $row['ID_Producto'] . '" tabindex="-1" aria-labelledby="previewModalLabel' . $row['ID_Producto'] . '" aria-hidden="true">';
                echo '    <div class="modal-dialog modal-lg modal-lg-custom">';
                echo '        <div class="modal-content">';
                echo '            <div class="modal-header">';
                echo '                <h5 class="modal-title" id="previewModalLabel' . $row['ID_Producto'] . '">' . $row['Nombre'] . '</h5>';
                echo '                <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                echo '                    <span aria-hidden="true">&times;</span>';
                echo '                </button>';
                echo '            </div>';
                echo '            <div class="modal-body">';
                echo '                <div class="row">';
                echo '                    <div class="col-md-6">';
                echo '                        <img src="' . $row['Imagen'] . '" class="d-block w-100 mb-2" alt="' . $row['Nombre'] . '">';
                echo '                    </div>';
                echo '                    <div class="col-md-6">';
                echo '                        <h6>Detalles del producto</h6>';
                echo '                        <p>Precio: LPS.' . $row['Precio'] . '</p>';
                echo '                        <p>Material: ' . $row['Material'] . '</p>';
                echo '                        <p>Descripción: ' . $row['Descripción'] . '</p>';
                echo '                        <div class="input-group mb-1">';
                echo '                            <input type="number" class="form-control" placeholder="Cantidad" min="1" value="1" id="modal-cantidad-' . $row['ID_Producto'] . '" style="width: 100px;">';
                echo '                            <div class="input-group-append">';
                echo '                                <button class="btn btn-primary" type="button" onclick="agregarAlCarrito(' . $row['ID_Producto'] . ', \'' . $row['Nombre'] . '\', ' . $row['Precio'] . ', \'' . $row['Imagen'] . '\', true)">';
                echo '                                    <i class="bi bi-cart"></i> Agregar al carrito';
                echo '                                </button>';
                echo '                            </div>';
                echo '                        </div>';
                echo '                        <div class="d-flex justify-content-between mt-3">';
                echo '                            <button class="btn btn-outline-danger" onclick="agregarAListaDeseos(' . $row['ID_Producto'] . ', \'' . $row['Nombre'] . '\', ' . $row['Precio'] . ', \'' . $row['Imagen'] . '\')"><i class="fa-solid fa-heart"></i></button>';
                echo '                            <button class="btn btn-outline-primary" onclick="compartirProducto(' . $row['ID_Producto'] . ')"><i class="fa-solid fa-share"></i></button>';
                echo '                        </div>';
                echo '                        <div class="rating mt-3">';
                echo '                            <input type="radio" name="rating-' . $row['ID_Producto'] . '" id="rating-5-' . $row['ID_Producto'] . '" value="5"><label for="rating-5-' . $row['ID_Producto'] . '">&#9733;</label>';
                echo '                            <input type="radio" name="rating-' . $row['ID_Producto'] . '" id="rating-4-' . $row['ID_Producto'] . '" value="4"><label for="rating-4-' . $row['ID_Producto'] . '">&#9733;</label>';
                echo '                            <input type="radio" name="rating-' . $row['ID_Producto'] . '" id="rating-3-' . $row['ID_Producto'] . '" value="3"><label for="rating-3-' . $row['ID_Producto'] . '">&#9733;</label>';
                echo '                            <input type="radio" name="rating-' . $row['ID_Producto'] . '" id="rating-2-' . $row['ID_Producto'] . '" value="2"><label for="rating-2-' . $row['ID_Producto'] . '">&#9733;</label>';
                echo '                            <input type="radio" name="rating-' . $row['ID_Producto'] . '" id="rating-1-' . $row['ID_Producto'] . '" value="1"><label for="rating-1-' . $row['ID_Producto'] . '">&#9733;</label>';
                echo '                        </div>';
                echo '                    </div>';
                echo '                </div>';
                echo '            </div>';
                echo '            <div class="modal-footer">';
                echo '                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>';
                echo '            </div>';
                echo '        </div>';
                echo '    </div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <script>
        // Función para agregar un producto al carrito
        function agregarAlCarrito(id, nombre, precio, imagen, isModal = false) {
            let cantidad = isModal ? document.getElementById(`modal-cantidad-${id}`).value : document.getElementById(`cantidad-${id}`).value;
            let producto = {
                id: id,
                nombre: nombre,
                precio: precio,
                cantidad: parseInt(cantidad),
                imagen: imagen // Añadir la imagen del producto
            };

            fetch('agregar_carrito.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(producto)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Producto agregado al carrito');
                    actualizarContadorCarrito(); // Actualizar el contador del carrito
                    location.reload(); // Recargar la página para mostrar los cambios
                } else {
                    alert('Error al agregar el producto al carrito');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Función para actualizar el contador del carrito
        function actualizarContadorCarrito() {
            fetch('obtener_carrito.php')
                .then(response => response.json())
                .then(data => {
                    const cartCount = document.getElementById('cart-count');
                    cartCount.textContent = `(${data.count})`;
                })
                .catch(error => console.error('Error:', error));
        }

        // Función para agregar un producto a la lista de deseos
        function agregarAListaDeseos(id, nombre, precio, imagen) {
            let producto = {
                id: id,
                nombre: nombre,
                precio: precio,
                imagen: imagen // Añadir la imagen del producto
            };

            fetch('agregar_lista_deseos.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(producto)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Producto agregado a la lista de deseos');
                } else {
                    alert('Error al agregar el producto a la lista de deseos');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Función para compartir un producto
        function compartirProducto(id) {
            const url = window.location.href + '?producto=' + id;
            navigator.clipboard.writeText(url).then(() => {
                alert('Enlace del producto copiado al portapapeles');
            }).catch(err => {
                console.error('Error al copiar el enlace: ', err);
            });
        }

        // Llamar a las funciones para actualizar los contadores al cargar la página
        document.addEventListener('DOMContentLoaded', () => {
            actualizarContadorCarrito();
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/45b2b3afef.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
<?php include 'complementos/footer.php';?>
</html>