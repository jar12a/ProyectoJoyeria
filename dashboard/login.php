<?php
require "../confi/conexion.php"; // Incluye la conexión PDO

session_start(); // Iniciar sesión

$error_message = '';

if ($_POST) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Preparar la consulta con PDO para evitar inyección SQL
    $sql = "SELECT id, password, nombre, idRol FROM usuario WHERE usuario = :usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
    $stmt->execute();

    $num = $stmt->rowCount();

    if ($num > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $password_bd = $row['password']; // Contraseña almacenada en BD
        $pass_c = sha1($password); // Cifrar la contraseña ingresada

        if ($password_bd == $pass_c) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['idRol'] = $row['idRol'];
            
            // Redirigir según el rol del usuario
            if ($row['idRol'] == 3) {
                $redirect = '../index.php';
            } else {
                $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'principal.php';
            }
            
            // función del modal de inicio de session correctamente
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var myModal = new bootstrap.Modal(document.getElementById('successModal'));
                        myModal.show();
                        setTimeout(function() {
                            myModal.hide();
                            window.location.href = '$redirect';
                        }, 2000);
                    });
                  </script>";
        } else {
            $error_message = "La contraseña no es válida";
        }
    } else {
        $error_message = "No existe usuario";
    }
}
?>

<?php include '../complementos/head.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Inicio de sesión</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <!--  -->
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" name="usuario" type="text" placeholder="Ingrese su usuario" />
                                            <label for="inputEmail">Usuario</label>
                                        </div>
                                        <!-- Campo de entrada para la contraseña -->
                                        <div class="form-floating mb-3">
                                            <input class="form-control <?php echo !empty($error_message) ? 'is-invalid' : ''; ?>" id="inputPassword" name="password" type="password" placeholder="Password" />
                                            <label for="inputPassword">Contraseña</label>
                                            <?php if (!empty($error_message)): ?>
                                                <div class="invalid-feedback">
                                                    <?php echo $error_message; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Checkbox para alternar la visibilidad de la contraseña -->
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" id="inputRememberPassword" type="checkbox" onclick="togglePassword()" />
                                            <label class="form-check-label" for="inputRememberPassword">Ver contraseña</label>
                                        </div>

                                        <!-- Script para alternar la visibilidad de la contraseña -->
                                        <script>
                                            function togglePassword() {
                                                // Obtiene el campo de contraseña por su ID
                                                var passwordField = document.getElementById("inputPassword");

                                                // Si el tipo de input es "password", lo cambia a "text" para mostrar la contraseña
                                                // Si el tipo de input es "text", lo cambia a "password" para ocultarla nuevamente
                                                passwordField.type = passwordField.type === "password" ? "text" : "password";
                                            }
                                        </script>

                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="password.html">¿No recuerdas la contraseña?</a>
                                            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                                            
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="registro.php">¿Necesitas una cuenta? ¡Registrate!</a></div>
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
                        <div class="text-muted">Copyright &copy; 2024</div>
                        <div>
                            <a href="#">Políticas de Privacidad</a>
                            &middot;
                            <a href="#">Terminos y &amp; Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal de éxito de inicio de sesion -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Inicio de sesión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="https://media.giphy.com/media/111ebonMs90YLu/giphy.gif" alt="Verificación" style="width: 50px; height: 50px;">
                    <p>Inicio de sesión correctamente</p>
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