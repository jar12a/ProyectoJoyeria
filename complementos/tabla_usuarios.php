<?php
include "../confi/session_start.php";
// consultas sql
include '../confi/conexion.php'; // crea la conexion con la base de datos

// Manejar la actualización de datos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $usuario = htmlspecialchars($_POST['usuario']);
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
    $nombre = htmlspecialchars($_POST['nombre']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $direccion = htmlspecialchars($_POST['direccion']);
    $correo = htmlspecialchars($_POST['correo']);
    $rol = htmlspecialchars($_POST['rol']);

    try {
        $query = "UPDATE usuario SET usuario = ?, nombre = ?, telefono = ?, direccion = ?, correo = ?, idRol = (SELECT id FROM rol WHERE Rol = ?)";
        $params = [$usuario, $nombre, $telefono, $direccion, $correo, $rol];

        // Si se proporciona una nueva contraseña, incluirla en la consulta
        if ($password) {
            $query .= ", password = ?";
            $params[] = $password;
        }

        $query .= " WHERE id = ?";
        $params[] = $id;

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);

        // Redirigir para evitar reenvío de datos
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
        exit();
    } catch (PDOException $e) {
        die("Error al actualizar los datos: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    include "../complementos/head_html.php";
    ?>
</head>

<body class="sb-nav-fixed">
    <?php
    include "../complementos/dashboard_head.php";
    ?>

    <!--Barra de navegación -->
    <div id="layoutSidenav">
        <?php
        include "../complementos/dashboard_menu.php";
        ?><!--//Agregar todo para el cuerpo-->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Barra de navegación</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="../dashboard/principal.php">Menú</a></li>
                            <li class="breadcrumb-item active">Inicio</li>
                        </ol>
                        <div class="card mb-4">

                        </div>
                        <h1 class="mt-4">Imperial Gems</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>

                        <?php
                        // Mostrar mensajes de éxito o error
                        if (isset($_GET['success']) && $_GET['success'] == 1) {
                            echo '<div class="alert alert-success">Usuario agregado/actualizado correctamente.</div>';
                        }
                        if (isset($_GET['error']) && $_GET['error'] == 1) {
                            echo '<div class="alert alert-danger">Error al agregar/actualizar el usuario.</div>';
                        }
                        ?>

                        <!--//tabla de usuarios-->
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Usuarios
                            </div>

                            <div class="card-body">
                                <!-- Botón para agregar nuevo usuario -->
                                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#agregarUsuarioModal">
                                    Agregar Nuevo Usuario
                                </button>

                                <!-- Tabla para mostrar los datos -->
                                <div class="table-responsive">
                                    <?php
                                    // Consulta para obtener los datos de los usuarios y sus roles
                                    $query = "SELECT usuario.id, usuario.usuario, usuario.password, usuario.nombre, usuario.telefono, 
                                        usuario.direccion, usuario.correo, rol.Rol 
                                    FROM usuario 
                                    INNER JOIN rol ON usuario.idRol = rol.id";

                                    try {
                                        $stmt = $pdo->query($query); // Ejecutar la consulta
                                        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener los resultados
                                    } catch (PDOException $e) {
                                        die("Error al obtener los datos: " . $e->getMessage());
                                    }
                                    ?>
                                    <!-- Mostrar la tabla de usuario -->
                                    <table id="datatablesSimple" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Usuario</th>
                                                <th>Nombre</th>
                                                <th>Correo</th>
                                                <th>Rol</th>
                                                <th>Acciones</th> <!-- Para editar o eliminar -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($usuarios as $usuario): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($usuario['id']); ?></td>
                                                    <td><?= htmlspecialchars($usuario['usuario']); ?></td>
                                                    <td><?= htmlspecialchars($usuario['nombre']); ?></td>
                                                    <td><?= htmlspecialchars($usuario['correo']); ?></td>
                                                    <td><?= htmlspecialchars($usuario['Rol']); ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal"
                                                            onclick="editarUsuario(<?= htmlspecialchars($usuario['id']); ?>, '<?= htmlspecialchars($usuario['usuario']); ?>', '<?= htmlspecialchars($usuario['nombre']); ?>', '<?= htmlspecialchars($usuario['telefono']); ?>', '<?= htmlspecialchars($usuario['direccion']); ?>', '<?= htmlspecialchars($usuario['correo']); ?>', '<?= htmlspecialchars($usuario['Rol']); ?>')">
                                                            Editar
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php
            include "../complementos/footer_dashboard.php";
            ?>
        </div>
    </div>

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
                    <form id="formAgregarUsuario" action="../complementos/agregar_usuario.php" method="POST">
                        <div class="mb-3">
                            <label for="nuevo_usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="nuevo_usuario" name="usuario" required>
                            <div id="usuarioError" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="nuevo_password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="nuevo_password" name="password" required>
                            <div class="form-check mt-2">
                                <input type="checkbox" class="form-check-input" id="mostrarPassword">
                                <label class="form-check-label" for="mostrarPassword">Mostrar contraseña</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nuevo_nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nuevo_nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="nuevo_telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="nuevo_telefono" name="telefono">
                        </div>
                        <div class="mb-3">
                            <label for="nuevo_direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="nuevo_direccion" name="direccion">
                        </div>
                        <div class="mb-3">
                            <label for="nuevo_correo" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="nuevo_correo" name="correo" required>
                            <div id="correoError" class="text-danger"></div>
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
                            <button id="btnAgregar" type="submit" name="agregar_usuario" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Edición -->
    <div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario de edición de usuario -->
                    <form action="" method="POST">
                        <input type="hidden" name="id" id="usuario_id">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="*****">
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
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts para validaciones en tiempo real -->
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
        });

        // Función para cargar los datos del usuario en el modal de edición
        function editarUsuario(id, usuario, nombre, telefono, direccion, correo, rol) {
            document.getElementById('usuario_id').value = id;
            document.getElementById('usuario').value = usuario;
            document.getElementById('password').value = ''; // Campo de contraseña vacío para encriptar cuando se edite
            document.getElementById('password').setAttribute('placeholder', '*********'); // Para que aparezca oculto como ***** si no se edita
            document.getElementById('nombre').value = nombre;
            document.getElementById('telefono').value = telefono;
            document.getElementById('direccion').value = direccion;
            document.getElementById('correo').value = correo;

            // Selecciona el rol correspondiente
            let rolSelect = document.getElementById('rol');
            for (let i = 0; i < rolSelect.options.length; i++) {
                if (rolSelect.options[i].value === rol) {
                    rolSelect.selectedIndex = i;
                    break;
                }
            }
        }
    </script>
</body>
</html>

