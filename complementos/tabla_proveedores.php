<?php
// Incluir el archivo de conexión
include '../confi/conexion.php';

// Número de registros por página
$registros_por_pagina = 10;

// Obtener el número de la página actual
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_actual < 1) $pagina_actual = 1;

// Obtener el término de búsqueda
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

// Calcular el desplazamiento
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// Consulta para contar el total de registros con filtro
$sql_total = "SELECT COUNT(*) AS total FROM proveedores WHERE 
    empresa LIKE :busqueda OR 
    contacto LIKE :busqueda OR 
    correo LIKE :busqueda OR 
    telefono LIKE :busqueda OR 
    direccion LIKE :busqueda OR 
    envio LIKE :busqueda";

$stmt_total = $pdo->prepare($sql_total);
$stmt_total->execute([':busqueda' => "%$busqueda%"]);
$total_registros = $stmt_total->fetch(PDO::FETCH_ASSOC)['total'];

// Calcular el número total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Consulta para obtener los proveedores con límite, desplazamiento y filtro
$sql = "SELECT id, empresa, contacto, correo, telefono, direccion, envio 
        FROM proveedores 
        WHERE 
            empresa LIKE :busqueda OR 
            contacto LIKE :busqueda OR 
            correo LIKE :busqueda OR 
            telefono LIKE :busqueda OR 
            direccion LIKE :busqueda OR 
            envio LIKE :busqueda
        LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':busqueda', "%$busqueda%", PDO::PARAM_STR);
$stmt->bindValue(':limit', $registros_por_pagina, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Proveedores</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
    body {
        transition: background-color 0.3s, color 0.3s;
    }

    .table-container {
        overflow-x: auto; /* Agrega scroll horizontal si la tabla es muy ancha */
    }

    table {
        word-wrap: normal;
        white-space: nowrap; /* Evitar que las palabras se corten */
    }

    .dark-mode {
        background-color: #121212;
        color: #e0e0e0;
    }

    .dark-mode table {
        color: #e0e0e0;
    }

    th, td {
        text-align: center;
        vertical-align: middle;
    }

    /* Control de búsqueda, paginación e información fuera de la tabla */
    .info-wrapper, .search-wrapper, .pagination-wrapper {
        margin: 10px 0; /* Separación entre controles */
    }

    .info-wrapper {
        font-size: 0.9rem;
        color: #555;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: flex-end; /* Alinear a la derecha */
    }

    .search-wrapper {
        display: flex;
        justify-content: flex-end; /* Alinear a la derecha */
        margin-bottom: 15px; /* Espaciado inferior */
    }
</style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-center">Lista de Proveedores</h2>
            <!-- Botón para cambiar entre modo oscuro y claro -->
            <button class="btn btn-secondary" id="toggle-mode">Modo Oscuro</button>
        </div>

        <!-- Botones para acciones adicionales -->
        <div class="d-flex justify-content-end mb-3">
    <button class="btn btn-primary me-2" onclick="habilitarEdicion()">Editar Fila Seleccionada</button>
    <button id="btn-guardar" class="btn btn-success me-2" style="display: none;" onclick="guardarCambios()">Guardar Cambios</button>
    <button class="btn btn-danger me-2" onclick="borrarFila()">Borrar Fila Seleccionada</button>
    <button class="btn btn-info me-2" onclick="location.reload();">Actualizar Tabla</button>
    <!-- Botón para exportar a Excel -->
    <button class="btn btn-success" id="exportarExcel">Exportar a Excel</button>
</div>


        <div class="table-container">
            <table id="tablaProveedores" class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Seleccionar</th>
                        <th>ID</th>
                        <th>Empresa</th>
                        <th>Contacto</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Método de Envío</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultado as $fila) { ?>
                        <tr id="<?php echo $fila['id']; ?>">
                            <td><input type="radio" name="seleccion" value="<?php echo $fila['id']; ?>"></td>
                            <td><?php echo $fila['id']; ?></td>
                            <td data-editable data-columna="empresa"><?php echo htmlspecialchars($fila['empresa']); ?></td>
                            <td data-editable data-columna="contacto"><?php echo htmlspecialchars($fila['contacto']); ?></td>
                            <td data-editable data-columna="correo"><?php echo htmlspecialchars($fila['correo']); ?></td>
                            <td data-editable data-columna="telefono"><?php echo htmlspecialchars($fila['telefono']); ?></td>
                            <td data-editable data-columna="direccion"><?php echo htmlspecialchars($fila['direccion']); ?></td>
                            <td data-editable data-columna="envio"><?php echo htmlspecialchars($fila['envio']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts para DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

    <script>
        // Activar DataTables
        $(document).ready(function() {
    const tabla = $('#tablaProveedores').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-MX.json",
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ entradas",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            },
        },
        paging: true,
        pagingType: "simple_numbers",
        dom: `<'d-flex justify-content-between align-items-center mb-2'
                <'info-wrapper'i>
                <'search-wrapper'f>>
              t
              <'d-flex justify-content-between align-items-center mt-2'
                <'pagination-wrapper'p>>`
    });

    // Mover los controles fuera de la tabla
    const infoWrapper = document.querySelector('.info-wrapper');
    const searchWrapper = document.querySelector('.search-wrapper');
    const paginationWrapper = document.querySelector('.pagination-wrapper');
    const tableContainer = document.querySelector('.table-container');

    // Ubicar cada elemento según la estructura deseada
    tableContainer.insertAdjacentElement('beforebegin', infoWrapper);
    tableContainer.insertAdjacentElement('beforebegin', searchWrapper);
    tableContainer.insertAdjacentElement('afterend', paginationWrapper);
});


  // Función para exportar la tabla a Excel
  document.getElementById("exportarExcel").addEventListener("click", function () {
        // Obtén la tabla HTML
        const tabla = document.getElementById("tablaProveedores");

        // Convierte la tabla a una hoja de cálculo
        const workbook = XLSX.utils.book_new();
        const worksheet = XLSX.utils.table_to_sheet(tabla);

        // Agrega la hoja de cálculo al libro
        XLSX.utils.book_append_sheet(workbook, worksheet, "Proveedores");

        // Genera el archivo Excel y lo descarga
        XLSX.writeFile(workbook, "Proveedores.xlsx");
    });
        // Modo oscuro/claro
        document.getElementById("toggle-mode").addEventListener("click", () => {
            document.body.classList.toggle("dark-mode");
            const btn = document.getElementById("toggle-mode");
            btn.textContent = document.body.classList.contains("dark-mode") ? "Modo Claro" : "Modo Oscuro";
        });

        // Habilitar edición
        function habilitarEdicion() {
            const seleccionada = document.querySelector('input[name="seleccion"]:checked');
            if (!seleccionada) {
                alert("Selecciona una fila para editar.");
                return;
            }
            const fila = document.getElementById(seleccionada.value);
            const celdas = fila.querySelectorAll("td[data-editable]");
            celdas.forEach(celda => {
                celda.setAttribute("contenteditable", "true");
                celda.classList.add("table-warning");
            });
            document.getElementById("btn-guardar").style.display = "inline-block";
        }

        // Guardar cambios en la base de datos
        function guardarCambios() {
            const seleccionada = document.querySelector('input[name="seleccion"]:checked');
            if (!seleccionada) return;

            const fila = document.getElementById(seleccionada.value);
            const celdas = fila.querySelectorAll("td[data-editable]");
            const datos = { id: seleccionada.value };

            celdas.forEach(celda => {
                const columna = celda.getAttribute("data-columna");
                datos[columna] = celda.innerText.trim();
            });

            fetch("editar_proveedor.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(datos)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Cambios guardados correctamente.");
                    celdas.forEach(celda => {
                        celda.removeAttribute("contenteditable");
                        celda.classList.remove("table-warning");
                    });
                    document.getElementById("btn-guardar").style.display = "none";
                } else {
                    alert("Error al guardar los cambios.");
                }
            });
        }

        function borrarFila() {
    const seleccionada = document.querySelector('input[name="seleccion"]:checked');
    if (!seleccionada) {
        alert("Selecciona una fila para borrar.");
        return;
    }

    const id = seleccionada.value;

    if (confirm("¿Estás seguro de que deseas eliminar este proveedor?")) {
        fetch("borrar_proveedor.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Proveedor eliminado correctamente.");
                const fila = document.getElementById(id);
                fila.remove();
            } else {
                alert("Error al eliminar el proveedor.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Ocurrió un error al intentar eliminar el proveedor.");
        });
    }
}
    </script>
</body>
</html>


<?php
// Cerrar la conexión
$pdo = null;
?>
