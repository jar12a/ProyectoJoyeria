<?php

// consultas sql
include 'conexion.php';

// Obtener los valores de los filtros si existen
$categoria_filtro = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$material_filtro = isset($_GET['material']) ? $_GET['material'] : '';

// Construir la consulta SQL con los filtros
$sql_productos = "SELECT p.ID_Producto, p.Nombre, c.Nombre AS Categoria, p.Descripción, p.Stock, p.Precio, p.Material, p.Imagen 
                  FROM producto p
                  JOIN categoría c ON p.ID_Categoría = c.ID_categoría
                  WHERE 1=1";

if ($categoria_filtro) {
    $sql_productos .= " AND c.ID_categoría = '$categoria_filtro'";
}

if ($material_filtro) {
    $sql_productos .= " AND p.Material = '$material_filtro'";
}

$result_productos = $conn->query($sql_productos);

$sql_categorias = "SELECT ID_categoría, Nombre FROM categoría"; 
$result_categorias = $conn->query($sql_categorias);

if (!$result_categorias) {
    die("Error en la consulta de categorías: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bodega Virtual - Joyas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table th, .table td {
            padding: 1rem;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }
        .table th:nth-child(1), .table td:nth-child(1) { /* Enumeración */
            width:1%;
        }
        .table th:nth-child(2), .table td:nth-child(2) { /* Nombre */
            width: 0%;
        }
        .table th:nth-child(3), .table td:nth-child(3) { /* Categoria */
            width: 1%;
        }
        .table th:nth-child(4), .table td:nth-child(4) { /* Descripción */
            width: 1%;
        }
        .table th:nth-child(5), .table td:nth-child(5) { /* Cantidad */
            width: 1%;
        }
        .table th:nth-child(6), .table td:nth-child(6) { /* Precio */
            width: 1%;
        }
        .table th:nth-child(7), .table td:nth-child(7) { /* Material */
            width: 1%;
        }
        .table th:nth-child(8), .table td:nth-child(8) { /* Imagen */
            width: 1%;
        }
        .table th:nth-child(9), .table td:nth-child(9) { /* Acciones */
            width: 1%;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Bodega Virtual - Joyas</h2>
        
        <!-- Formulario para agregar joyas -->
        <form id="productoForm" class="mb-4" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre de la joya" required>
                </div>
                <div class="col-md-3 mb-3">
                    <select id="tipo" name="tipo" class="form-control" required>
                        <option value="">Seleccione categoria</option>
                        <!-- Aquí cargas las categorías desde PHP -->
                        <?php
                        if ($result_categorias && $result_categorias->num_rows > 0) {
                            while ($row = $result_categorias->fetch_assoc()) {
                                echo "<option value='" . $row['ID_categoría'] . "'>" . $row['Nombre'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No hay categorías disponibles</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Descripción" required>
                </div>
                <div class="col-md-3 mb-3">
                    <input type="number" id="cantidad" name="cantidad" class="form-control" placeholder="Cantidad disponible" required>
                </div>
                <div class="col-md-3 mb-3">
                    <input type="number" id="precio" name="precio" class="form-control" placeholder="Precio" required>
                </div>
                <div class="col-md-3 mb-3">
                    <select id="material" name="material" class="form-control" required>
                        <option value="">Selecciona material</option>
                        <option value="Oro">Oro</option>
                        <option value="Plata">Plata</option>
                        <option value="Platino">Platino</option>
                        <option value="Acero">Acero</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <input type="file" id="imagen" name="imagen" class="form-control">
                    <input type="hidden" id="imagen_actual" name="imagen_actual">
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <button type="button" id="btnAgregar" class="btn btn-primary me-2" onclick="agregarProducto()">Agregar</button>
                    <button type="button" id="btnActualizar" class="btn btn-warning" onclick="actualizarProducto()" style="display:none;">Actualizar</button>
                </div>
            </div>
        </form>

        <!-- Formulario de filtros -->
        <form method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <select id="categoria" name="categoria" class="form-control">
                        <option value="">Filtrar por categoría</option>
                        <?php
                        $result_categorias->data_seek(0); // Reiniciar el puntero del resultado
                        if ($result_categorias && $result_categorias->num_rows > 0) {
                            while ($row = $result_categorias->fetch_assoc()) {
                                $selected = ($row['ID_categoría'] == $categoria_filtro) ? 'selected' : '';
                                echo "<option value='" . $row['ID_categoría'] . "' $selected>" . $row['Nombre'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <select id="material" name="material" class="form-control">
                        <option value="">Filtrar por material</option>
                        <option value="Oro" <?php echo ($material_filtro == 'Oro') ? 'selected' : ''; ?>>Oro</option>
                        <option value="Plata" <?php echo ($material_filtro == 'Plata') ? 'selected' : ''; ?>>Plata</option>
                        <option value="Platino" <?php echo ($material_filtro == 'Platino') ? 'selected' : ''; ?>>Platino</option>
                        <option value="Acero" <?php echo ($material_filtro == 'Acero') ? 'selected' : ''; ?>>Acero</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>

        <!-- Tabla para mostrar joyas -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Material</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="productosLista">
                <?php
                if ($result_productos->num_rows > 0) {
                    $contador = 1;
                    while ($row = $result_productos->fetch_assoc()) {
                        echo "<tr id='producto-{$row['ID_Producto']}'>
                                <td>{$contador}</td>
                                <td>{$row['Nombre']}</td>
                                <td>{$row['Categoria']}</td>
                                <td><button class='btn btn-info btn-sm' onclick='mostrarDescripcion(\"{$row['Descripción']}\")'>detalles</button></td>
                                <td>{$row['Stock']}</td>
                                <td>{$row['Precio']}</td>
                                <td>{$row['Material']}</td>
                                <td><img src='{$row['Imagen']}' alt='Imagen' style='width: 50px; height: 50px;'></td>
                                <td>
                                    <button class='btn btn-warning btn-sm' onclick='editarProducto({$row['ID_Producto']}, \"{$row['Descripción']}\")'>Editar</button>
                                    <button class='btn btn-danger btn-sm' onclick='eliminarProducto({$row['ID_Producto']})'>Eliminar</button>
                                </td>
                            </tr>";
                        $contador++;
                    }
                }
                ?>
            </tbody>
        </table>

        <!-- Modal para la descripción -->
        <div class="modal fade" id="descripcionModal" tabindex="-1" aria-labelledby="descripcionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="descripcionModalLabel">Descripción del Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="descripcionModalContent"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para mensajes -->
        <div class="modal fade" id="mensajeModal" tabindex="-1" aria-labelledby="mensajeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mensajeModalLabel">Mensaje</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="mensajeModalContent"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Variable para almacenar el ID del producto a actualizar
        let productoId = null;

        // Función para editar un producto
        function editarProducto(id, descripcion) {
            const fila = document.getElementById(`producto-${id}`);
            const celdas = fila.getElementsByTagName("td");

            // Llenar el formulario con los datos actuales del producto
            document.getElementById("nombre").value = celdas[1].innerText;
            document.getElementById("tipo").value = celdas[2].innerText;
            document.getElementById("descripcion").value = descripcion;
            document.getElementById("cantidad").value = celdas[4].innerText;
            document.getElementById("precio").value = celdas[5].innerText;
            document.getElementById("material").value = celdas[6].innerText;
            document.getElementById("imagen_actual").value = celdas[7].querySelector("img").src;

            // Mostrar el botón de actualizar y ocultar el de agregar
            document.getElementById("btnAgregar").style.display = "none";
            document.getElementById("btnActualizar").style.display = "inline-block";

            // Almacenar el ID del producto que se va a actualizar
            productoId = id;
        }

        // Función para validar el formulario
        function validarFormulario() {
            const nombre = document.getElementById("nombre").value;
            const tipo = document.getElementById("tipo").value;
            const descripcion = document.getElementById("descripcion").value;
            const cantidad = document.getElementById("cantidad").value;
            const precio = document.getElementById("precio").value;
            const material = document.getElementById("material").value;
            const imagen = document.getElementById("imagen").value;

            if (!nombre || !tipo || !descripcion || !cantidad || !precio || !material) {
                mostrarMensaje("Todos los campos son obligatorios.");
                return false;
            }
            return true;
        }

        // Función para mostrar mensajes en un modal
        function mostrarMensaje(mensaje) {
            document.getElementById("mensajeModalContent").innerText = mensaje;
            var mensajeModal = new bootstrap.Modal(document.getElementById('mensajeModal'));
            mensajeModal.show();
            setTimeout(() => {
                mensajeModal.hide();
            }, 1000);
        }

        // Función para agregar un producto
        function agregarProducto() {
            if (!validarFormulario()) {
                return;
            }

            let formData = new FormData(document.getElementById("productoForm"));

            fetch("guardar_producto.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarMensaje("Producto agregado correctamente.");
                    setTimeout(() => {
                        location.reload(); // Recargar la página
                    }, 1000);
                } else {
                    mostrarMensaje("Error al agregar el producto.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                mostrarMensaje("Error al agregar el producto.");
            });
        }

        // Función para actualizar un producto
        function actualizarProducto() {
            if (!validarFormulario()) {
                return;
            }

            let formData = new FormData(document.getElementById("productoForm"));
            formData.append("ID_Producto", productoId); // el ID del producto para actualizarlo
            formData.append("imagen_actual", document.getElementById("imagen_actual").value); // Añadir la imagen actual

            fetch("actualizar_producto.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarMensaje("Producto actualizado correctamente.");
                    setTimeout(() => {
                        location.reload(); // Recargar la página para ver los cambios
                    }, 1000);
                } else {
                    mostrarMensaje("Error al actualizar el producto.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                mostrarMensaje("Error al actualizar el producto.");
            });
        }

        // Función para eliminar un producto
        function eliminarProducto(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                fetch("eliminar_producto.php", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id }) // Asegúrate de que el ID se está enviando correctamente
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mostrarMensaje("Producto eliminado correctamente.");
                        setTimeout(() => {
                            document.getElementById(`producto-${id}`).remove(); // Elimina la fila de la tabla
                        }, 1000);
                    } else {
                        mostrarMensaje("Error al eliminar el producto.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    mostrarMensaje("Error al eliminar el producto.");
                });
            }
        }

        // Función para mostrar la descripción en el modal
        function mostrarDescripcion(descripcion) {
            document.getElementById("descripcionModalContent").innerText = descripcion;
            var descripcionModal = new bootstrap.Modal(document.getElementById('descripcionModal'));
            descripcionModal.show();
        }

        // Manejo del formulario de agregar producto
        document.getElementById("productoForm").addEventListener("submit", function(event) {
            event.preventDefault();

            if (!validarFormulario()) {
                return;
            }

            let formData = new FormData(this);

            fetch("guardar_producto.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarMensaje("Producto agregado correctamente.");
                    setTimeout(() => {
                        location.reload(); // Recargar la página para mostrar los nuevos productos
                    }, 1000);
                } else {
                    mostrarMensaje("Error al guardar el producto.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                mostrarMensaje("Error al guardar el producto.");
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
