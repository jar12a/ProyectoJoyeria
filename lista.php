<?php
require 'conexion.php'; // Archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accion'])) {
        // Acción de agregar
        if ($_POST['accion'] == 'agregar') {
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $telefono = $_POST['telefono'];
            $documento = $_POST['documento_identidad'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $direccion = $_POST['direccion'];
            $estado_civil = $_POST['estado_civil'];
            $procedencia = $_POST['procedencia'];
            $salario = $_POST['salario'];
            $nss = $_POST['nss'];
            $contacto_emergencia = $_POST['contacto_emergencia'];

            // Verificar si ya existe el documento de identidad
$sql_check_documento = "SELECT * FROM personal WHERE documento_identidad = '$documento'";
$result_documento = $conn->query($sql_check_documento);

if ($result_documento->num_rows > 0) {
    echo "<script>alert('El documento de identidad ya está registrado.'); window.location.href='lista.php';</script>";
    exit; // Detener el proceso si ya existe un duplicado
}

// Verificar si ya existe el correo electrónico
$sql_check_correo = "SELECT * FROM personal WHERE correo = '$correo'";
$result_correo = $conn->query($sql_check_correo);

if ($result_correo->num_rows > 0) {
    echo "<script>alert('El correo electrónico ya está registrado.'); window.location.href='lista.php';</script>";
    exit; // Detener el proceso si ya existe un duplicado
}

// Verificar si ya existe el número de seguro social (NSS)
$sql_check_nss = "SELECT * FROM personal WHERE nss = '$nss'";
$result_nss = $conn->query($sql_check_nss);

if ($result_nss->num_rows > 0) {
    echo "<script>alert('El número de seguro social (NSS) ya está registrado.'); window.location.href='lista.php';</script>";
    exit; // Detener el proceso si ya existe un duplicado
}

            // Manejo de la foto
            $foto_nombre = $_FILES['foto']['name'];
            $foto_tmp = $_FILES['foto']['tmp_name'];
            $ruta_destino = "uploads/" . $foto_nombre;
            move_uploaded_file($foto_tmp, $ruta_destino);

            // Fecha de ingreso automática
            $fecha_ingreso = date("Y-m-d");

            // Insertar en la base de datos
            $sql = "INSERT INTO personal (nombre, correo, telefono, documento_identidad, fecha_nacimiento, direccion, estado_civil, fecha_ingreso, procedencia, salario, nss, contacto_emergencia, foto)
                    VALUES ('$nombre', '$correo', '$telefono', '$documento', '$fecha_nacimiento', '$direccion', '$estado_civil', '$fecha_ingreso', '$procedencia', '$salario', '$nss', '$contacto_emergencia', '$foto_nombre')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Registro guardado correctamente'); window.location.href='lista.php';</script>";
            } else {
                echo "Error: " . $conn->error;
            }
        }

        // Acción de editar
        if ($_POST['accion'] == 'editar') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $telefono = $_POST['telefono'];
            $documento = $_POST['documento_identidad'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $direccion = $_POST['direccion'];
            $estado_civil = $_POST['estado_civil'];
            $procedencia = $_POST['procedencia'];
            $salario = $_POST['salario'];
            $nss = $_POST['nss'];
            $contacto_emergencia = $_POST['contacto_emergencia'];

            // Manejo de la foto (si se ha cambiado)
            if ($_FILES['foto']['name']) {
                $foto_nombre = $_FILES['foto']['name'];
                $foto_tmp = $_FILES['foto']['tmp_name'];
                $ruta_destino = "uploads/" . $foto_nombre;
                move_uploaded_file($foto_tmp, $ruta_destino);
                $foto_sql = ", foto='$foto_nombre'";
            } else {
                $foto_sql = "";
            }

            // Actualizar en la base de datos
            $sql = "UPDATE personal SET nombre='$nombre', correo='$correo', telefono='$telefono', documento_identidad='$documento', fecha_nacimiento='$fecha_nacimiento', direccion='$direccion', estado_civil='$estado_civil', procedencia='$procedencia', salario='$salario', nss='$nss', contacto_emergencia='$contacto_emergencia' $foto_sql WHERE id=$id";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Registro actualizado correctamente'); window.location.href='lista.php';</script>";
            } else {
                echo "Error: " . $conn->error;
            }
        }

        // Acción de eliminar
        if ($_POST['accion'] == 'eliminar') {
            $id = $_POST['id'];

            // Eliminar de la base de datos
            $sql = "DELETE FROM personal WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Registro eliminado correctamente'); window.location.href='lista.php';</script>";
            } else {
                echo "Error: " . $conn->error;
            }
        }
    }
}

$sql = "SELECT * FROM personal";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Personal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .table-container {
            overflow-x: auto; /* Permite scroll horizontal */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            white-space: nowrap; /* Evita que el texto se rompa */
        }

        th {
            background-color: #f4f4f4;
        }

        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Lista de Personal</h2>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregar">Agregar Personal</button>

        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Documento Identidad</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Dirección</th>
                        <th>Estado Civil</th>
                        <th>Fecha de Ingreso</th>
                        <th>Procedencia</th>
                        <th>Salario</th>
                        <th>NSS</th>
                        <th>Contacto de Emergencia</th>
                        <th>Foto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nombre']) ?></td>
                            <td><?= htmlspecialchars($row['correo']) ?></td>
                            <td><?= htmlspecialchars($row['telefono']) ?></td>
                            <td><?= htmlspecialchars($row['documento_identidad']) ?></td>
                            <td><?= htmlspecialchars($row['fecha_nacimiento']) ?></td>
                            <td><?= htmlspecialchars($row['direccion']) ?></td>
                            <td><?= htmlspecialchars($row['estado_civil']) ?></td>
                            <td><?= htmlspecialchars($row['fecha_ingreso']) ?></td>
                            <td><?= htmlspecialchars($row['procedencia']) ?></td>
                            <td><?= htmlspecialchars($row['salario']) ?> L</td>
                            <td><?= htmlspecialchars($row['nss']) ?></td>
                            <td><?= htmlspecialchars($row['contacto_emergencia']) ?></td>
                            <td>
                                <?php if (!empty($row['foto'])): ?>
                                    <img src="uploads/<?= htmlspecialchars($row['foto']) ?>" alt="Foto">
                                <?php else: ?>
                                    No disponible
                                <?php endif; ?>
                            </td>
                            <td>
                                <!-- Botones de editar y eliminar -->
                                <form action="lista.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <input type="hidden" name="nombre" value="<?= $row['nombre'] ?>">
                                    <input type="hidden" name="correo" value="<?= $row['correo'] ?>">
                                    <input type="hidden" name="telefono" value="<?= $row['telefono'] ?>">
                                    <input type="hidden" name="documento_identidad" value="<?= $row['documento_identidad'] ?>">
                                    <input type="hidden" name="fecha_nacimiento" value="<?= $row['fecha_nacimiento'] ?>">
                                    <input type="hidden" name="direccion" value="<?= $row['direccion'] ?>">
                                    <input type="hidden" name="estado_civil" value="<?= $row['estado_civil'] ?>">
                                    <input type="hidden" name="procedencia" value="<?= $row['procedencia'] ?>">
                                    <input type="hidden" name="salario" value="<?= $row['salario'] ?>">
                                    <input type="hidden" name="nss" value="<?= $row['nss'] ?>">
                                    <input type="hidden" name="contacto_emergencia" value="<?= $row['contacto_emergencia'] ?>">
                                    <a href="editar.php?id=<?= $row['id'] ?>" class="btn btn-primary">Editar</a>
                                </form>
                                <form action="lista.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" name="accion" value="eliminar" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este registro?');">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="13">No hay registros</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para agregar nuevo personal -->
    <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Agregar Personal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="lista.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <!-- Campos del formulario de agregar -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" class="form-control" name="correo" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="documento_identidad" class="form-label">Documento de Identidad</label>
                            <input type="text" class="form-control" name="documento_identidad" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" name="fecha_nacimiento" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" name="direccion" required>
                        </div>
                        <div class="mb-3">
                            <label for="estado_civil" class="form-label">Estado Civil</label>
                            <select class="form-control" name="estado_civil" required>
                                <option value="Soltero">Soltero</option>
                                <option value="Casado">Casado</option>
                                <option value="Divorciado">Divorciado</option>
                                <option value="Viudo">Viudo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="procedencia" class="form-label">Procedencia</label>
                            <select class="form-control" name="procedencia" required>
                                <option value="Honduras">Honduras</option>
                                <option value="Extranjero">Extranjero</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="salario" class="form-label">Salario (Lempiras)</label>
                            <input type="number" class="form-control" name="salario" required>
                        </div>
                        <div class="mb-3">
                            <label for="nss" class="form-label">Número de Seguro Social</label>
                            <input type="text" class="form-control" name="nss" required>
                        </div>
                        <div class="mb-3">
                            <label for="contacto_emergencia" class="form-label">Contacto de Emergencia</label>
                            <input type="text" class="form-control" name="contacto_emergencia" required>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" class="form-control" name="foto" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" name="accion" value="agregar" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function cargarDatosEditar(id) {
            // Usar AJAX o recargar el formulario para rellenar con los datos correctos
            // Aquí, por simplicidad, estamos usando datos precargados en hidden inputs
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>