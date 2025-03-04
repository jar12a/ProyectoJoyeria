<?php
session_start();
include 'complementos/head.php';
include 'confi/conexionproductos.php';

// Realizar la consulta para contar el número de productos registrados
$sql_count = "SELECT COUNT(*) AS total_productos FROM producto";
$stmt_count = $conn->query($sql_count);
$total_productos = $stmt_count->fetch_assoc()['total_productos'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
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
            max-width: 50%;
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
        .loading-spinner {
            border: 2px solid #f3f3f3;
            border-top: 2px solid #3498db;
            border-radius: 50%;
            width: 12px;
            height: 12px;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-right: 5px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .btn-primary, .form-control {
            height: 50px; /* Ajusta esta altura según tus necesidades */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-message {
            z-index: 1051; /* Un valor más alto que el modal de vista previa */
        }
    </style>
</head>
<body>
    <!-- Modal para mensajes -->
    <div class="modal fade modal-message" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Mensaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="messageModalBody">
                    <!-- Mensaje se insertará aquí -->
                </div>
            </div>
        </div>
    </div>
    <!-- Fin del modal para mensajes -->
    <div class="container mt-5">
        <!-- Sección de Productos -->
        <h2 class="mb-4">Productos <span class="badge badge-secondary"><?php echo $total_productos; ?></span></h2>
        <div class="row">
            <?php
            // Realizar la consulta a la base de datos
            $sql = "SELECT * FROM producto ORDER BY RAND()";
            $stmt = $conn->query($sql);

            // Iterar sobre los resultados y mostrarlos en tarjetas de Bootstrap
            while ($row = $stmt->fetch_assoc()) {
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
                echo '                    <button class="btn btn-primary" type="button" id="btn-carrito-' . $row['ID_Producto'] . '" onclick="agregarAlCarrito(' . $row['ID_Producto'] . ', \'' . $row['Nombre'] . '\', ' . $row['Precio'] . ', \'' . $row['Imagen'] . '\')">';
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
                echo '                                <button class="btn btn-primary" type="button" id="btn-modal-carrito-' . $row['ID_Producto'] . '" onclick="agregarAlCarrito(' . $row['ID_Producto'] . ', \'' . $row['Nombre'] . '\', ' . $row['Precio'] . ', \'' . $row['Imagen'] . '\', true)">';
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
    // Función para mostrar el modal de mensaje
    function mostrarMensaje(mensaje) {
        document.getElementById('messageModalBody').textContent = mensaje;
        $('#messageModal').modal('show');
        setTimeout(() => {
            $('#messageModal').modal('hide');
        }, 1500);
    }

    // Función para agregar un producto al carrito
    function agregarAlCarrito(id, nombre, precio, imagen, isModal = false) {
        let cantidad = isModal ? document.getElementById(`modal-cantidad-${id}`).value : document.getElementById(`cantidad-${id}`).value;
        
        if (cantidad < 1) {
            mostrarMensaje('La cantidad debe ser al menos 1');
            return;
        }

        let producto = {
            id: id,
            nombre: nombre,
            precio: precio,
            cantidad: parseInt(cantidad),
            imagen: imagen // Añadir la imagen del producto
        };

        // Obtener el botón y cambiar su estado a "Cargando..."
        let boton = isModal ? document.getElementById(`btn-modal-carrito-${id}`) : document.getElementById(`btn-carrito-${id}`);
            boton.innerHTML = '<div class="loading-spinner"></div> Cargando...';
            boton.style.backgroundColor = '#000'; // Cambiar el color del botón a negro
            boton.disabled = true; // Deshabilitar el botón para evitar múltiples clics

            // Simular el tiempo de carga de 1.5 segundos
            setTimeout(() => {
                // Agregar producto al carrito en el servidor

        // Agregar producto al carrito en el servidor
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
                // Actualizar el carrito en localStorage
                let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
                let productoExistente = carrito.find(item => item.id === id);

                if (productoExistente) {
                    productoExistente.cantidad += producto.cantidad;
                } else {
                    carrito.push(producto);
                }

                localStorage.setItem('carrito', JSON.stringify(carrito));
                actualizarContadorCarrito(); // Actualizar el contador del carrito

               // Cambiar el texto del botón a "Añadido al carrito" con un GIF de cheque
               boton.innerHTML = '<img src="product/cheque.gif" alt="Cheque" style="width: 20px; height: 20px;"> Añadido al carrito';
                        boton.style.backgroundColor = '#28a745'; // Cambiar el color del botón a verde

                        // Volver a cambiar el texto del botón a "Agregar al carrito" después de 2 segundos
                        setTimeout(() => {
                            boton.innerHTML = '<i class="bi bi-cart"></i> Agregar al carrito';
                            boton.style.backgroundColor = ''; // Restaurar el color original del botón
                            boton.disabled = false; // Habilitar el botón nuevamente
                        }, 2000);
            } else {
                mostrarMensaje('Error al agregar el producto al carrito');
                boton.innerHTML = '<i class="bi bi-cart"></i> Agregar al carrito';
                        boton.style.backgroundColor = ''; // Restaurar el color original del botón
                        boton.disabled = false; // Habilitar el botón nuevamente
            }
        })
        .catch(error => {
                    console.error('Error:', error);
                    mostrarMensaje('Error al agregar el producto al carrito');
                    boton.innerHTML = '<i class="bi bi-cart"></i> Agregar al carrito';
                    boton.style.backgroundColor = ''; // Restaurar el color original del botón
                    boton.disabled = false; // Habilitar el botón nuevamente
                });
            }, 1500);
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

    // Función para cargar los productos del carrito al cargar la página
    function cargarCarrito() {
        let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
        carrito.forEach(producto => {
            // Aquí puedes agregar el código para mostrar los productos en el carrito
            console.log('Producto en carrito:', producto);
        });
    }

    // Llamar a las funciones para actualizar los contadores y cargar productos al cargar la página
    document.addEventListener('DOMContentLoaded', () => {
        actualizarContadorCarrito();
        cargarCarrito();
    });

    // Función para agregar un producto a la lista de deseos
    function agregarAListaDeseos(id, nombre, precio, imagen) {
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        let productoExistente = wishlist.find(producto => producto.id === id);

        if (productoExistente) {
            mostrarMensaje('Este producto ya está en la lista de deseos');
        } else {
            let producto = {
                id: id,
                nombre: nombre,
                precio: precio,
                imagen: imagen
            };
            wishlist.push(producto);
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            mostrarMensaje('Producto agregado a la lista de deseos');
        }
    }

    // Función para compartir un producto
    function compartirProducto(id) {
        const url = window.location.href + '?producto=' + id;
        navigator.clipboard.writeText(url).then(() => {
            mostrarMensaje('Enlace del producto copiado al portapapeles');
        }).catch(err => {
            console.error('Error al copiar el enlace: ', err);
            mostrarMensaje('Error al copiar el enlace');
        });
    }
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


