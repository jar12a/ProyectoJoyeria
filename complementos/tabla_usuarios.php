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
        header("Location: " . $_SERVER['PHP_SELF']);
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
                        //
                        include_once 'agregar_usuario.php';

                        ?>





                        <!--//tabla de usuarios-->
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Usuarios
                            </div>

                            <div class="card-body">
                                <?php
                                // include "usuarios.php";
                                //hace posible la edicion de datos y que carguen sus datos
                                include "../complementos/cargar_usuarios.php";
                                ?>



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

                                <!-- Tabla para mostrar los datos -->
                                <form action="" method="POST">
                                    <div class="table-responsive">
                                        <?php
                                        include "../confi/conexion.php"; // Asegúrate de que la ruta es correcta

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
                                                                onclick="editarUsuario(<?= htmlspecialchars($usuario['id']); ?>, '<?= htmlspecialchars($usuario['usuario']); ?>', '<?= htmlspecialchars($usuario['password']); ?>', '<?= htmlspecialchars($usuario['nombre']); ?>', '<?= htmlspecialchars($usuario['telefono']); ?>', '<?= htmlspecialchars($usuario['direccion']); ?>', '<?= htmlspecialchars($usuario['correo']); ?>', '<?= htmlspecialchars($usuario['Rol']); ?>')">
                                                                Editar
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>

                                        <!-- Script para inicializar DataTable -->
                                        <script>
                                            $(document).ready(function() {
                                                $('#datatablesSimple').DataTable(); // Inicializa DataTable en la tabla con id datatablesSimple
                                            });

                                            // Función para cargar los datos del usuario en el modal
                                            function editarUsuario(id, usuario, password, nombre, telefono, direccion, correo, rol) {
                                                document.getElementById('usuario_id').value = id;
                                                document.getElementById('usuario').value = usuario;
                                                document.getElementById('password').value = ''; // Campo de contraseña vacío para encriptar cuando se edite
                                                document.getElementById('password').setAttribute('placeholder', '*****'); // Para que aparezca oculto como ***** si no se edita
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
                                    </div>
                                </form>




                            </div>
                        </div>
                    </div>
            </main>
            <?php
            include "../complementos/footer_dashboard.php";
            ?>
        </div>
    </div>
</body>

</html>