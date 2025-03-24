<<<<<<< HEAD
<?php
// Incluir la conexión a la base de datos
include_once '../confi/conexion.php';

// Procesar el formulario de agregar usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_usuario'])) {
    // Obtener los datos del formulario
    $usuario = trim($_POST['usuario']);
    $password = sha1($_POST['password']); // Convertir la contraseña a SHA1
    $nombre = trim($_POST['nombre']);
    $telefono = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion']);
    $correo = trim($_POST['correo']);
    $rol = $_POST['rol'];

    // Validar campos obligatorios
    if (empty($usuario) || empty($nombre) || empty($correo) || empty($_POST['password'])) {
        echo json_encode(['status' => 'error', 'message' => 'Todos los campos obligatorios deben estar completos.']);
        exit;
    }

    // Validar formato de correo electrónico
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'El correo electrónico no tiene un formato válido.']);
        exit;
    }

    // Verificar si el correo ya existe
    $query = "SELECT COUNT(*) as count FROM usuario WHERE correo = :correo";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['correo' => $correo]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        echo json_encode(['status' => 'error', 'message' => 'El correo electrónico ya está registrado.']);
        exit;
    }

    // Verificar si el usuario ya existe
    $query = "SELECT COUNT(*) as count FROM usuario WHERE usuario = :usuario";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['usuario' => $usuario]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        echo json_encode(['status' => 'error', 'message' => 'El nombre de usuario ya está registrado.']);
        exit;
    }

    // Insertar el nuevo usuario en la base de datos
    $query = "INSERT INTO usuario (usuario, password, nombre, telefono, direccion, correo, idRol) 
              VALUES (:usuario, :password, :nombre, :telefono, :direccion, :correo, (SELECT id FROM rol WHERE Rol = :rol))";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'usuario' => $usuario,
        'password' => $password, // Contraseña en SHA1
        'nombre' => $nombre,
        'telefono' => $telefono,
        'direccion' => $direccion,
        'correo' => $correo,
        'rol' => $rol
    ]);

    // Redirigir usando JavaScript
    if ($stmt->rowCount() > 0) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('successModal'));
                myModal.show();
                setTimeout(function() {
                    myModal.hide();
                    window.location.href = '../complementos/tabla_usuarios.php?success=1';
                }, 2000);
            });
        </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('modalError'));
                myModal.show();
                setTimeout(function() {
                    myModal.hide();
                    window.location.href = '../complementos/tabla_usuarios.php?error=1';
                }, 2000);
            });
        </script>";
    }
}


?>
<!-- Modal de Éxito -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Éxito</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Usuario registrado con exito.
            </div>
        </div>
    </div>
</div>

<!-- Modal de Error -->
<div class="modal fade" id="modalError" tabindex="-1" aria-labelledby="modalErrorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalErrorLabel">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Hubo un error al registrar al usuario.
            </div>
        </div>
    </div>
</div>


=======
>>>>>>> rol-+-extras
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
<<<<<<< HEAD
                <form id="formAgregarUsuario" method="POST">
                    <div class="mb-3">
                        <label for="nuevo_usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="nuevo_usuario" name="usuario" required>
                        <div id="usuarioError" class="text-danger"></div>
=======
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nuevo_usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="nuevo_usuario" name="usuario" required>
>>>>>>> rol-+-extras
                    </div>
                    <div class="mb-3">
                        <label for="nuevo_password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="nuevo_password" name="password" required>
<<<<<<< HEAD
                        <div class="form-check mt-2">
                            <input type="checkbox" class="form-check-input" id="mostrarPassword">
                            <label class="form-check-label" for="mostrarPassword">Mostrar contraseña</label>
                        </div>
=======
>>>>>>> rol-+-extras
                    </div>
                    <div class="mb-3">
                        <label for="nuevo_nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nuevo_nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="nuevo_telefono" class="form-label">Teléfono</label>
<<<<<<< HEAD
                        <input type="text" class="form-control" id="nuevo_telefono" name="telefono">
                    </div>
                    <div class="mb-3">
                        <label for="nuevo_direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="nuevo_direccion" name="direccion">
=======
                        <input type="text" class="form-control" id="nuevo_telefono" name="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="nuevo_direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="nuevo_direccion" name="direccion" required>
>>>>>>> rol-+-extras
                    </div>
                    <div class="mb-3">
                        <label for="nuevo_correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="nuevo_correo" name="correo" required>
<<<<<<< HEAD
                        <div id="correoError" class="text-danger"></div>
=======
>>>>>>> rol-+-extras
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
<<<<<<< HEAD
                        <button id="btnAgregar" type="submit" name="agregar_usuario" class="btn btn-primary">Agregar</button>
=======
                        <button type="submit" name="agregar_usuario" class="btn btn-primary">Agregar</button>
>>>>>>> rol-+-extras
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<<<<<<< HEAD
<!-- Scripts para validaciones en tiempo real -->
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Función para habilitar o deshabilitar el botón "Agregar"
        function actualizarBotonAgregar() {
            const usuarioValido = $('#usuarioError').text() === ''; // Si no hay mensaje de error, el usuario es válido
            const correoValido = $('#correoError').text() === ''; // Si no hay mensaje de error, el correo es válido

            if (usuarioValido && correoValido) {
                $('#btnAgregar').prop('disabled', false); // Habilitar el botón
            } else {
                $('#btnAgregar').prop('disabled', true); // Deshabilitar el botón
            }
        }


        // Mostrar/ocultar contraseña
        $('#mostrarPassword').change(function() {
            const passwordInput = $('#nuevo_password');
            if (this.checked) {
                passwordInput.attr('type', 'text');
            } else {
                passwordInput.attr('type', 'password');
            }
        });
        
        // Validar que solo se ingresen números en el campo de teléfono
        $("#nuevo_telefono").on("input", function() {
            let telefono = $(this).val();
            
            // Permitir solo números (elimina cualquier otro carácter)
            telefono = telefono.replace(/\D/g, ""); 

            // Actualiza el campo con el valor filtrado
            $(this).val(telefono);

            // Verifica si el campo está vacío
            if (telefono === "") {
                $("#telefonoError").text("El teléfono solo debe contener números.");
            } else {
                $("#telefonoError").text("");
            }
        });
        
        // Validar usuario en tiempo real
        $('#nuevo_usuario').on('blur', function() {
            const usuario = $(this).val();
            if (usuario) {
                $.ajax({
                    url: '../confi/validar_usuario.php',
                    type: 'POST',
                    data: {
                        usuario: usuario
                    },
                    success: function(response) {
                        $('#usuarioError').text(response); // Mostrar mensaje de error o éxito
                        actualizarBotonAgregar(); // Actualizar el estado del botón
                    }
                });
            } else {
                $('#usuarioError').text(''); // Limpiar el mensaje si el campo está vacío
                actualizarBotonAgregar(); // Actualizar el estado del botón
            }
        });

        // Validar correo en tiempo real
        $('#nuevo_correo').on('blur', function() {
            const correo = $(this).val();
            if (correo) {
                if (!validateEmail(correo)) {
                    $('#correoError').text('El correo electrónico no tiene un formato válido.');
                } else {
                    $.ajax({
                        url: '../confi/validar_correo.php',
                        type: 'POST',
                        data: {
                            correo: correo
                        },
                        success: function(response) {
                            $('#correoError').text(response); // Mostrar mensaje de error o éxito
                            actualizarBotonAgregar(); // Actualizar el estado del botón
                        }
                    });
                }
            } else {
                $('#correoError').text(''); // Limpiar el mensaje si el campo está vacío
                actualizarBotonAgregar(); // Actualizar el estado del botón
            }
        });

        // Función para validar formato de correo
        function validateEmail(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }

        // Función para mostrar el modal
        function mostrarModal() {
            var myModal = new bootstrap.Modal(document.getElementById('modalError'));
            myModal.show(); // Mostrar el modal

            // Ocultar el modal después de 3 segundos
            setTimeout(function() {
                myModal.hide();
            }, 3000);
        }
    });
</script>
=======
<?php
// Incluir la conexión a la base de datos
include_once '../confi/conexion.php';

// Procesar el formulario de agregar usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_usuario'])) {
    // Obtener los datos del formulario
    $usuario = $_POST['usuario'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];

   
// Incluir la conexión a la base de datos
include_once '../confi/conexion.php';

// Procesar el formulario de agregar usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_usuario'])) {
    // Obtener los datos del formulario
    $usuario = $_POST['usuario'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña
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

    // Redirigir para evitar el reenvío del formulario
    if ($stmt->rowCount() > 0) {
        header("Location: principal.php?success=1"); // Redirige a la misma página con un mensaje de éxito
        exit;
    } else {
        header("Location: principal.php?error=1"); // Redirige a la misma página con un mensaje de error
        exit;
    }
}

    // Mostrar mensaje de éxito o error
    if ($stmt->rowCount() > 0) {
        echo '<div class="alert alert-success">Usuario agregado correctamente.</div>';
    } else {
        echo '<div class="alert alert-danger">Error al agregar el usuario.</div>';
    }
}

include '../complementos/cargar_usuarios.php';
?>

>>>>>>> rol-+-extras
