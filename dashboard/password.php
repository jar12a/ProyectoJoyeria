<?php
require_once '../confi/conexion.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = trim($_POST['email']);

    // Verificar si el correo existe en la base de datos
    $stmt = $pdo->prepare("SELECT id FROM usuario WHERE correo = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        $error_message = "Este correo no existe.";
    } else {
        // Redirigir a codigo_recu.php si el correo existe
        header("Location: codigo_recu.php?email=" . urlencode($email));
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Restablecer la contraseña</title>
        <link rel="stylesheet" href="dashboard/styles.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
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
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Recuperar la contraseña</h3></div>
                                    <div class="card-body">
                                        <?php if (!empty($error_message)): ?>
                                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                                        <?php endif; ?>
                                        <div class="small mb-3 text-muted">Ingrese su correo electrónico y se le enviará un un enlace para restablecer su contraseña.</div>
                                        <form action="password.php" method="POST">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" name="email" type="email" placeholder="name@example.com" required />
                                                <label for="inputEmail">Direccion del correo electrónico</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="login.php">Regresar al inicio de sesión</a>
                                                <button type="submit" class="btn btn-primary">Recuperar contraseña</button>
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
            <div id="layoutAuthentication_footer" class="footer-custom">
                <footer>
                    <div class="container-fluid px-4">
                        <div class="text-muted">&copy; 2025 Proyecto Joyeria</div>
                        <div>
                            <a href="#">Políticas de privacidad</a>
                            &middot;
                            <a href="#">Términos &amp; Condiciones</a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
