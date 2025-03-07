<?php
require_once '../confi/conexion.php'; // crea la conexion con la base de datos

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si los campos existen en $_POST
    if (isset($_POST['usuario'], $_POST['nombre'], $_POST['correo'], $_POST['password'], $_POST['passwordConfirm'], $_POST['telefono'], $_POST['direccion'])) {
        // Recibir los datos del formulario
        $usuario = $_POST['usuario'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $password = $_POST['password'];
        $passwordConfirm = $_POST['passwordConfirm'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];

        // Verificar que las contraseñas coincidan
        if ($password !== $passwordConfirm) {
            $error_message['password'] = "Las contraseñas no coinciden.";
        } else {
            // Verificar si el usuario o correo ya existen
            $stmt = $pdo->prepare("SELECT id, usuario, correo FROM usuario WHERE usuario = ? OR correo = ?");
            $stmt->execute([$usuario, $correo]);
            $existingUser = $stmt->fetch();

            if ($existingUser) {
                // Si el usuario o correo existe, determinar cuál
                if ($existingUser['usuario'] == $usuario) {
                    $error_message['usuario'] = "El usuario ya existe.";
                } elseif ($existingUser['correo'] == $correo) {
                    $error_message['correo'] = "El correo ya existe.";
                }
            } else {
                // Encriptar la contraseña
                $passwordHash = SHA1($password);

                // Definir idRol como 3
                $idRol = 3;

                // Preparar la consulta SQL para insertar los datos
                $sql = "INSERT INTO usuario (usuario, password, nombre, telefono, direccion, idRol, correo) VALUES (?, ?, ?, ?, ?, ?, ?)";

                // Preparar la declaración
                $stmt = $pdo->prepare($sql);

                // Ejecutar la declaración con los valores recibidos
                try {
                    $stmt->execute([$usuario, $passwordHash, $nombre, $telefono, $direccion, $idRol, $correo]);
                    echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var myModal = new bootstrap.Modal(document.getElementById('successModal'));
                                myModal.show();
                                setTimeout(function() {
                                    myModal.hide();
                                    window.location.href = 'login.php';
                                }, 2000);
                            });
                          </script>";
                } catch (PDOException $e) {
                    $error_message['general'] = "Error al registrar el usuario: " . $e->getMessage();
                }
            }
        }
    } else {
        $error_message['general'] = "Por favor, complete todos los campos.";
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Registro de usuario" />
    <meta name="author" content="" />
    <title>Registro de Usuario</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <?php include '../complementos/head.php'; ?>

    <!-- Incluye los estilos de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">



</head>

<body class="bg-primary">

    <!-- Estilos adicionales para centrar el modal en la pantalla -->
    <style>
        /* Centrar el modal en la pantalla, tanto en dispositivos grandes como pequeños */
        .modal-dialog {
            max-width: 300px;
            /* Ancho máximo del modal */
            margin: 1.75rem auto;
            /* Centramos el modal */
        }
    </style>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Crear cuenta</h3>
                                </div>
                                <div class="card-body">
                                    <form action="registro.php" method="POST">
                                        <div class="form-floating mb-3">
                                            <input class="form-control <?php echo !empty($error_message['usuario']) ? 'is-invalid' : ''; ?>" id="usuario" name="usuario" type="text" placeholder="Ingrese su usuario" required />
                                            <label for="usuario">Nombre de usuario</label>
                                            <?php if (!empty($error_message['usuario'])): ?>
                                                <div class="invalid-feedback">
                                                    <?php echo $error_message['usuario']; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="nombre" name="nombre" type="text" placeholder="Ingrese su nombre" required />
                                            <label for="nombre">Nombre completo</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="telefono" name="telefono" type="text" placeholder="Ingrese su número de celular o teléfono" required maxlength="15" oninput="soloNumeros(event)" />
                                            <label for="telefono">Número de teléfono o celular</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="direccion" name="direccion" type="text" placeholder="Ingrese su dirección" required />
                                            <label for="direccion">Ingrese su dirección</label>
                                        </div>


                                        <!-- Modal de advertencia (Bootstrap 4) -->
                                        <div class="modal fade" id="modalError" tabindex="-1" aria-labelledby="modalErrorLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalErrorLabel">Advertencia</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ¡Solo se permite ingresar números!
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                // Función para permitir solo números y limitar a 15 caracteres
                                                function soloNumeros(event) {
                                                    const input = event.target;
                                                    let valor = input.value;

                                                    // Verificar si se ha ingresado algo que no sea un número
                                                    if (/\D/.test(valor)) {
                                                        mostrarModal(); // Mostrar el modal de advertencia si hay caracteres no numéricos
                                                    }

                                                    // Eliminar caracteres que no sean números
                                                    valor = valor.replace(/\D/g, ''); // Reemplaza todo lo que no sea dígito por vacío

                                                    // Limitar la longitud del valor a 15 caracteres
                                                    if (valor.length > 15) {
                                                        valor = valor.substring(0, 15); // Mantener solo los primeros 15 caracteres
                                                    }

                                                    // Establecer el valor del campo con los números válidos
                                                    input.value = valor;
                                                }

                                                // Función para mostrar el modal
                                                function mostrarModal() {
                                                    var myModal = new bootstrap.Modal(document.getElementById('modalError'));
                                                    myModal.show(); // Mostrar el modal

                                                    // Ocultar el modal después de 3 segundos
                                                    setTimeout(function() {
                                                        myModal.hide();
                                                    }, 2000);
                                                }
                                            </script>
                                        </div>
                                        

                                        <div class="form-floating mb-3">
                                            <input class="form-control <?php echo !empty($error_message['correo']) ? 'is-invalid' : ''; ?>" id="email" name="correo" type="email" placeholder="correo@example.com" required />
                                            <label for="email">Correo Electrónico</label>
                                            <?php if (!empty($error_message['correo'])): ?>
                                                <div class="invalid-feedback">
                                                    <?php echo $error_message['correo']; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input class="form-control <?php echo !empty($error_message['password']) ? 'is-invalid' : ''; ?>" id="password" name="password" type="password" placeholder="Crear una contraseña" required />
                                                    <label for="password">Contraseña</label>
                                                    <?php if (!empty($error_message['password'])): ?>
                                                        <div class="invalid-feedback">
                                                            <?php echo $error_message['password']; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input class="form-control <?php echo !empty($error_message['password']) ? 'is-invalid' : ''; ?>" id="passwordConfirm" name="passwordConfirm" type="password" placeholder="Confirmar contraseña" required />
                                                    <label for="passwordConfirm">Confirmar Contraseña</label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary btn-block">Crear Cuenta</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="login.php">¿Ya tienes una cuenta? Inicia sesión</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; </div>
                        <div>
                            <a href="#">Políticas de Privacidad</a>
                            &middot;
                            <a href="#">Términos &amp; Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal de éxito -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Registro de cuenta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="https://media.giphy.com/media/111ebonMs90YLu/giphy.gif" alt="Verificación" style="width: 50px; height: 50px;">
                    <p>Cuenta creada exitosamente</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>

</body>
<?php include '../complementos/footer.php'; ?>

</html>