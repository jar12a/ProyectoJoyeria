<?php
// Incluir la conexión a la base de datos
require_once '../confi/conexion.php';

// Consulta para obtener los usuarios
$sql = "SELECT id, usuario, nombre, telefono, direccion, idRol, correo FROM usuario";
$stmt = $pdo->query($sql);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Usuarios</title>
    <!-- Bootstrap CSS (opcional, para estilos) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Tabla de Usuarios</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Rol</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['usuario']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['telefono']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['direccion']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['idRol']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                        <td>
                            <!-- Botón para editar -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal<?= $usuario['id']; ?>">
                                Editar
                            </button>
                        </td>
                        <!-- Modal de Edición -->
                        <?php foreach ($usuarios as $usuario): ?>
                            <div class="modal fade" id="editarUsuarioModal<?= $usuario['id']; ?>" tabindex="-1" aria-labelledby="editarUsuarioModalLabel<?= $usuario['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editarUsuarioModalLabel<?= $usuario['id']; ?>">Editar Usuario</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Formulario de edición de usuario -->
                                            <form action="../complementos/editar_usuario.php" method="POST">
                                                <input type="hidden" name="id" value="<?= $usuario['id']; ?>">
                                                <div class="mb-3">
                                                    <label for="usuario<?= $usuario['id']; ?>" class="form-label">Usuario</label>
                                                    <input type="text" class="form-control" id="usuario<?= $usuario['id']; ?>" name="usuario" value="<?= htmlspecialchars($usuario['usuario']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password<?= $usuario['id']; ?>" class="form-label">Contraseña</label>
                                                    <input type="password" class="form-control" id="password<?= $usuario['id']; ?>" name="password" placeholder="*****">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nombre<?= $usuario['id']; ?>" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="nombre<?= $usuario['id']; ?>" name="nombre" value="<?= htmlspecialchars($usuario['nombre']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="telefono<?= $usuario['id']; ?>" class="form-label">Teléfono</label>
                                                    <input type="text" class="form-control" id="telefono<?= $usuario['id']; ?>" name="telefono" value="<?= htmlspecialchars($usuario['telefono']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="direccion<?= $usuario['id']; ?>" class="form-label">Dirección</label>
                                                    <input type="text" class="form-control" id="direccion<?= $usuario['id']; ?>" name="direccion" value="<?= htmlspecialchars($usuario['direccion']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="correo<?= $usuario['id']; ?>" class="form-label">Correo</label>
                                                    <input type="email" class="form-control" id="correo<?= $usuario['id']; ?>" name="correo" value="<?= htmlspecialchars($usuario['correo']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="rol<?= $usuario['id']; ?>" class="form-label">Rol</label>
                                                    <select class="form-select" id="rol<?= $usuario['id']; ?>" name="rol" required>
                                                        <option value="Administrador" <?= ($usuario['rol'] === 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                                                        <option value="Vendedor" <?= ($usuario['rol'] === 'Vendedor') ? 'selected' : ''; ?>>Vendedor</option>
                                                        <option value="Cliente" <?= ($usuario['rol'] === 'Cliente') ? 'selected' : ''; ?>>Cliente</option>
                                                    </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>