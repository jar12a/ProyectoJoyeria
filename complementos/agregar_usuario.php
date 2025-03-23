<!-- Botón para agregar nuevo usuario -->
<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#agregarUsuarioModal">
    Agregar Nuevo Usuario
</button>

<!-- Modal para agregar nuevo usuario -->
<div class="modal fade" id="agregarUsuarioModal" tabindex="-1" aria-labelledby="agregarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarUsuarioModalLabel">Agregar Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario para agregar nuevo usuario -->
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nuevo_usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="nuevo_usuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="nuevo_password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="nuevo_password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="nuevo_nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nuevo_nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="nuevo_telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="nuevo_telefono" name="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="nuevo_direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="nuevo_direccion" name="direccion" required>
                    </div>
                    <div class="mb-3">
                        <label for="nuevo_correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="nuevo_correo" name="correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="nuevo_rol" class="form-label">Rol</label>
                        <select class="form-select" id="nuevo_rol" name="rol" required>
                            <option value="Administrador">Administrador</option>
                            <option value="Vendedor">Vendedor</option>
                            <option value="Cliente">Cliente</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" name="agregar_usuario" class="btn btn-primary">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Incluir la conexión a la base de datos
include_once '../confi/conexion.php';

// Procesar el formulario de agregar usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_usuario'])) {
    // Obtener los datos del formulario
    $usuario = $_POST['usuario'];
    // Encriptar la contraseña
    $passwordHash = SHA1($password);
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];

    // Insertar el nuevo usuario en la base de datos
    $query = "INSERT INTO usuario (usuario, password, nombre, telefono, direccion, correo, idRol) 
              VALUES (:usuario, :password, :nombre, :telefono, :direccion, :correo, (SELECT id FROM rol WHERE Rol = :rol))";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'usuario' => $usuario,
        'password' => $password,
        'nombre' => $nombre,
        'telefono' => $telefono,
        'direccion' => $direccion,
        'correo' => $correo,
        'rol' => $rol
    ]);

    // Redirigir usando JavaScript
    if ($stmt->rowCount() > 0) {
        echo '<script>window.location.href = "tabla_usuarios.php?success=1";</script>'; // Redirige con mensaje de éxito
        exit;
    } else {
        echo '<script>window.location.href = "tabla_usuarios?error=1";</script>'; // Redirige con mensaje de error
        exit;
    }
}

// Mostrar mensaje de éxito o error (esto solo se ejecutará si no se redirige)
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo '<div class="alert alert-success">Usuario agregado correctamente.</div>';
}
if (isset($_GET['error']) && $_GET['error'] == 1) {
    echo '<div class="alert alert-danger">Error al agregar el usuario.</div>';
}

// Incluir el archivo para cargar los usuarios
include '../complementos/cargar_usuarios.php';
?>