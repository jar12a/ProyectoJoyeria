<?php
require 'conexion.php';

// Verificar si hay un ID válido en la URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$id = intval($_GET['id']);

// Obtener datos actuales del registro
$sql = "SELECT * FROM personal WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Registro no encontrado.");
}

$row = $result->fetch_assoc();

// Procesar la actualización
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $documento_identidad = $_POST['documento_identidad'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $direccion = $_POST['direccion'];
    $estado_civil = $_POST['estado_civil'];
    $procedencia = $_POST['procedencia'];
    $salario = $_POST['salario'];
    $nss = $_POST['nss'];
    $contacto_emergencia = $_POST['contacto_emergencia'];

    $sql_update = "UPDATE personal SET nombre=?, correo=?, telefono=?, documento_identidad=?, fecha_nacimiento=?, direccion=?, estado_civil=?, procedencia=?, salario=?, nss=?, contacto_emergencia=? WHERE id=?";
    
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("sssssssssssi", $nombre, $correo, $telefono, $documento_identidad, $fecha_nacimiento, $direccion, $estado_civil, $procedencia, $salario, $nss, $contacto_emergencia, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Datos actualizados correctamente'); window.location.href='lista.php';</script>";
        exit();
    } else {
        echo "Error al actualizar: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Personal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Editar Personal</h2>
        <form action="editar.php?id=<?= $id ?>" method="POST" class="shadow p-4 rounded bg-light">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($row['nombre']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Correo</label>
                    <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($row['correo']) ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($row['telefono']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Documento de Identidad</label>
                    <input type="text" name="documento_identidad" class="form-control" value="<?= htmlspecialchars($row['documento_identidad']) ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" class="form-control" value="<?= htmlspecialchars($row['fecha_nacimiento']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="direccion" class="form-control" value="<?= htmlspecialchars($row['direccion']) ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Estado Civil</label>
                    <select name="estado_civil" class="form-control" required>
                        <option value="Soltero" <?= $row['estado_civil'] == 'Soltero' ? 'selected' : '' ?>>Soltero</option>
                        <option value="Casado" <?= $row['estado_civil'] == 'Casado' ? 'selected' : '' ?>>Casado</option>
                        <option value="Divorciado" <?= $row['estado_civil'] == 'Divorciado' ? 'selected' : '' ?>>Divorciado</option>
                        <option value="Viudo" <?= $row['estado_civil'] == 'Viudo' ? 'selected' : '' ?>>Viudo</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Procedencia</label>
                    <input type="text" name="procedencia" class="form-control" value="<?= htmlspecialchars($row['procedencia']) ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Salario</label>
                    <input type="number" step="0.01" name="salario" class="form-control" value="<?= htmlspecialchars($row['salario']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">NSS</label>
                    <input type="text" name="nss" class="form-control" value="<?= htmlspecialchars($row['nss']) ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Contacto de Emergencia</label>
                <input type="text" name="contacto_emergencia" class="form-control" value="<?= htmlspecialchars($row['contacto_emergencia']) ?>" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                <a href="lista.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>