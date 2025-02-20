<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imperial Gems</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" />
	<?php include 'complementos/head.php'; ?>
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


	<!-- baner con css. -->
    <section class="banner">
        <div class="content-banner">
            <p>Las mejores joyas</p>
            <h2>Al mejor precio <br />Envios a cualquier parte del mundo</h2>
            <a href="/ProyectoJoyeria/catalago1.php">Ver catalogos</a>
        </div>
    </section>



    <main class="main-content">
    <section class="container container-features">
        <div class="card-feature">
            <i class="fa-solid fa-plane-up"></i>
            <div class="feature-content">
                <span>Envío gratuito a nivel mundial</span>
                <p>En pedido superior a Lps 1,000.00 ($50)</p>
            </div>
        </div>
        <div class="card-feature">
            <i class="fa-solid fa-wallet"></i>
            <div class="feature-content">
                <span>Contrareembolso</span>
                <p>100% garantía de devolución de dinero</p>
            </div>
        </div>
        <div class="card-feature">
            <i class="fa-solid fa-gift"></i>
            <div class="feature-content">
                <span>Tarjeta regalo especial</span>
                <p>Ofrece bonos especiales con regalo</p>
            </div>
        </div>
        <div class="card-feature">
            <i class="fa-solid fa-headset"></i>
            <div class="feature-content">
                <span>Servicio al cliente 24/7</span>
                <p>LLámenos 24/7 +504 9667-7273</p>
            </div>
        </div>



        
    </section>

        <div class="card" style="width: 18rem;">
            <img src="product/1.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Aretes Flor de Diamante en Oro Rosado</h5>
                <p class="card-text">Estos deslumbrantes aretes en forma de flor cuentan con pétalos de oro rosado y un
                    centro de brillantes diamantes. Su diseño sofisticado los convierte en el complemento perfecto para
                    ocasiones especiales o para añadir un toque de lujo a tu día a día.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>

        <div class="div">
            <div class="card" style="width: 18rem;">
                <img src="http://localhost/ProyectoJoyeria/product/2.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Moneda de Oro Clásica del Rey Jorge V – Edición Coleccionista</h5>
                    <p class="card-text">Adquiere esta emblemática moneda de oro, una auténtica pieza de historia que
                        destaca por su diseño elegante y su inconfundible retrato del Rey Jorge V. Fabricada con
                        precisión y
                        detalles exquisitos, esta moneda es perfecta para coleccionistas, inversores y amantes de la
                        numismática. Su acabado brillante y su alto contenido en oro la convierten en un símbolo de
                        valor y
                        tradición. ¡Asegura la tuya y añade un toque de distinción a tu colección!</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>

        <div class="div">
            <div class="card" style="width: 18rem;">
                <img src="product/3.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Moneda de Oro con Diseño de Divinidad Hindú – Arte y Espiritualidad</h5>
                    <p class="card-text">Descubre esta extraordinaria moneda de oro, una obra maestra que combina el
                        arte y
                        la espiritualidad. Con un intrincado grabado de una divinidad hindú, esta pieza simboliza la
                        riqueza
                        cultural y el misticismo de la tradición india. Elaborada con precisión en oro puro, esta moneda
                        es
                        ideal para coleccionistas y para quienes buscan un símbolo de prosperidad y buena fortuna. Un
                        artículo único que trasciende lo material para conectar con lo sagrado. ¡Hazla parte de tu
                        colección
                        ahora!</p>
                </div>
            </div>

            <nav aria-label="...">
                <ul class="pagination">
                    <li class="page-item disabled">
                        <span class="page-link">Anterior</span>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active" aria-current="page">
                        <span class="page-link">2</span>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Siguiente</a>
                    </li>
                </ul>
            </nav>

            <section class="container top-categories">
				<h1 class="heading-1">Mejores Precios</h1>
				<div class="container-categories">
					<div class="card-category Joya-1">
						<p>joya 1</p>
						<span>Ver más</span>
					</div>
					<div class="card-category Joya-2">
						<p>joya 2</p>
						<span>Ver más</span>
					</div>
					<div class="card-category Joya-3">
						<p>joya 3</p>
						<span>Ver más</span>
					</div>
				</div>
			</section>

			<section class="container top-products">
				<h1 class="heading-1">Mejores Productos</h1>

				<div class="container-options">
					<span class="active">Destacados</span>
					<span>Más recientes</span>
					<span>Mejores Vendidos</span>
				</div>

				<div class="container-products">
					<!-- Producto 1 -->
					<div class="card-product">
						<div class="container-img">
							<img src="product/4.jpg" alt="Cafe Irish" />
							<span class="discount">-13%</span>
							<div class="button-group">
								<span>
									<i class="fa-regular fa-eye"></i>
								</span>
								<span>
									<i class="fa-regular fa-heart"></i>
								</span>
								<span>
									<i class="fa-solid fa-code-compare"></i>
								</span>
							</div>
						</div>
						<div class="content-card-product">
							<div class="stars">
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-regular fa-star"></i>
							</div>
							<h3>Joya 4</h3>
							<span class="add-cart">
								<i class="fa-solid fa-basket-shopping"></i>
							</span>
							<p class="price">L500 <span>L600</span></p>
						</div>
					</div>
					<!-- Producto 2 -->
					<div class="card-product">
						<div class="container-img">
							<img
								src="product/5.jpg"
								alt="Cafe incafe-ingles.jpg"
							/>
							<span class="discount">-22%</span>
							<div class="button-group">
								<span>
									<i class="fa-regular fa-eye"></i>
								</span>
								<span>
									<i class="fa-regular fa-heart"></i>
								</span>
								<span>
									<i class="fa-solid fa-code-compare"></i>
								</span>
							</div>
						</div>
						<div class="content-card-product">
							<div class="stars">
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-regular fa-star"></i>
								<i class="fa-regular fa-star"></i>
							</div>
							<h3>Joya5</h3>
							<span class="add-cart">
								<i class="fa-solid fa-basket-shopping"></i>
							</span>
							<p class="price">L700.00<span>L780.00</span></p>
						</div>
					</div>
					<!--  -->
					<div class="card-product">
						<div class="container-img">
							<img
								src="product/6.jpg"
								alt="Cafe Australiano"
							/>
							<div class="button-group">
								<span>
									<i class="fa-regular fa-eye"></i>
								</span>
								<span>
									<i class="fa-regular fa-heart"></i>
								</span>
								<span>
									<i class="fa-solid fa-code-compare"></i>
								</span>
							</div>
						</div>
						<div class="content-card-product">
							<div class="stars">
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
							</div>
							<h3>Joya 6</h3>
							<span class="add-cart">
								<i class="fa-solid fa-basket-shopping"></i>
							</span>
							<p class="price">L500.00</p>
						</div>
					</div>
					<!--  -->
					<div class="card-product">
						<div class="container-img">
							<img src="product/7.jpg" alt="Cafe Helado" />
							<div class="button-group">
								<span>
									<i class="fa-regular fa-eye"></i>
								</span>
								<span>
									<i class="fa-regular fa-heart"></i>
								</span>
								<span>
									<i class="fa-solid fa-code-compare"></i>
								</span>
							</div>
						</div>
						<div class="content-card-product">
							<div class="stars">
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-regular fa-star"></i>
							</div>
							<h3>Joya 7</h3>
							<span class="add-cart">
								<i class="fa-solid fa-basket-shopping"></i>
							</span>
							<p class="price">L700.00</p>
						</div>
					</div>
				</div>
			</section>

			<section class="gallery">
				<img
					src="product/8.jpg"
					alt="Gallery Img1"
					class="gallery-img-1"
				/><img
					src="product/9.jpg"
					alt="Gallery Img2"
					class="gallery-img-2"
				/><img
					src="product/12.jpg"
					alt="Gallery Img3"
					class="product/8.jpg"
				/><img
					src="product/13.jpg"
					alt="Gallery Img4"
					class="gallery-img-4"
				/><img
					src="product/14.jpg"
					alt="Gallery Img5"
					class="gallery-img-5"
				/>
			</section>

			<section class="container specials">
				<h1 class="heading-1">Especiales</h1>

				<div class="container-products">
					<!-- Producto 1 -->
					<div class="card-product">
						<div class="container-img">
							<img src="product/15.jpg" alt="Cafe Irish" />
							<span class="discount">-13%</span>
							<div class="button-group">
								<span>
									<i class="fa-regular fa-eye"></i>
								</span>
								<span>
									<i class="fa-regular fa-heart"></i>
								</span>
								<span>
									<i class="fa-solid fa-code-compare"></i>
								</span>
							</div>
						</div>
						<div class="content-card-product">
							<div class="stars">
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-regular fa-star"></i>
							</div>
							<h3>joya 15</h3>
							<span class="add-cart">
								<i class="fa-solid fa-basket-shopping"></i>
							</span>
							<p class="price">$4.60 <span>$5.30</span></p>
						</div>
					</div>
					<!-- Producto 2 -->
					<div class="card-product">
						<div class="container-img">
							<img
								src="product/16.jpg"
								alt="Cafe incafe-ingles.jpg"
							/>
							<span class="discount">-22%</span>
							<div class="button-group">
								<span>
									<i class="fa-regular fa-eye"></i>
								</span>
								<span>
									<i class="fa-regular fa-heart"></i>
								</span>
								<span>
									<i class="fa-solid fa-code-compare"></i>
								</span>
							</div>
						</div>
						<div class="content-card-product">
							<div class="stars">
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-regular fa-star"></i>
								<i class="fa-regular fa-star"></i>
							</div>
							<h3>Joya 16</h3>
							<span class="add-cart">
								<i class="fa-solid fa-basket-shopping"></i>
							</span>
							<p class="price">$5.70 <span>$7.30</span></p>
						</div>
					</div>
					<!--  -->
					<div class="card-product">
						<div class="container-img">
							<img src="product/17.jpg" alt="Cafe Viena" />
							<span class="discount">-30%</span>
							<div class="button-group">
								<span>
									<i class="fa-regular fa-eye"></i>
								</span>
								<span>
									<i class="fa-regular fa-heart"></i>
								</span>
								<span>
									<i class="fa-solid fa-code-compare"></i>
								</span>
							</div>
						</div>
						<div class="content-card-product">
							<div class="stars">
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
							</div>
							<h3>Joya 17</h3>
							<span class="add-cart">
								<i class="fa-solid fa-basket-shopping"></i>
							</span>
							<p class="price">$3.85 <span>$5.50</span></p>
						</div>
					</div>
					<!--  -->
					<div class="card-product">
						<div class="container-img">
							<img src="product/18.jpg" alt="Cafe Liqueurs" />
							<div class="button-group">
								<span>
									<i class="fa-regular fa-eye"></i>
								</span>
								<span>
									<i class="fa-regular fa-heart"></i>
								</span>
								<span>
									<i class="fa-solid fa-code-compare"></i>
								</span>
							</div>
						</div>
						<div class="content-card-product">
							<div class="stars">
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-regular fa-star"></i>
							</div>
							<h3>Joya 18</h3>
							<span class="add-cart">
								<i class="fa-solid fa-basket-shopping"></i>
							</span>
							<p class="price">$5.60</p>
						</div>
					</div>
				</div>
			</section>

			<section class="container blogs">
				<h1 class="heading-1">Últimos Blogs</h1>

				<div class="container-blogs">
					<div class="card-blog">
						<div class="container-img">
							<img src="img/blog-1.webp" alt="Imagen Blog 1" />
							<div class="button-group-blog">
								<span>
									<i class="fa-solid fa-magnifying-glass"></i>
								</span>
								<span>
									<i class="fa-solid fa-link"></i>
								</span>
							</div>
						</div>
						<div class="content-blog">
							<h3>
                                Haz que cada día sea encantador
                            </h3>
							<span>05 de febrero 2025</span>
							<p>
								Encuentra chrams de Imperial Gems cargados de significado qie amará el día de San Valentín y todos los días.
							</p>
							<div class="btn-read-more">Leer más</div>
						</div>
					</div>
					<div class="card-blog">
						<div class="container-img">
							<img src="img/blog-2.webp" alt="Imagen Blog 2" />
							<div class="button-group-blog">
								<span>
									<i class="fa-solid fa-magnifying-glass"></i>
								</span>
								<span>
									<i class="fa-solid fa-link"></i>
								</span>
							</div>
						</div>
						<div class="content-blog">
							<h3>Regalos para todos tus amores</h3>
							<span>05 de febrero 2025</span>
							<p>
								Regala joyas perfectas y simbolos cargados de sentimientos a las personas de tu lista de San Valentin.
							</p>
							<div class="btn-read-more">Leer más</div>
						</div>
					</div>
					<div class="card-blog">
						<div class="container-img">
							<img src="img/blog-3.webp" alt="Imagen Blog 3" />
							<div class="button-group-blog">
								<span>
									<i class="fa-solid fa-magnifying-glass"></i>
								</span>
								<span>
									<i class="fa-solid fa-link"></i>
								</span>
							</div>
						</div>
						<div class="content-blog">
							<h3>Conjunto de regalo que merece la pena regalar (y recibir)</h3>
							<span>05 de febrero 2025</span>
							<p>
								Sorpréndela con combinaciones seleccionadas con gran cuidado y listas para envolver y ponerselas con amor.
							<div class="btn-read-more">Leer más</div>
						</div>
					</div>
				</div>
			</section>

        </main>
            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    
		<script src="https://kit.fontawesome.com/45b2b3afef.js" crossorigin="anonymous"></script>
</body>
<?php include 'complementos/footer.php'; ?>
</html>