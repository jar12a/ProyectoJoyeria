<?php
include 'complementos/head.php';
include 'bodega/conexionproductos.php';
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
            max-width: 70%;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Sección de Productos -->
        <h2 class="mb-4">Productos</h2>
        <div class="row">
            <?php
            // Realizar la consulta a la base de datos
            $sql = "SELECT * FROM producto";
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
                echo '                <input type="number" class="form-control" placeholder="Cantidad" min="1" value="1">';
                echo '                <div class="input-group-append">';
                echo '                    <button class="btn btn-primary" type="button">';
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
                echo '                            <input type="number" class="form-control" placeholder="Cantidad" min="1" value="1" style="width: 100px;">';
                echo '                            <div class="input-group-append">';
                echo '                                <button class="btn btn-primary" type="button">';
                echo '                                    <i class="bi bi-cart"></i> Agregar al carrito';
                echo '                                </button>';
                echo '                            </div>';
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<?php include 'complementos/footer.php';?>
</html>


