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
    <title>Lista de Deseos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>
    <br>

    <style>
        .carousel-inner img {
            width: 100vw;
            /* Asegura que el carrusel ocupe todo el ancho de la pantalla */
            max-width: 100vw;
        }

        .carousel-item img {
            width: 100px;
            /* Ajusta el ancho de la imagen al 100% */
            height: 200px;
            /* Mantén la altura fija para las imágenes */
            object-fit: cover;
            /* Cubre todo el espacio sin dejar áreas negras */
            background-color: black;
            /* Se puede eliminar si no es necesario */
        }
    </style>


	<!-- baner con boostrap -->
    <div id="carouselExampleDark" class="carousel carousel-dark slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3"
                aria-label="Slide 4"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="1000">
                <img src="img/banner1.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>La Calidad</h5>
                    <p>En la palma de tu mano.</p>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <img src="img/banner2.avif" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Desde los mejores Precios.</h5>
                    <p>Con grabados personalizos.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/banner3.jpeg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Con un catalogo muy Completo</h5>
                    <p>Con porcentaje de descuentos por su preferencia.</p>
                </div>
            </div>

            
            <div class="carousel-item">
                <img src="img/banner4.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Con envios a todas partes del mundo.</h5>
                    <p>Recibes en la puerta de su hogar.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <br>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Deseos</h2>
        <div class="row" id="wishlist-container">
            <!-- Los productos se cargarán aquí desde JavaScript -->
        </div>
    </div>

    <script>
        // Función para cargar la lista de deseos desde localStorage
        function cargarListaDeseos() {
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            let container = document.getElementById('wishlist-container');
            container.innerHTML = '';

            if (wishlist.length > 0) {
                wishlist.forEach(producto => {
                    let productHTML = `
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <img src="${producto.imagen}" class="card-img-top" alt="${producto.nombre}">
                                <div class="card-body">
                                    <h6 class="card-title">${producto.nombre}</h6>
                                    <p class="card-text">LPS.${producto.precio}</p>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" placeholder="Cantidad" min="1" value="1" id="cantidad-${producto.id}">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" onclick="agregarAlCarrito(${producto.id}, '${producto.nombre}', ${producto.precio}, '${producto.imagen}')">
                                                <i class="bi bi-cart"></i>Agregar al carrito
                                            </button>
                                        </div>
                                    </div>
                                    <button class="btn btn-danger" onclick="eliminarDeListaDeseos(${producto.id})">Eliminar</button>
                                </div>
                            </div>
                        </div>`;
                    container.innerHTML += productHTML;
                });
            } else {
                container.innerHTML = '<p>No hay productos en la lista de deseos.</p>';
            }
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
                cargarListaDeseos();
                alert('Producto agregado a la lista de deseos');
            }
        }

        // Función para agregar un producto al carrito
        function agregarAlCarrito(id, nombre, precio, imagen) {
            let cantidad = document.getElementById(`cantidad-${id}`).value;
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
                } else {
                    alert('Error al agregar el producto al carrito');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Función para eliminar un producto de la lista de deseos
        function eliminarDeListaDeseos(id) {
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            wishlist = wishlist.filter(producto => producto.id !== id);
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            cargarListaDeseos();
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

        // Llamar a la función para cargar la lista de deseos al cargar la página
        document.addEventListener('DOMContentLoaded', () => {
            cargarListaDeseos();
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