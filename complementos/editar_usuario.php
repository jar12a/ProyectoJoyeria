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
                                <option value="Administrador" <?= ($usuario['Rol'] === 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                                <option value="Vendedor" <?= ($usuario['Rol'] === 'Vendedor') ? 'selected' : ''; ?>>Vendedor</option>
                                <option value="Cliente" <?= ($usuario['Rol'] === 'Cliente') ? 'selected' : ''; ?>>Cliente</option>
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