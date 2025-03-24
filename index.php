<?php
require 'conexion.php'; // Archivo de conexión

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
</head>
<body>
    <div class="container mt-5">
        <h2>Lista de Personal</h2>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregar">Agregar Personal</button>
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
                                <img src="uploads/<?= htmlspecialchars($row['foto']) ?>" width="50">
                            <?php else: ?>
                                No disponible
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="13">No hay registros</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para agregar nuevo personal -->
    <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Agregar Personal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="agregar.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Correo</label>
                            <input type="email" name="correo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" required pattern="[2389][0-9]{7}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Documento Identidad</label>
                            <input type="text" name="documento_identidad" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dirección</label>
                            <textarea name="direccion" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Estado Civil</label>
                            <select name="estado_civil" class="form-control" required>
                                <option value="Soltero">Soltero</option>
                                <option value="Casado">Casado</option>
                                <option value="Divorciado">Divorciado</option>
                                <option value="Viudo">Viudo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Procedencia</label>
                            <select name="procedencia" class="form-control" required>
                                <option value="Honduras">Honduras</option>
                                <option value="Extranjero">Extranjero</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Salario</label>
                            <input type="number" name="salario" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NSS</label>
                            <input type="text" name="nss" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contacto de Emergencia</label>
                            <input type="text" name="contacto_emergencia" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Foto</label>
                            <input type="file" name="foto" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>