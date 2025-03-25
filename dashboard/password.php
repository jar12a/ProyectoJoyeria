<?php
session_start();
require_once '../confi/conexion.php';
include '../complementos/head.php';

$error_message = '';
$success_message = '';

// Incluir privilegios para manejar visitantes adecuadamente
if (!function_exists('getRolActual')) {
    include_once 'privilegios.php';
}

// Verificar si hay un mensaje de error de otra página
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Limpiar el mensaje después de mostrarlo
}

// Reiniciar el proceso de recuperación si es necesario
if (isset($_GET['reset']) && $_GET['reset'] == 'true') {
    // Limpiar las variables de sesión relacionadas con la recuperación
    unset($_SESSION['recovery_email']);
    unset($_SESSION['recovery_code']);
    unset($_SESSION['recovery_user_id']);
    unset($_SESSION['recovery_username']);
    unset($_SESSION['code_sent']);
    unset($_SESSION['failed_attempts']);
    $success_message = "El proceso de recuperación ha sido reiniciado.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = trim($_POST['email']);

    // Validar formato de correo
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Por favor, ingrese un correo electrónico válido.";
    } else {
        // Verificar si el correo existe en la base de datos
        $stmt = $pdo->prepare("SELECT id, usuario FROM usuario WHERE correo = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if (!$user) {
            $error_message = "No existe ninguna cuenta con este correo electrónico.";
        } else {
            // Limpiar cualquier sesión previa de recuperación para evitar problemas
            unset($_SESSION['recovery_email']);
            unset($_SESSION['recovery_code']);
            unset($_SESSION['recovery_user_id']);
            unset($_SESSION['recovery_username']);
            unset($_SESSION['code_sent']);
            unset($_SESSION['failed_attempts']);
            
            // Almacenar información en la sesión para el seguimiento del proceso
            $_SESSION['recovery_email'] = $email;
            $_SESSION['recovery_user_id'] = $user['id'];
            $_SESSION['recovery_username'] = $user['usuario'];
            
            // Log para depuración
            error_log("Iniciando recuperación para: $email, redirigiendo a codigo_recu.php");
            
            // Redirigir a codigo_recu.php si el correo existe
            header("Location: codigo_recu.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Recuperación de contraseña para Imperial Gems" />
    <meta name="author" content="Imperial Gems" />
    <title>Restablecer la contraseña - Imperial Gems</title>
    <link href="/ProyectoJoyeria/dashboard/css/styles.css" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
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
                                    <h3 class="text-center font-weight-light my-4">Recuperar la contraseña</h3>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($error_message)): ?>
                                        <div class="alert alert-danger">
                                            <i class="fas fa-exclamation-circle me-2"></i>
                                            <?php echo $error_message; ?>
                                        </div>
                                        <?php if (isset($_SESSION['recovery_email'])): ?>
                                            <div class="text-center mb-3">
                                                <a href="password.php?reset=true" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-redo me-2"></i>Reiniciar proceso
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if (!empty($success_message)): ?>
                                        <div class="alert alert-success">
                                            <i class="fas fa-check-circle me-2"></i>
                                            <?php echo $success_message; ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="small mb-3 text-muted">Ingrese su correo electrónico y le enviaremos un código de verificación para restablecer su contraseña.</div>
                                    <form action="password.php" method="POST">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" name="email" type="email" placeholder="name@example.com" required />
                                            <label for="inputEmail">Dirección de correo electrónico</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="login.php">Regresar al inicio de sesión</a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-paper-plane me-2"></i>Enviar código
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="registro.php">¿Necesita una cuenta? ¡Regístrese!</a></div>
                                    <div class="small mt-2"><a href="../index.php">Volver al sitio principal</a></div>
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
                        <div class="text-muted">&copy; 2025 Imperial Gems</div>
                        <div>
                            <a href="#">Políticas de privacidad</a>
                            &middot;
                            <a href="#">Términos &amp; Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <?php include '../complementos/footer.php'; ?>
</body>

</html>