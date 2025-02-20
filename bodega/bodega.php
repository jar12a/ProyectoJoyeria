<?php

// consultas sql
include 'conexion.php';
$sql_productos = "SELECT p.ID_Producto, p.Nombre, c.Nombre AS Categoria, p.Descripción, p.Stock, p.Precio, p.Material, p.Imagen 
                  FROM producto p
                  JOIN categoría c ON p.ID_Categoría = c.ID_categoría";
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

        <!-- Tabla para mostrar joyas -->
        <table class="table table-bordered">
            <thead>
                <tr>
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
                    while ($row = $result_productos->fetch_assoc()) {
                        echo "<tr id='producto-{$row['ID_Producto']}'>
                                <td>{$row['Nombre']}</td>
                                <td>{$row['Categoria']}</td> <!-- Aquí mostramos el nombre de la categoría -->
                                <td>{$row['Descripción']}</td>
                                <td>{$row['Stock']}</td>
                                <td>{$row['Precio']}</td>
                                <td>{$row['Material']}</td>
                                <td><img src='{$row['Imagen']}' alt='Imagen' style='width: 50px; height: 50px;'></td>
                                <td>
                                    <button class='btn btn-warning btn-sm' onclick='editarProducto({$row['ID_Producto']})'>Editar</button>
                                    <button class='btn btn-danger btn-sm' onclick='eliminarProducto({$row['ID_Producto']})'>Eliminar</button>
                                </td>
                            </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Variable para almacenar el ID del producto a actualizar
        let productoId = null;

        // Función para editar un producto
        function editarProducto(id) {
            const fila = document.getElementById(`producto-${id}`);
            const celdas = fila.getElementsByTagName("td");

            // Llenar el formulario con los datos actuales del producto
            document.getElementById("nombre").value = celdas[0].innerText;
            document.getElementById("tipo").value = celdas[1].innerText;
            document.getElementById("descripcion").value = celdas[2].innerText;
            document.getElementById("cantidad").value = celdas[3].innerText;
            document.getElementById("precio").value = celdas[4].innerText;
            document.getElementById("material").value = celdas[5].innerText;
            document.getElementById("imagen_actual").value = celdas[6].querySelector("img").src;

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
                alert("Todos los campos son obligatorios.");
                return false;
            }
            return true;
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
                    alert("Producto agregado correctamente.");
                    location.reload(); // Recargar la página
                } else {
                    alert("Error al agregar el producto.");
                }
            })
            .catch(error => console.error("Error:", error));
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
                    alert("Producto actualizado correctamente.");
                    location.reload(); // Recargar la página para ver los cambios
                } else {
                    alert("Error al actualizar el producto.");
                }
            })
            .catch(error => console.error("Error:", error));
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
                        alert("Producto eliminado correctamente.");
                        document.getElementById(`producto-${id}`).remove(); // Elimina la fila de la tabla
                    } else {
                        alert("Error al eliminar el producto.");
                    }
                })
                .catch(error => console.error("Error:", error));
            }
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
                    location.reload(); // Recargar la página para mostrar los nuevos productos
                } else {
                    alert("Error al guardar el producto.");
                }
            })
            .catch(error => console.error("Error:", error));
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
