<?php
session_start();
include 'complementos/head.php';
include 'confi/conexion.php';

// Obtener el término de búsqueda
$termino_busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

// Realizar la consulta para obtener los productos que coincidan con la búsqueda
$sql_busqueda = "SELECT * FROM producto WHERE Nombre LIKE :termino OR Descripción LIKE :termino";
$stmt_busqueda = $pdo->prepare($sql_busqueda);
$stmt_busqueda->execute(['termino' => '%' . $termino_busqueda . '%']);
$resultados_busqueda = $stmt_busqueda->fetchAll(PDO::FETCH_ASSOC);

// Realizar la consulta para obtener productos recomendados (aleatorios)
$sql_recomendados = "SELECT * FROM producto ORDER BY RAND() LIMIT 10";
$stmt_recomendados = $pdo->query($sql_recomendados);
$productos_recomendados = $stmt_recomendados->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
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
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Resultados de Búsqueda</h2>

        <!-- Resultados de búsqueda -->
        <div class="row">
            <?php if (count($resultados_busqueda) > 0): ?>
                <?php foreach ($resultados_busqueda as $producto): ?>
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="<?php echo $producto['Imagen']; ?>" class="card-img-top" alt="<?php echo $producto['Nombre']; ?>">
                            <div class="card-img-overlay">
                                <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#previewModal<?php echo $producto['ID_Producto']; ?>">Vista previa</button>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title"><?php echo $producto['Nombre']; ?></h6>
                                <p class="card-text">LPS.<?php echo $producto['Precio']; ?></p>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" placeholder="Cantidad" min="1" value="1" id="cantidad-<?php echo $producto['ID_Producto']; ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" id="btn-carrito-<?php echo $producto['ID_Producto']; ?>" onclick="agregarAlCarrito(<?php echo $producto['ID_Producto']; ?>, '<?php echo $producto['Nombre']; ?>', <?php echo $producto['Precio']; ?>, '<?php echo $producto['Imagen']; ?>')">
                                            <i class="bi bi-cart"></i>Agregar al carrito
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal de Vista Previa -->
                    <div class="modal fade" id="previewModal<?php echo $producto['ID_Producto']; ?>" tabindex="-1" aria-labelledby="previewModalLabel<?php echo $producto['ID_Producto']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-lg-custom">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="previewModalLabel<?php echo $producto['ID_Producto']; ?>"><?php echo $producto['Nombre']; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <img src="<?php echo $producto['Imagen']; ?>" class="d-block w-100 mb-2" alt="<?php echo $producto['Nombre']; ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Detalles del producto</h6>
                                            <p>Precio: LPS.<?php echo $producto['Precio']; ?></p>
                                            <p>Material: <?php echo $producto['Material']; ?></p>
                                            <p>Descripción: <?php echo $producto['Descripción']; ?></p>
                                            <div class="input-group mb-1">
                                                <input type="number" class="form-control" placeholder="Cantidad" min="1" value="1" id="modal-cantidad-<?php echo $producto['ID_Producto']; ?>" style="width: 100px;">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" id="btn-modal-carrito-<?php echo $producto['ID_Producto']; ?>" onclick="agregarAlCarrito(<?php echo $producto['ID_Producto']; ?>, '<?php echo $producto['Nombre']; ?>', <?php echo $producto['Precio']; ?>, '<?php echo $producto['Imagen']; ?>', true)">
                                                        <i class="bi bi-cart"></i> Agregar al carrito
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between mt-3">
                                                <button class="btn btn-outline-danger" onclick="agregarAListaDeseos(<?php echo $producto['ID_Producto']; ?>, '<?php echo $producto['Nombre']; ?>', <?php echo $producto['Precio']; ?>, '<?php echo $producto['Imagen']; ?>')"><i class="fa-solid fa-heart"></i></button>
                                                <button class="btn btn-outline-primary" onclick="compartirProducto(<?php echo $producto['ID_Producto']; ?>)"><i class="fa-solid fa-share"></i></button>
                                            </div>
                                            <div class="rating mt-3">
                                                <input type="radio" name="rating-<?php echo $producto['ID_Producto']; ?>" id="rating-5-<?php echo $producto['ID_Producto']; ?>" value="5"><label for="rating-5-<?php echo $producto['ID_Producto']; ?>">&#9733;</label>
                                                <input type="radio" name="rating-<?php echo $producto['ID_Producto']; ?>" id="rating-4-<?php echo $producto['ID_Producto']; ?>" value="4"><label for="rating-4-<?php echo $producto['ID_Producto']; ?>">&#9733;</label>
                                                <input type="radio" name="rating-<?php echo $producto['ID_Producto']; ?>" id="rating-3-<?php echo $producto['ID_Producto']; ?>" value="3"><label for="rating-3-<?php echo $producto['ID_Producto']; ?>">&#9733;</label>
                                                <input type="radio" name="rating-<?php echo $producto['ID_Producto']; ?>" id="rating-2-<?php echo $producto['ID_Producto']; ?>" value="2"><label for="rating-2-<?php echo $producto['ID_Producto']; ?>">&#9733;</label>
                                                <input type="radio" name="rating-<?php echo $producto['ID_Producto']; ?>" id="rating-1-<?php echo $producto['ID_Producto']; ?>" value="1"><label for="rating-1-<?php echo $producto['ID_Producto']; ?>">&#9733;</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p>No se encontraron productos que coincidan con tu búsqueda.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Productos recomendados -->
        <h2 class="mb-4">Productos Recomendados</h2>
        <div id="carouselRecomendados" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php foreach (array_chunk($productos_recomendados, 4) as $index => $grupo_productos): ?>
                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <div class="row">
                            <?php foreach ($grupo_productos as $producto): ?>
                                <div class="col-md-3 mb-4">
                                    <div class="card">
                                        <img src="<?php echo $producto['Imagen']; ?>" class="card-img-top" alt="<?php echo $producto['Nombre']; ?>">
                                        <div class="card-body">
                                            <h6 class="card-title"><?php echo $producto['Nombre']; ?></h6>
                                            <p class="card-text">LPS.<?php echo $producto['Precio']; ?></p>
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" placeholder="Cantidad" min="1" value="1" id="cantidad-recomendado-<?php echo $producto['ID_Producto']; ?>">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" id="btn-recomendado-carrito-<?php echo $producto['ID_Producto']; ?>" onclick="agregarAlCarrito(<?php echo $producto['ID_Producto']; ?>, '<?php echo $producto['Nombre']; ?>', <?php echo $producto['Precio']; ?>, '<?php echo $producto['Imagen']; ?>', false, true)">
                                                        <i class="bi bi-cart"></i>Agregar al carrito
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a class="carousel-control-prev" href="#carouselRecomendados" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#carouselRecomendados" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Siguiente</span>
            </a>
        </div>
    </div>

    <script>
        // Función para agregar un producto al carrito
        function agregarAlCarrito(id, nombre, precio, imagen, isModal = false, isRecomendado = false) {
            let cantidad = isModal ? document.getElementById(`modal-cantidad-${id}`).value : document.getElementById(isRecomendado ? `cantidad-recomendado-${id}` : `cantidad-${id}`).value;
            
            if (cantidad < 1) {
                alert('La cantidad debe ser al menos 1');
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
            let boton = isModal ? document.getElementById(`btn-modal-carrito-${id}`) : document.getElementById(isRecomendado ? `btn-recomendado-carrito-${id}` : `btn-carrito-${id}`);
            boton.innerHTML = '<div class="loading-spinner"></div> Cargando...';
            boton.style.backgroundColor = '#000'; // Cambiar el color del botón a negro
            boton.disabled = true; // Deshabilitar el botón para evitar múltiples clics

            // Simular el tiempo de carga de 1.5 segundos
            setTimeout(() => {
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
                        alert('Error al agregar el producto al carrito');
                        boton.innerHTML = '<i class="bi bi-cart"></i> Agregar al carrito';
                        boton.style.backgroundColor = ''; // Restaurar el color original del botón
                        boton.disabled = false; // Habilitar el botón nuevamente
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
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

        // Función para agregar un producto a la lista de deseos
        function agregarAListaDeseos(id, nombre, precio, imagen) {
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            let productoExistente = wishlist.find(producto => producto.id === id);

            if (productoExistente) {
                alert('Este producto ya está en la lista de deseos');
            } else {
                let producto = {
                    id: id,
                    nombre: nombre,
                    precio: precio,
                    imagen: imagen
                };
                wishlist.push(producto);
                localStorage.setItem('wishlist', JSON.stringify(wishlist));
                alert('Producto agregado a la lista de deseos');
            }
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
    </script>
    <script src="https://kit.fontawesome.com/45b2b3afef.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>

