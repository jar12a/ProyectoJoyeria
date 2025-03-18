<?php
// Incluir el archivo de conexión
$host = 'localhost: 3307'; // O tu host de base de datos
$usuario = 'root';   // Tu usuario de base de datos
$contrasena = '';    // Tu contraseña de base de datos
$nombre_bd = 'sistema_gestion'; // El nombre de tu base de datos

try {
    // Aquí se establece la conexión
    $conn = new PDO("mysql:host=$host;dbname=$nombre_bd", $usuario, $contrasena);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Conexión fallida: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los valores del formulario
    $usuario = $_POST['usuario'];
    $password = sha1($_POST['password']); // Hashea la contraseña por seguridad
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];

    // Validar que el correo sea válido
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "Correo electrónico no válido.";
    } else {
        // Verificar si el usuario ya existe
        $checkUserQuery = "SELECT COUNT(*) FROM usuario WHERE usuario = :usuario";
        $stmt = $conn->prepare($checkUserQuery);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $userExists = $stmt->fetchColumn();

        // Verificar si el correo ya está registrado
        $checkEmailQuery = "SELECT COUNT(*) FROM usuario WHERE correo = :correo";
        $stmt = $conn->prepare($checkEmailQuery);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        $emailExists = $stmt->fetchColumn();

        if ($userExists > 0) {
            // Si el usuario existe, sugerir un nombre alternativo
            $recomendedUser = $nombre . rand(1, 1000); // Generamos un nombre con un número aleatorio
            $mensaje = "El usuario ya existe. Te recomendamos el siguiente usuario: $recomendedUser";
            // Aquí podemos redirigir o dar la opción al usuario de usar el nombre sugerido
        } elseif ($emailExists > 0) {
            $mensaje = "El correo electrónico ya está registrado. Por favor, usa otro.";
        } else {
            // Preparar la consulta SQL para insertar un nuevo usuario
            $query = "INSERT INTO usuario (usuario, password, nombre, telefono, direccion, idRol, correo) 
                      VALUES (:usuario, :password, :nombre, :telefono, :direccion, 
                              (SELECT id FROM rol WHERE rol = :rol LIMIT 1), :correo)";

            // Preparar la sentencia
            $stmt = $conn->prepare($query);

            // Vincular los parámetros
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':correo', $correo);

            // Ejecutar la sentencia
            if ($stmt->execute()) {
                $mensaje = "Usuario agregado correctamente";
            } else {
                $mensaje = "Hubo un error al agregar el usuario";
            }
        }
    }
}
?>
<br>
<!-- Modal de Agregar Usuario -->
<div class="modal fade" id="agregarUsuarioModal" tabindex="-1" aria-labelledby="agregarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarUsuarioModalLabel">Agregar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario de Agregar Usuario -->
                <form action="" method="POST"> <!-- El formulario envía al mismo archivo -->
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="*****" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <select class="form-select" id="rol" name="rol" required>
                            <option value="Administrador">Administrador</option>
                            <option value="Vendedor">Vendedor</option>
                            <option value="Cliente">Cliente</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Botón para abrir el modal de agregar usuario -->
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarUsuarioModal">
    Agregar Usuario
</button>

<?php if (isset($mensaje)) : ?>
    <div class="alert alert-info mt-3" role="alert">
        <?php echo $mensaje; ?>
    </div>
<?php endif; ?>

<?php
// Finaliza el buffer de salida y lo limpia
ob_end_flush();
?>
<br><br>