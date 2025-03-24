<?php
session_start();
require_once '../confi/conexion.php';

// Incluir privilegios para manejar visitantes adecuadamente
if (!function_exists('getRolActual')) {
    include_once 'privilegios.php';
}

// Log para depuración
error_log("recucontra.php - Inicio de página");
error_log("Email: " . (isset($_SESSION['recovery_email']) ? $_SESSION['recovery_email'] : 'no definido'));
error_log("Código: " . (isset($_SESSION['recovery_code']) ? $_SESSION['recovery_code'] : 'no definido'));
error_log("Token: " . (isset($_SESSION['recovery_token']) ? $_SESSION['recovery_token'] : 'no definido'));

$error_message = '';
$success_message = '';

// Verificar si llegamos desde codigo_recu.php con la información necesaria
if (!isset($_SESSION['recovery_email']) || !isset($_SESSION['recovery_code'])) {
    // Si no hay email o código en la sesión, redirigir al inicio del proceso
    $_SESSION['error_message'] = "Para restablecer su contraseña, debe completar todos los pasos.";
    error_log("recucontra.php - Redirección a password.php: falta email o código");
    header("Location: password.php");
    exit();
}

$email = $_SESSION['recovery_email'];
$codigo = $_SESSION['recovery_code'];
error_log("recucontra.php - Email: $email, Código: $codigo");

// Verificar si el código es válido (comparando con el almacenado en sesión)
if (!isset($_SESSION['recovery_token']) || $_SESSION['recovery_token'] != $codigo) {
    // El código no es válido, redirigir al inicio del proceso
    $_SESSION['error_message'] = "El código de verificación ha expirado o no es válido. Por favor, inicie el proceso nuevamente.";
    
    // Registrar el error para depuración
    error_log("Código inválido para correo: $email, código: $codigo, token en sesión: " . 
              (isset($_SESSION['recovery_token']) ? $_SESSION['recovery_token'] : 'no establecido'));
    
    header("Location: password.php");
    exit();
}

// Si llegamos aquí, el código es válido y podemos mostrar el formulario para cambiar la contraseña
error_log("recucontra.php - Código válido, mostrando formulario");

// Procesar el formulario cuando se envía la nueva contraseña
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password'], $_POST['confirm_password'])) {
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    // Validar la contraseña
    if (strlen($password) < 6) {
        $error_message = "La contraseña debe tener al menos 6 caracteres.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Las contraseñas no coinciden.";
    } else {
        // Actualizar la contraseña usando SHA-1 en lugar de password_hash
        $hashed_password = sha1($password);
        
        try {
            $stmt = $pdo->prepare("UPDATE usuario SET password = ? WHERE correo = ?");
            $stmt->execute([$hashed_password, $email]);
            
            if ($stmt->rowCount() > 0) {
                $success_message = "Su contraseña ha sido actualizada correctamente.";
                error_log("recucontra.php - Contraseña actualizada para: $email");
                
                // Limpiar las variables de sesión relacionadas con la recuperación
                unset($_SESSION['recovery_email']);
                unset($_SESSION['recovery_code']);
                unset($_SESSION['recovery_user_id']);
                unset($_SESSION['recovery_username']);
                unset($_SESSION['code_sent']);
                unset($_SESSION['failed_attempts']);
                unset($_SESSION['recovery_token']);
                
                // Establecer un mensaje para redirigir al login después de 5 segundos
                $_SESSION['login_message'] = "Contraseña actualizada correctamente. Ya puede iniciar sesión con su nueva contraseña.";
                
                // Programar redirección mediante JavaScript
                $redirect = true;
            } else {
                $error_message = "No se pudo actualizar la contraseña. Por favor, intente nuevamente.";
                error_log("No se pudo actualizar la contraseña para el correo: $email");
            }
        } catch (PDOException $e) {
            $error_message = "Error en la base de datos: " . $e->getMessage();
            error_log("Error de base de datos al actualizar contraseña: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Restablecimiento de contraseña para Imperial Gems">
    <meta name="author" content="Imperial Gems">
    <title>Restablecer Contraseña - Imperial Gems</title>
    <link href="css/styles_dashboard.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                                    <h3 class="text-center font-weight-light my-4">Restablecer Contraseña</h3>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($error_message)): ?>
                                        <div class="alert alert-danger">
                                            <i class="fas fa-exclamation-circle me-2"></i>
                                            <?php echo $error_message; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($success_message)): ?>
                                        <div class="alert alert-success">
                                            <i class="fas fa-check-circle me-2"></i>
                                            <?php echo $success_message; ?>
                                            <?php if (isset($redirect)): ?>
                                                <div class="mt-2">
                                                    Redirigiendo al inicio de sesión en <span id="countdown">5</span> segundos...
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (empty($success_message)): ?>
                                    <div class="text-center mb-4">
                                        <i class="fas fa-key fa-3x text-primary mb-3"></i>
                                        <p>Ingrese su nueva contraseña</p>
                                    </div>
                                    
                                    <form action="recucontra.php" method="POST" id="passwordForm">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="password" name="password" type="password" 
                                                placeholder="Nueva contraseña" required minlength="6">
                                            <label for="password">Nueva contraseña</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="confirm_password" name="confirm_password" type="password" 
                                                placeholder="Confirmar contraseña" required minlength="6">
                                            <label for="confirm_password">Confirmar contraseña</label>
                                        </div>
                                        <div class="password-strength mb-3">
                                            <div class="progress" style="height: 7px;">
                                                <div id="password-strength-bar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                            </div>
                                            <small id="passwordHelp" class="form-text text-muted">Fortaleza de la contraseña: <span id="password-strength-text">No ingresada</span></small>
                                        </div>
                                        <div class="d-grid gap-2 mt-4">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-2"></i>Guardar Nueva Contraseña
                                            </button>
                                        </div>
                                    </form>
                                    <?php else: ?>
                                    <div class="d-grid mt-4">
                                        <a href="login.php" class="btn btn-primary">
                                            <i class="fas fa-sign-in-alt me-2"></i>Ir al Inicio de Sesión
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small">
                                        <a href="../index.php">Volver al sitio principal</a>
                                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php if (isset($redirect)): ?>
    <script>
        // Redirección automática después de 5 segundos
        let timeLeft = 5;
        const countdownElement = document.getElementById('countdown');
        
        const timer = setInterval(function() {
            timeLeft--;
            countdownElement.textContent = timeLeft;
            
            if (timeLeft <= 0) {
                clearInterval(timer);
                window.location.href = 'login.php';
            }
        }, 1000);
    </script>
    <?php endif; ?>
    
    <script>
        // Verificar la fortaleza de la contraseña
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('confirm_password');
        const strengthBar = document.getElementById('password-strength-bar');
        const strengthText = document.getElementById('password-strength-text');
        
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            // Criterios para la fortaleza de la contraseña
            if (password.length >= 6) strength += 20;
            if (password.length >= 8) strength += 10;
            if (/[A-Z]/.test(password)) strength += 20;
            if (/[a-z]/.test(password)) strength += 10;
            if (/[0-9]/.test(password)) strength += 20;
            if (/[^A-Za-z0-9]/.test(password)) strength += 20;
            
            // Actualizar el indicador
            strengthBar.style.width = strength + '%';
            
            // Cambiar el color según la fortaleza
            if (strength < 30) {
                strengthBar.className = 'progress-bar bg-danger';
                strengthText.textContent = 'Débil';
            } else if (strength < 60) {
                strengthBar.className = 'progress-bar bg-warning';
                strengthText.textContent = 'Media';
            } else {
                strengthBar.className = 'progress-bar bg-success';
                strengthText.textContent = 'Fuerte';
            }
        });
        
        // Verificar que las contraseñas coincidan
        const form = document.getElementById('passwordForm');
        form.addEventListener('submit', function(event) {
            if (passwordInput.value !== confirmInput.value) {
                event.preventDefault();
                alert('Las contraseñas no coinciden');
            }
        });
    </script>
</body>
</html>